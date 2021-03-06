@extends('admin.layouts.admin')

@section('title')
Add Category
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <form method="POST" action="/admin/categories/addCategories" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
            {{csrf_field()}}
  
            <div style="color: red">{{($errors->first())}}</div>
  
            <input type="hidden" value="" name="category_id">
            
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_title">
                Category Title
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="category_title" type="text" value="" class="form-control col-md-7 col-xs-12 " name="category_title" required="">
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parent_category">
                Parent Category
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="parent_category" type="checkbox" value="true"  name="parent_category" checked>
              </div>
            </div>
            
            <div class="form-group" id="parent_category_name_div" style="display: none">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parent">
                Parent Category Name
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="parent" name="parent" class="form-control">
                  @foreach($categories as $key => $val)
                  <option value="{{$val->id}}">{{$val->category_title}}</option>
                  @endforeach
                </select>
              </div>
            </div>
    
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_description">
                Category Description
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea name="category_description" id="category_description" cols="30" rows="10"  class="form-control col-md-7 col-xs-12 "></textarea>
                {{--<input id="category_description" type="text" class="form-control col-md-7 col-xs-12 " name="category_description" value="" required="">--}}
              </div>
            </div>


            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                Category Image
                <span class="required">*</span>
              </label>
              <div class="col-sm-2">
                <a class="fancybox" rel="group" href="{{asset('filemanager/dialog.php')}}??type=1&field_id=mythumbnail&relative_url=0">
                  {{--<i class="fa fa-upload" aria-hidden="true"></i>--}}
                  <button type="button" class="btn btn-primary">
                    <span class="">Select Image</span>
                  </button>
                </a>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-12">
                {{--<input id="title"  class="form-control col-md-7 col-xs-12 " name="mythumbnail" >--}}
                <input id="mythumbnail" name="mythumbnail" type="text" value="" class="form-control" style="display: none">
                <img src="" alt="Thumbnail of Video Image" style="width: 100%;" id="addVideoThumb" >
              </div>

            </div>


            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                {{--<a class="btn btn-primary" href="http://localhost:8000/admin/users"> Cancel</a>--}}
                <button type="submit" class="btn btn-success"> Save Category</button>
              </div>
            </div>
 
          </form>
        </div>
    </div>
@endsection
