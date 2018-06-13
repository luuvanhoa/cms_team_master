<?php
/**
 * Created by PhpStorm.
 * User: luuhoa
 * Date: 3/20/2018
 * Time: 11:02 PM
 */

namespace App\Helpers;

use Carbon\Carbon;

class Images
{
    /**
     * @param $image (obj)
     * @return string
     */
    public static function createImage($image, $path = '')
    {
        $path = ($path == '') ? '/img/upload/category/' : $path;
        $name = sha1(Carbon::now()) . '.' . $image->guessExtension();
        $image->move(getcwd() . $path, $name);
        return $path . $name;
    }

    /**
     * @param $oldPath
     */
    public static function deleteImage($oldPath)
    {
        $oldPath = getcwd() . $oldPath;
        @unlink(realpath($oldPath));
    }
}