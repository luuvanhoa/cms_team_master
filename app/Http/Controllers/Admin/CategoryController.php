<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\CategoryRequest;
use App\Categories;
use Illuminate\Support\Facades\Config;

class CategoryController extends Controller
{
    /**
     * @return $this
     */
    public function productIndex()
    {
        dd($this->_table_list['CATEGORY_PRODUCT']);
        
        $breadcrumbs = array('category', null);
        $categories = DB::table('category_article')->where('left', '>', 0)->orderBy('left', 'ASC')->get();
        return view('admin.categories.index')->with(compact('categories', 'breadcrumbs'));
    }

    /**
     * @return $this
     */
    public function productAdd()
    {
        $breadcrumbs = array('category-add', null);
        $listCategories = DB::table('categories')->where('left', '>', 0)->orderBy('left', 'ASC')->get();

        $categories = [];
        $categories['1'] = 'Danh mục cha';
        if (!empty($listCategories)) {
            foreach ($listCategories as $category) {
                $space = str_repeat('|——', $category->level - 1);
                $categories[$category->id] = $space . $category->name;
            }
        }
        return view('admin.categories.form-category')->with(compact('categories', 'breadcrumbs'));
    }

    /**
     * @param Request $request
     */
    public function productChangeStatus(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');
        $category = Categories::find($id);
        $category->status = $status;
        $category->save();
        //return true;
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function productPost(CategoryRequest $request)
    {
        $image = $request->file('image');
        $data = array(
            'name' => $request->get('name'),
            'status' => $request->get('status'),
            'description' => $request->get('description'),
            'parent' => $request->get('parent')
        );
        if (!empty($request->file('image')))
            $data['image'] = $this->createImage($image);

        $this->insertNode($data, $request->get('parent'), array('position' => 'right'));
        return redirect('admin/category/add');
    }

    /**
     * @param $id
     * @return $this
     */
    public function productEdit($id)
    {
        $category = Categories::find($id);
        $breadcrumbs = array('category-edit', $category);
        $categories = DB::table('categories')
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
        $data = array(
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'status' => $request->get('status'),
            'description' => $request->get('description'),
            'parent' => $request->get('parent')
        );

        $image = $request->file('image');
        if (!empty($image)) {
            $data['image'] = $this->createImage($image);
        }

        if ($data['parent'] == $id)
            $data['parent'] = null;

        $this->updateNode($data, $id, $data['parent']);
        return redirect('/admin/category');
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
