<?php

namespace App\Components;

use App\CategoryPost;

class Recursive
{
    private $htmlOption = [];


    function itemRecursive($parentId, $id, $text, $data)
    {
        foreach ($data as $value) {
            if ($value['parent_id'] == $id) {
                $this->htmlOption[$value['id']] = $text . $value['name'];
                $this->itemRecursive($parentId, $value['id'], $text . '--', $data);
            }
        }
        return $this->htmlOption;
    }


    function deleteRecursive($model)
    {
        foreach ($model->childrenCategorys as $value) {
            $value->delete();
            $this->deleteRecursive($value);
        }
    }
    function restoreRecursive($id,$model)
    {
        $b = $model::onlyTrashed()->find($id);
        if ($b->parent_id && $b->parent_id != 0) {
            $c = $model::onlyTrashed()->find($b->parent_id);
            if ($c == null) {
                $b->restore();
            } else {
                $b->childrenCategorys()->restore();
                $b->restore();
                $this->restoreRecursive($b->parent_id,$model);
            }
        } else {
            $b->restore();
        }
    }
}
