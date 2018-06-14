<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nested extends Model
{
    protected $fillable = [
        'parent',
        'level',
        'left',
        'right'
    ];

    protected $_table = '';

    protected $_model = null;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $model = ucfirst($attributes['model']);
        $this->_model = new $model();
        $this->_table = $attributes['table'];
    }

    public function findById($model, $id)
    {
        return $model::find($id);
    }

    public function createRows($model, $data)
    {
        return $model::create($data);
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
        DB::table($this->_table)
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
        $nodeInfo = $this->findById($this->_model, $nodeID);
        switch ($options['position']) {
            case 'left':
                $updateLeft = DB::table($this->_table)->where('left', '>', $nodeInfo['left'])->get();
                $updateRight = DB::table($this->_table)->where('right', '>', $nodeInfo['left']);
                $data['parent'] = $nodeInfo->id;
                $data['level'] = $nodeInfo->level + 1;
                $data['left'] = $nodeInfo->left + 1;
                $data['right'] = $nodeInfo->left + 2;
                break;
            case 'before':
                $updateLeft = DB::table($this->_table)->where('left', '>=', $nodeInfo['left'])->get();
                $updateRight = DB::table($this->_table)->where('right', '>', $nodeInfo['left'])->get();
                $data['parent'] = $nodeInfo->parent;
                $data['level'] = $nodeInfo->level;
                $data['left'] = $nodeInfo->left;
                $data['right'] = $nodeInfo->left + 1;
                break;
            case 'after':
                $updateLeft = DB::table($this->_table)->where('left', '>=', $nodeInfo['right'])->get();
                $updateRight = DB::table($this->_table)->where('right', '>', $nodeInfo['right'])->get();
                $data['parent'] = $nodeInfo->parent;
                $data['level'] = $nodeInfo->level;
                $data['left'] = $nodeInfo->right + 1;
                $data['right'] = $nodeInfo->right + 2;
                break;
            case 'right':
            default:
                $updateLeft = DB::table($this->_table)->where('left', '>', $nodeInfo['right'])->get();
                $updateRight = DB::table($this->_table)->where('right', '>=', $nodeInfo['right'])->get();
                $data['parent'] = $nodeInfo->id;
                $data['level'] = $nodeInfo->level + 1;
                $data['left'] = $nodeInfo->right;
                $data['right'] = $nodeInfo->right + 1;
                break;
        }

        if (!empty($updateLeft)) {
            foreach ($updateLeft as $left) {
                DB::table($this->_table)->where('id', $left->id)->update(['left' => $left->left + 2]);
            }
        }

        if (!empty($updateRight)) {
            foreach ($updateRight as $right) {
                DB::table($this->_table)->where('id', $right->id)->update(['right' => $right->right + 2]);
            }
        }

        $this->createRows($this->_model, $data);
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

        $nodeSelectionInfo = $this->findById($this->_model, $nodeSelectionID);
        $nodeMoveInfo = $this->findById($this->_model, $nodeMoveID);

        // ========================= Node on tree (LEFT) =========================
        $updateLeft = DB::table($this->_table)
            ->where('left', '>', $nodeSelectionInfo->right)
            ->where('right', '>', 0)
            ->get();
        if (!empty($updateLeft)) {
            foreach ($updateLeft as $node) {
                $leftNew = $node->left + ($totalNode * 2);
                DB::table($this->_table)
                    ->where('id', $node->id)
                    ->update([
                        'left' => $leftNew
                    ]);
            }
        }

        // ========================= Node on tree (RIGHT) =========================
        $updateRight = DB::table($this->_table)
            ->where('right', '>=', $nodeSelectionInfo->right)
            ->get();
        if (!empty($updateRight)) {
            foreach ($updateRight as $node) {
                $rightNew = $node->right + ($totalNode * 2);
                DB::table($this->_table)
                    ->where('id', $node->id)
                    ->update([
                        'right' => $rightNew
                    ]);
            }
        }

        // ========================= Node on branch (LEVEL) =========================
        $updateLevel = DB::table($this->_table)
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

                DB::table($this->_table)
                    ->where('id', $node->id)
                    ->update([
                        'level' => $level,
                        'left' => $left,
                        'right' => $right
                    ]);
            }
        }

        // ========================= Node move (PARENT) =========================
        DB::table($this->_table)
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
        $moveInfo = $this->findById($this->_model, $nodeMoveID);
        $moveLeft = $moveInfo->left;
        $moveRight = $moveInfo->right;
        $totalNode = ($moveRight - $moveLeft + 1) / 2;

        // ================================== Node on branch ==================================
        if ($options == null) {
            $updateNode = DB::table($this->_table)
                ->whereBetween('left', [$moveInfo->left, $moveInfo->right])
                ->get();
            if (!empty($updateNode)) {
                foreach ($updateNode as $node) {
                    $leftNew = ($node->left - $moveLeft);
                    $rightNew = ($node->right - $moveRight);
                    DB::table($this->_table)
                        ->where('id', $node->id)
                        ->update([
                            'left' => $leftNew,
                            'right' => $rightNew
                        ]);
                }
            }
        }

        if ($options['task'] == 'remove-node') {
            $d = DB::table($this->_table)
                ->whereBetween('left', [(int)$moveInfo->left, (int)$moveInfo->right])
                ->delete();
        }
        // ================================== Node on tree (LEFT) ==================================
        $updateNode = DB::table($this->_table)
            ->where('left', '>', $moveRight)
            ->get();
        if (!empty($updateNode)) {
            foreach ($updateNode as $node) {
                $leftNew = $node->left - ($totalNode * 2);
                DB::table($this->_table)
                    ->where('id', $node->id)
                    ->update([
                        'left' => $leftNew
                    ]);
            }
        }

        // ================================== Node on tree (RIGHT) ==================================
        $updateNode = DB::table($this->_table)
            ->where('right', '>', $moveRight)
            ->get();
        if (!empty($updateNode)) {
            foreach ($updateNode as $node) {
                $rightNew = $node->right - ($totalNode * 2);
                DB::table($this->_table)
                    ->where('id', $node->id)
                    ->update([
                        'right' => $rightNew
                    ]);
            }
        }

        return $totalNode;
    }
}
