<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Carbon;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('category_product')->delete();
        DB::table('category_product')->insert([
            'id' => 1,
            'name' => 'Root',
            'parent' => 0,
            'left' => 0,
            'right' => 1,
            'level' => 0,
            'catecode' => '',
            'show_frontend_header' => 1,
            'position_header' => 1,
            'position_footer' => 1,
            'show_frontend_footer' => 1,
            'image' => '',
            'status' => 1,
            'options' => '',
            'description' => '',
            'meta_description' => '',
            'meta_title' => '',
            'meta_keyword' => '',
            'created_time' => Carbon::now(),
            'modified_time' => Carbon::now(),
            'fullcate_parent' => ''
        ]);

        DB::table('menu_admin')->delete();
        DB::table('menu_admin')->insert([
            'id' => 1,
            'name' => 'Root',
            'parent' => 0,
            'left' => 0,
            'right' => 1,
            'level' => 0,
            'catecode' => '',
            'status' => 1,
            'description' => '',
            'fullcate_parent' => '',
            'created_time' => Carbon::now(),
            'modified_time' => Carbon::now(),
        ]);

        DB::table('category_article')->delete();
        DB::table('category_article')->insert([
            'id' => 1,
            'name' => 'Root',
            'parent' => 0,
            'left' => 0,
            'right' => 1,
            'level' => 0,
            'catecode' => '',
            'show_frontend_header' => 1,
            'position_header' => 1,
            'position_footer' => 1,
            'show_frontend_footer' => 1,
            'image' => '',
            'status' => 1,
            'options' => '',
            'description' => '',
            'meta_description' => '',
            'meta_title' => '',
            'meta_keyword' => '',
            'created_time' => Carbon::now(),
            'modified_time' => Carbon::now(),
            'fullcate_parent' => ''
        ]);
    }
}
