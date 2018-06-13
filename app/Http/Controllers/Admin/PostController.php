<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Http\Requests\PostRequest;
use Auth;

class PostController extends Controller
{
    public function index()
    {
        $breadcrumbs = array('post', null);
        $posts = DB::table('posts')
            ->select('title', 'posts.id', 'categories.name as category_id', 'posts.status', 'posts.created_at', 'users.name as author_id')
            ->leftJoin('categories', 'posts.category_id', '=', 'categories.id')
            ->leftJoin('users', 'posts.author_id', '=', 'users.id')
            ->paginate(15);
        return view('admin.posts.index')->with(compact('posts', 'breadcrumbs'));
    }

    public function addPost()
    {
        $breadcrumbs = array('post-add', null);
        $categories = DB::table('categories')->where('left', '>', 0)->orderBy('left', 'ASC')->get();

        $cate = [];
        $cate['1'] = 'Danh mục cha';
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $space = str_repeat('|——', $category->level - 1);
                $cate[$category->id] = $space . $category->name;
            }
        }
        return view('admin.posts.form-posts')->with(compact('cate', 'breadcrumbs'));
    }

    public function postPost(PostRequest $request)
    {
        $data_post = array(
            'title' => $request->get('title'),
            'category_id' => $request->get('category_id'),
            'status' => $request->get('status'),
            'content' => $request->get('content'),
            'lead' => $request->get('lead'),
            'description' => $request->get('description'),
            'slug' => $request->get('slug'),
            'author_id' => Auth::user()->id
        );

        $image = $request->file('thumbnail');
        if (!empty($request->file('thumbnail'))) {
            $data['thumbnail'] = $this->createImage($image);
        }

        $id_insert = Post::create($data_post);

        // Update slug
        $post = Post::find($id_insert->id);
        $post->slug = str_slug($request->get('title')). '-' . $id_insert->id . '.html';
        $post->save();

        return redirect('admin/post');
    }

    public function editPost($id)
    {
        $post = Post::find($id);
        $breadcrumbs = array('post-edit', $post);

        $listCategories = DB::table('categories')->where('left', '>', 0)->orderBy('left', 'ASC')->get();

        $categories = [];
        $categories['1'] = 'Danh mục cha';
        if (!empty($listCategories)) {
            foreach ($listCategories as $category) {
                $space = str_repeat('|——', $category->level - 1);
                $categories[$category->id] = $space . $category->name;
            }
        }
        return view('admin.posts.edit-post')->with(compact('post', 'categories', 'breadcrumbs'));
    }

    public function storePost($id, Request $request)
    {
        $post = Post::find($id);

        $post->title = $request->get('title');
        $post->content = $request->get('content');
        $post->lead = $request->get('lead');
        $post->description = $request->get('description');
        $post->category_id = $request->get('category_id');
        $post->status = $request->get('status');

        $image = $request->file('thumbnail');
        if (!empty($image)) {
            $post->thumbnail = $this->createImage($image);
        }
        $post->slug = str_slug($request->get('title')) . '-' . $id . '.html';

        $post->save();
        return redirect('/admin/post/edit/' . $id);
    }

    public function delProduct($id)
    {
        $products = Products::find($id);
        $this->deleteImage($products->path);
        $products->delete();
        return redirect('/admin/product');
    }

    public function createImage($image)
    {
        $path = '/img/upload/posts/';
        $name = sha1(Carbon::now()) . '.' . $image->guessExtension();
        $image->move(getcwd() . $path, $name);
        return $path . $name;
    }

    public function deleteImage($oldPath)
    {
        $oldPath = getcwd() . $oldPath;
        @unlink(realpath($oldPath));
    }

    public function changeStatus(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');
        $category = Post::find($id);
        $category->status = $status;
        $category->save();
    }
}
