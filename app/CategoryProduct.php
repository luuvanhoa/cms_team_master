<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoryProduct extends Model
{
    public $table = 'category_product';

    protected $fillable = [
        'name',
        'catecode',
        'position_header',
        'show_frontend_header',
        'position_footer',
        'show_frontend_footer',
        'image',
        'status',
        'description',
        'options',
        'meta_description',
        'meta_title',
        'meta_keyword',
        'created_time',
        'modified_time',
        'fullcate_parent',
        'parent',
        'level',
        'left',
        'right'
    ];

    public function setTable($_table)
    {
        $this->table = $_table;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function mapsDataDefault($data)
    {
        return array(
            'name' => isset($data['name']) ? $data['name'] : null,
            'catecode' => isset($data['catecode']) ? str_slug($data['catecode']) : str_slug($data['name']),
            'position_header' => isset($data['position_header']) ? $data['position_header'] : 0,
            'show_frontend_header' => isset($data['show_frontend_header']) ? $data['show_frontend_header'] : 0,
            'position_footer' => isset($data['position_footer']) ? $data['position_footer'] : 0,
            'show_frontend_footer' => isset($data['show_frontend_footer']) ? $data['show_frontend_footer'] : 0,
            'image' => isset($data['image']) ? $data['image'] : null,
            'status' => isset($data['status']) ? $data['status'] : 0,
            'parent' => isset($data['parent']) ? $data['parent'] : 0,
            'description' => isset($data['description']) ? $data['description'] : null,
            'options' => isset($data['options']) ? $data['options'] : null,
            'meta_description' => isset($data['meta_description']) ? $data['meta_description'] : null,
            'meta_title' => isset($data['meta_title']) ? $data['meta_title'] : null,
            'meta_keyword' => isset($data['meta_keyword']) ? $data['meta_keyword'] : null,
            'created_time' => isset($data['created_time']) ? $data['created_time'] : date('Y-m-d H:i:s'),
            'modified_time' => isset($data['modified_time']) ? $data['modified_time'] : null,
            'fullcate_parent' => isset($data['fullcate_parent']) ? $data['fullcate_parent'] : null
        );
    }

    /**
     * @param $data
     * @param $nodeID
     * @param null $nodeParentID
     * @param null $options
     */
    public function updateNode($data, $nodeID, $nodeParentID = null, $options = null)
    {
        if (!empty($nodeParentID)) {
            $nodeParentInfo = $this->findById($this->_model, $nodeParentID);
            $nodeInfo = $this->findById($this->_model, $nodeID);
            if (!empty($nodeParentInfo) && $nodeInfo->parent != $nodeParentInfo->id) {
                $this->moveRight($nodeID, $nodeParentID);
            }
        }
        DB::table($this->table)
            ->where('id', $nodeID)
            ->update([
                'name' => $data['name'],
                'status' => $data['status'],
                'description' => $data['description'],
                'parent' => $data['parent'],
                'slug' => $data['slug'],
                'image' => $data['image']
            ]);
    }
}
