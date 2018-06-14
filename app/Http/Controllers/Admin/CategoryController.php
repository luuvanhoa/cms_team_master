<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Helpers\Images;
use App\Nested;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    protected $_nestedCateProduct = null;
    protected $_nestedCateArticle = null;
    protected $_nestedCateMenuAdmin = null;

    protected $_modelCategory = null;

    public function __construct()
    {
        $this->_nestedCateProduct = new Nested(array(
            'table' => 'category_product',
            'model' => 'Category'
        ));
        $this->_modelCategory = new Category();
        $this->_nestedCateArticle = null;
        $this->_nestedCateMenuAdmin = null;
    }

    /**
     * @return $this
     */
    public function productIndex()
    {
        $categories = DB::table($this->_modelCategory->table)->where('left', '>', 0)->orderBy('left', 'ASC')->get();
        return view('admin.categories.index')->with(compact('categories'));
    }

    /**
     * @return $this
     */
    public function productAdd()
    {
        $listCategories = DB::table($this->_modelCategory->table)->where('left', '>', 0)->orderBy('left', 'ASC')->get();

        $categories = [];
        $categories['1'] = 'Danh mục cha';
        if (!empty($listCategories)) {
            foreach ($listCategories as $category) {
                $space = str_repeat('|——', $category->level - 1);
                $categories[$category->id] = $space . $category->name;
            }
        }

        return view('admin.categories.form-category')->with(compact('categories'));
    }

    /**
     * @param Request $request
     */
    public function productChangeStatus(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');
        $category = $this->findById($this->_modelCategory, $id);
        $category->status = $status;
        $category->save();
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function productPost(CategoryRequest $request)
    {
        $data = $this->_modelCategory->mapsDataDefault($request->all());
        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $data['image'] = Images::createImage($image);
        }

        $parent = intval($request->get('parent'));
        if ($parent > 0) {
            $this->_nestedCateProduct->insertNode($data, $parent, array('position' => 'right'));
        }

        return redirect(route('product-category'));
    }

    /**
     * @param $id
     * @return $this
     */
    public function productEdit($id)
    {
        $category = $this->findById($this->_modelCategory, $id);
        $breadcrumbs = array('category-edit', $category);
        $categories = DB::table($this->_modelCategory->table)
            ->where('left', '>', 0)
            ->orderBy('left', 'ASC')->get();
        return view('admin.categories.edit-category')
            ->with(compact('category', 'breadcrumbs', 'categories'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function productStore($id, Request $request)
    {
        $data = $this->_modelCategory->mapsDataDefault($request->all());
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
            $nodeParentInfo = $this->findById($this->_modelCategory, $nodeParentID);
            $nodeInfo = $this->findById($this->_modelCategory, $nodeID);
            if (!empty($nodeParentInfo) && $nodeInfo->parent != $nodeParentInfo->id) {
                $this->_nestedCateProduct->moveRight($nodeID, $nodeParentID);
            }
        }

        $dataUpdate = array();
        foreach ($data as $k => $v) {
            if ($v != null) {
                $dataUpdate[$k] = $v;
            }
        }

        DB::table($this->_modelCategory->table)
            ->where('id', $nodeID)
            ->update($dataUpdate);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function productDelete($id)
    {
        $categories = Categories::find($id);
        $this->deleteImage($categories->path);

        $nodeInfo = Categories::find($id);
        $nodes = DB::table('categories')->where('parent', $id)->orderBy('left', 'ASC')->get();

        if (!empty($nodes)) {
            foreach ($nodes as $node) {
                $this->moveRight($node->id, $nodeInfo->parent);
            }
        }
        $this->detachBranch($id, array('task' => 'remove-node'));

        return redirect('/admin/category');
    }

}
