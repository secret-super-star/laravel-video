<?php

namespace App\Http\Controllers\Admin;

use App\Models\VideoGroupsCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoGroupCategoriesController extends Controller
{
    public function __construct()
    {
        $this->videoGroupCategories = new VideoGroupsCategories();
    }

    public function index(Request $request)
    {
        return view('admin.videoGroupCategories.index',[
            'groupCategories' => $this->videoGroupCategories->getGroupCategories()
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.videoGroupCategories.add');
    }

    public function createPost(Request $request)
    {
        $this->videoGroupCategories->createGroupCategories($request);
        return redirect(route('admin.videoGroupCategories'));
    }

    public function edit(Request $request, $id)
    {
        $data = $this->videoGroupCategories->getGroupCategoriesById($id);
        return view('admin.videoGroupCategories.edit',[
            'data' => $data
        ]);
    }

    public function editPost(Request $request, $id)
    {
        $this->videoGroupCategories->updateGroupCategories($request, $id);
        return redirect(route('admin.videoGroupCategories'));
    }

    public function deletePost(Request $request, $id)
    {
        $this->videoGroupCategories->deleteGroupCategories($id);
        return redirect(route('admin.videoGroupCategories'));
    }
}
