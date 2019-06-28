@extends('admin.layouts.admin')

@section('title')
Add Category
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <form method="POST" action="/admin/tags/addTags" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
            {{csrf_field()}}
  
            <div style="color: red">{{($errors->first())}}</div>
  
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tag">
                Tag Title
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="tag" type="text" value="{{old('tag')}}" class="form-control col-md-7 col-xs-12 " name="tag" required="">
              </div>
            </div>
    
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tag_description">
                Tag Description
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea name="tag_description" id="tag_description" cols="30" rows="10"  class="form-control col-md-7 col-xs-12 ">{{old('tag_description')}}</textarea>
                {{--<input id="category_description" type="text" class="form-control col-md-7 col-xs-12 " name="category_description" value="" required="">--}}
              </div>
            </div>
    
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                {{--<a class="btn btn-primary" href="http://localhost:8000/admin/users"> Cancel</a>--}}
                <button type="submit" class="btn btn-success"> Save Tag</button>
              </div>
            </div>
 
          </form>
        </div>
    </div>
@endsection
