<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoGroupsCategories extends Model
{
    protected $table = 'video_groups_categories';

    protected $fillable = [
        'name',
        'link'
    ];

    public function getGroupCategories()
    {
        return $this->orderBy('name')->get();
    }

    public function getGroupCategoriesById($id)
    {
        return $this->where('id', '=', $id)->first();
    }

    public function createGroupCategories($request)
    {
        $this->seriesController = new Series();
        $link = $this->seriesController->cleanTheLink($request->name);
        return $this->create([
            'name' => $request->name,
            'link' => $link
        ]);
    }

    public function updateGroupCategories($request, $id)
    {
        $this->seriesController = new Series();
        $link = $this->seriesController->cleanTheLink($request->name);
        return $this->where('id', '=', $id)->update([
            'name' => $request->name,
            'link' => $link
        ]);
    }

    public function deleteGroupCategories($id)
    {
        return $this->where('id', '=', $id)->delete();
    }
}
