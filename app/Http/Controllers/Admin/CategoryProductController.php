<?php

namespace App\Http\Controllers\Admin;

use App\CategoryProduct;
use App\CategoryArticle;
use App\Helpers\Images;
use App\Nested;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryArticleRequest;
use Illuminate\Support\Facades\DB;

class CategoryProductController extends Controller
{
    protected $_nestedCategoryProduct = null;
    protected $_modelCategoryProduct = null;

    public function __construct()
    {
        $this->_modelCategoryProduct = new CategoryProduct();
        $this->_nestedCategoryProduct = new Nested(array(
            'table' => 'category_product',
            'model' => 'CategoryProduct'
        ));
    }

    /**
     * @return $this
     */
    public function productIndex()
    {
        $categories = DB::table($this->_modelCategoryProduct->table)->where('left', '>', 0)->orderBy('left', 'ASC')->get();
        $url = route('product-category-add');
        $urlChangeStatus = route('product-category-status');
        $aliasRouter = 'product-category-edit';
        return view('admin.category-product.index')->with(compact('categories', 'url', 'urlChangeStatus', 'aliasRouter'));
    }

    /**
     * @return $this
     */
    public function productAdd()
    {
        $listCategories = DB::table($this->_modelCategoryProduct->table)->where('left', '>', 0)->orderBy('left', 'ASC')->get();
        $categories = [];
        $categories['1000000'] = 'Danh mục cha';
        if (!empty($listCategories)) {
            foreach ($listCategories as $category) {
                $space = str_repeat('|——', $category->level - 1);
                $categories[$category->id] = $space . $category->name;
            }
        }
        $url = route('product-category-add');
        return view('admin.category-product.form-category')->with(compact('categories', 'url'));
    }

    /**
     * @param Request $request
     */
    public function productChangeStatus(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');
        $category = $this->findById($this->_modelCategoryProduct, $id);
        $category->status = $status;
        $category->save();
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function productPost(CategoryRequest $request)
    {
        $data = $this->_modelCategoryProduct->mapsDataDefault($request->all());
        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $data['image'] = Images::createImage($image);
        }

        $parent = intval($request->get('parent'));
        if ($parent > 0) {
            $this->_nestedCategoryProduct->insertNode($data, $parent, array('position' => 'right'));
        }

        return redirect(route('product-category'));
    }

    /**
     * @param $id
     * @return $this
     */
    public function productEdit($id)
    {
        $category = $this->findById($this->_modelCategoryProduct, $id);

        $categories = DB::table($this->_modelCategoryProduct->table)
            ->where('left', '>', 0)
            ->orderBy('left', 'ASC')->get();
        $url = route('product-category-edit', $id);
        return view('admin.category-product.edit-category')->with(compact('category', 'categories', 'url'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function productStore($id, Request $request)
    {
        $data = $this->_modelCategoryProduct->mapsDataDefault($request->all());
        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $data['image'] = Images::createImage($image);
        }
        if (isset($data['parent']) && $data['parent'] == $id) {
            $data['parent'] = null;
        }
        $data['modified_time'] = date('Y-m-d H:i:s');
        $this->updateNodeCategoryProduct($data, $id, $data['parent']);
        return redirect(route('product-category'));
    }

    protected function updateNodeCategoryProduct($data, $nodeID, $nodeParentID = null)
    {
        if (!empty($nodeParentID)) {
            $nodeParentInfo = $this->findById($this->_modelCategoryProduct, $nodeParentID);
            $nodeInfo = $this->findById($this->_modelCategoryProduct, $nodeID);
            if (!empty($nodeParentInfo) && $nodeInfo->parent != $nodeParentInfo->id) {
                $this->_nestedCategoryProduct->moveRight($nodeID, $nodeParentID);
            }
        }

        $dataUpdate = array();
        foreach ($data as $k => $v) {
            if ($v != null) {
                $dataUpdate[$k] = $v;
            }
        }

        DB::table($this->_modelCategoryProduct->table)
            ->where('id', $nodeID)
            ->update($dataUpdate);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function productDelete($id)
    {
        $category = $this->findById($this->_modelCategoryProduct, $id);
        $this->deleteImage($category->path);
        $nodes = DB::table('categories')->where('parent', $id)->orderBy('left', 'ASC')->get();

        if (!empty($nodes)) {
            foreach ($nodes as $node) {
                $this->moveRight($node->id, $category->parent);
            }
        }
        $this->_nestedCategoryProduct->detachBranch($id, array('task' => 'remove-node'));

        return redirect('/admin/category');
    }
}
