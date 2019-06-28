<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoGroupsCategoriesSeries extends Model
{
    protected $table = 'video_groups_categories_series';

    protected $fillable = [
        'group_id',
        'groups_categories_id'
    ];

    public function categoryDetail()
    {
        return $this->hasOne('App\Models\VideoGroupsCategories', 'id', 'groups_categories_id');
    }

    public function createVideoGroupCategorySeries($groupId, $groupCategoryId)
    {
        return $this->create([
            'group_id' => $groupId,
            'groups_categories_id' => $groupCategoryId
        ]);
    }

    public function updateVideoGroupCategorySeries($groupId, $groupCategoryId)
    {
        $data = $this->where('group_id', '=', $groupId)->first();
        if (count($data) > 0) {
            return $this->where('group_id', '=', $groupId)->update([
                'groups_categories_id' => $groupCategoryId
            ]);
        } else {
            return (self::createVideoGroupCategorySeries($groupId, $groupCategoryId));
        }
    }
}
