<?php

namespace App\Http\Controllers\Articles;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('fronts.home.index');
    }
}
