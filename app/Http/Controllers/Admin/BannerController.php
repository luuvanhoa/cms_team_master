<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Http\Requests\BannerRequest;
use App\Banners;

class BannerController extends Controller
{
    public function index()
    {
        $breadcrumbs = array('banner', null);
        $banners = DB::table('banners')->paginate(15);
        return view('admin.banners.index')->with(compact('banners', 'breadcrumbs'));
    }

    public function addBanner()
    {
        $breadcrumbs = array('banner-add', null);
        return view('admin.banners.form-banner')->with(compact('breadcrumbs'));
    }

    public function postBanner(BannerRequest $request)
    {
        $banner = $request->file('image');
        Banners::create([
            'title' => $request->get('title'),
            'path' => $this->createImage($banner),
            'url' => $request->get('url'),
            'status' => $request->get('status'),
            'description' => $request->get('description')
        ]);
        return redirect('admin/banner');
    }

    public function editBanner($id)
    {
        $banner = Banners::find($id);
        $breadcrumbs = array('banner-edit', $banner);
        return view('admin.banners.edit-banner')->with(compact('banner', 'breadcrumbs'));
    }

    public function storeBanner($id, Request $request)
    {
        $banners = Banners::find($id);

        $banners->title = $request->get('title');
        $banners->description = $request->get('description');
        $banners->url = $request->get('url');
        $banners->status = $request->get('status');

        if (!empty($request->file('image')))
            $banners->path = $this->createImage($request->file('image'));

        $banners->save();
        return redirect('/admin/banner');
    }

    public function delBanner($id)
    {
        $banners = Banners::find($id);
        $this->deleteImage($banners->path);
        $banners->delete();
        return redirect('/admin/banner');
    }

    public function createImage($image)
    {
        $path = '/img/upload/ads/';
        $name = sha1(Carbon::now()) . '.' . $image->guessExtension();
        $image->move(getcwd() . $path, $name);
        return $path . $name;
    }

    public function deleteImage($oldPath)
    {
        $oldPath = getcwd() . $oldPath;
        @unlink(realpath($oldPath));
    }
}
