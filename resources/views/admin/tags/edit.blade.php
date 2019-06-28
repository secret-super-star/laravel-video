@extends('admin.layouts.admin')

@section('title')
Edit {{$tags->tag}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <form method="POST" action="/admin/tags/updateTags" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
            {{csrf_field()}}
  
  
            <div style="color: red">{{($errors->first())}}</div>
            
            <input type="hidden" value="{{$tags->id}}" name="id">
            
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tag">
                Tag Name
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden" name="oldname" value="{{$tags->tag}}">
                <input id="tag" type="text" value="{{$tags->tag}}" class="form-control col-md-7 col-xs-12 " name="tag" required="">
              </div>
            </div>
  
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tag">
                Tag Description
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea name="tag_description" class="form-control" id="tag_description" cols="30" rows="10">{{$tags->tag_description or ''}}</textarea>
              </div>
            </div>
  
  
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" class="btn btn-success"> Save</button>
              </div>
            </div>
 
          </form>
        </div>
    </div>
@endsection
