<?php

namespace App;
class Category extends Nested
{
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

    public function products()
    {
        return $this->hasMany('App\Products');
    }

    public function articles()
    {
        return $this->hasMany('App\Articles');
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
            $nodeParentInfo = $this->find($nodeParentID);
            $nodeInfo = Categories::find($nodeID);
            if (!empty($nodeParentInfo) && $nodeInfo->parent != $nodeParentInfo->id) {
                $this->moveRight($nodeID, $nodeParentID);
            }
        }
        DB::table('categories')
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

    /**
     * @param $data
     * @param $nodeID
     * @param $options
     * @return bool
     */
    public function insertNode($data, $nodeID, $options)
    {
        $nodeInfo = Categories::find($nodeID);
        switch ($options['position']) {
            case 'left':
                $updateLeft = DB::table('categories')->where('left', '>', $nodeInfo['left'])->get();
                $updateRight = DB::table('categories')->where('right', '>', $nodeInfo['left']);
                $data['parent'] = $nodeInfo->id;
                $data['level'] = $nodeInfo->level + 1;
                $data['left'] = $nodeInfo->left + 1;
                $data['right'] = $nodeInfo->left + 2;
                break;
            case 'before':
                $updateLeft = DB::table('categories')->where('left', '>=', $nodeInfo['left'])->get();
                $updateRight = DB::table('categories')->where('right', '>', $nodeInfo['left'])->get();
                $data['parent'] = $nodeInfo->parent;
                $data['level'] = $nodeInfo->level;
                $data['left'] = $nodeInfo->left;
                $data['right'] = $nodeInfo->left + 1;
                break;
            case 'after':
                $updateLeft = DB::table('categories')->where('left', '>=', $nodeInfo['right'])->get();
                $updateRight = DB::table('categories')->where('right', '>', $nodeInfo['right'])->get();
                $data['parent'] = $nodeInfo->parent;
                $data['level'] = $nodeInfo->level;
                $data['left'] = $nodeInfo->right + 1;
                $data['right'] = $nodeInfo->right + 2;
                break;
            case 'right':
            default:
                $updateLeft = DB::table('categories')->where('left', '>', $nodeInfo['right'])->get();
                $updateRight = DB::table('categories')->where('right', '>=', $nodeInfo['right'])->get();
                $data['parent'] = $nodeInfo->id;
                $data['level'] = $nodeInfo->level + 1;
                $data['left'] = $nodeInfo->right;
                $data['right'] = $nodeInfo->right + 1;
                break;
        }

        if (!empty($updateLeft)) {
            foreach ($updateLeft as $left) {
                DB::table('categories')->where('id', $left->id)->update(['left' => $left->left + 2]);
            }
        }

        if (!empty($updateRight)) {
            foreach ($updateRight as $right) {
                DB::table('categories')->where('id', $right->id)->update(['right' => $right->right + 2]);
            }
        }

        Categories::create($data);
        return true;
    }

    /**
     * @param $nodeMoveID
     * @param $nodeSelectionID
     */
    public function moveRight($nodeMoveID, $nodeSelectionID)
    {
        // ========================= Detach branch =========================
        $totalNode = $this->detachBranch($nodeMoveID);

        $nodeSelectionInfo = Categories::find($nodeSelectionID);
        $nodeMoveInfo = Categories::find($nodeMoveID);

        // ========================= Node on tree (LEFT) =========================
        $updateLeft = DB::table('categories')
            ->where('left', '>', $nodeSelectionInfo->right)
            ->where('right', '>', 0)
            ->get();
        if (!empty($updateLeft)) {
            foreach ($updateLeft as $node) {
                $leftNew = $node->left + ($totalNode * 2);
                DB::table('categories')
                    ->where('id', $node->id)
                    ->update([
                        'left' => $leftNew
                    ]);
            }
        }

        // ========================= Node on tree (RIGHT) =========================
        $updateRight = DB::table('categories')
            ->where('right', '>=', $nodeSelectionInfo->right)
            ->get();
        if (!empty($updateRight)) {
            foreach ($updateRight as $node) {
                $rightNew = $node->right + ($totalNode * 2);
                DB::table('categories')
                    ->where('id', $node->id)
                    ->update([
                        'right' => $rightNew
                    ]);
            }
        }

        // ========================= Node on branch (LEVEL) =========================
        $updateLevel = DB::table('categories')
            ->where('right', '<=', 0)
            ->get();
        if (!empty($updateLevel)) {
            foreach ($updateLevel as $node) {
                // ========================= Node on branch (LEVEL) =========================
                $level = $node->level + $nodeSelectionInfo->level - $nodeMoveInfo->level + 1;
                // ========================= Node on branch (LEFT) ==========================
                $left = $node->left + $nodeSelectionInfo->right;
                // ========================= Node on branch (RIGHT) =========================
                $right = $node->right + $nodeSelectionInfo->right + $totalNode * 2 - 1;

                DB::table('categories')
                    ->where('id', $node->id)
                    ->update([
                        'level' => $level,
                        'left' => $left,
                        'right' => $right
                    ]);
            }
        }

        // ========================= Node move (PARENT) =========================
        DB::table('categories')
            ->where('id', $nodeMoveInfo->id)
            ->update([
                'parent' => $nodeSelectionInfo->id
            ]);
    }

    /**
     * @param $nodeMoveID
     * @param null $options
     * @return float
     */
    public function detachBranch($nodeMoveID, $options = null)
    {
        $moveInfo = Categories::find($nodeMoveID);
        $moveLeft = $moveInfo->left;
        $moveRight = $moveInfo->right;
        $totalNode = ($moveRight - $moveLeft + 1) / 2;

        // ================================== Node on branch ==================================
        if ($options == null) {
            $updateNode = DB::table('categories')
                ->whereBetween('left', [$moveInfo->left, $moveInfo->right])
                ->get();
            if (!empty($updateNode)) {
                foreach ($updateNode as $node) {
                    $leftNew = ($node->left - $moveLeft);
                    $rightNew = ($node->right - $moveRight);
                    DB::table('categories')
                        ->where('id', $node->id)
                        ->update([
                            'left' => $leftNew,
                            'right' => $rightNew
                        ]);
                }
            }
        }

        if ($options['task'] == 'remove-node') {
            $d = DB::table('categories')
                ->whereBetween('left', [(int)$moveInfo->left, (int)$moveInfo->right])
                ->delete();
        }
        // ================================== Node on tree (LEFT) ==================================
        $updateNode = DB::table('categories')
            ->where('left', '>', $moveRight)
            ->get();
        if (!empty($updateNode)) {
            foreach ($updateNode as $node) {
                $leftNew = $node->left - ($totalNode * 2);
                DB::table('categories')
                    ->where('id', $node->id)
                    ->update([
                        'left' => $leftNew
                    ]);
            }
        }

        // ================================== Node on tree (RIGHT) ==================================
        $updateNode = DB::table('categories')
            ->where('right', '>', $moveRight)
            ->get();
        if (!empty($updateNode)) {
            foreach ($updateNode as $node) {
                $rightNew = $node->right - ($totalNode * 2);
                DB::table('categories')
                    ->where('id', $node->id)
                    ->update([
                        'right' => $rightNew
                    ]);
            }
        }

        return $totalNode;
    }
}
