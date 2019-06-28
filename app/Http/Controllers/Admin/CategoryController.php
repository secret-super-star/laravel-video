<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Categories;
use App\Services\GeneralServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CategoryController extends Controller
{
	
	function __construct()
	{
		$this->category = new Categories();
		$this->services = new GeneralServices();
	}
	
	public function index(Request $request)
	{
		return view('admin.categories.index', [
			'categories' => $this->category->getCategories(false, true)
		]);
	}
	
	public function getCategory($category)
	{
		return view('admin.categories.edit', [
			'categories' => $this->category->getCategories($category),
			'allCategories' => $this->category->getCategories(false, true)->sortBy('category_title')
		]);
	}
	
	public function getSubCategory($category)
	{
		$header = \Request::header();
		$subCategory  = $this->category->getSubCategories($category);
		if(trim($header['accept'][0]) == 'api')
		{
			return collect([
				'status' => 'success',
				'subcategories' => $subCategory->subCategories
			]);
		} else {
			return view('admin.categories.subcategories', [
				'categories' => $subCategory
			]);
		}
	}
	
	public function updateCategories(Request $request)
	{
		try {
			$oldCategories =  $this->category->getCategories($request['category_id']);
			if ($request->mythumbnail) {
				$request['uploaded_category_image'] = $request->mythumbnail;
			}
			$result = $this->category->updateCategories($request);
			
			return redirect('/admin/categories');
		} catch (\Exception $e) {
			\Log::info('Error while updating category' . $e->getMessage());
			dd($e->getMessage());
			return redirect()->back()->with('message', 'Something went wrong, please try again later');
		}
	}
	
	public function postAddCategories(CategoryRequest $request)
	{
		try {
			$request['uploaded_category_image'] = $request->mythumbnail;
			$result = $this->category->createCategories($request);
			return redirect('/admin/categories');
		} catch (\Exception $e) {
			dd($e->getMessage());
			\Log::info('Error while updating category' . $e->getMessage());
			return redirect()->back()->with('message', 'Something went wrong, please try again later');
		}
	}
	
	public function addCategory(Request $request)
	{
		return view('admin.categories.add',[
			'categories' => $this->category->getCategories(false, true),
		]);
	}
	
	public function deleteCategories($catId)
	{
		$this->category->where('id', '=', $catId)->delete();
		return redirect()->back();
	}
	
	public function updateCustomOrder(Request $request){
		$oldIndex = $request->oldIndex;
		$newIndex = $request->newIndex;
		
		if ($oldIndex > $newIndex) {
			$z = 0;
			for ($i = $newIndex; $i < $oldIndex; $i++) {
				\Log::info('i = ' . $i) . '<br/>';
				if ($i != $oldIndex) {
					if ($z == 0) {
						$this->category->where('custom_order', '=', $i)->update([
							'custom_order' => ($i + 1)
						]);
					} else {
						$a = $this->category->where('custom_order', '=', $i)->orderBy('updated_at', 'asc')->get();
						$this->category->where('id', '=', $a[0]->id)->update([
							'custom_order' => ($i + 1)
						]);
					}
				}
				$z++;
			}
			$this->category->where('id', '=', $request->id)->update([
				'custom_order' => $request->newIndex
			]);
		} else {
			$this->category->where('id', '=', $request->id)->update([
				'custom_order' => -500
			]);
			$z = 0;
			for ($i = $newIndex; $i > $oldIndex; $i--) {
				
				\Log::info('i = ' . $i) . '<br/>';
				if ($i != $oldIndex) {
					if ($z == 0) {
						$this->category->where('custom_order', '=', $i)->update([
							'custom_order' => ($i - 1)
						]);
					} else {
						$a = $this->category->where('custom_order', '=', $i)->orderBy('updated_at', 'asc')->get();
						$this->category->where('id', '=', $a[0]->id)->update([
							'custom_order' => ($i - 1)
						]);
					}
				}
				$z++;
			}
			
			$this->category->where('id', '=', $request->id)->update([
				'custom_order' => $request->newIndex
			]);
		}
	}
	
}
