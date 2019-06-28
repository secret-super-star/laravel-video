@extends('admin.layouts.admin')

@section('title')
  Add Video Group Category
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <form method="POST" action="/admin/new/video-group-categories" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
        {{csrf_field()}}
        <div style="color: red">{{($errors->first())}}</div>
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Name
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="name" type="text" value="{{old('name')}}" class="form-control col-md-7 col-xs-12 " name="name" required="" >
          </div>
        </div>
        
              <div class="form-group">
          <div class="col-md-12 col-sm-12 col-xs-12 ">
            {{--<a class="btn btn-primary" href="http://localhost:8000/admin/users"> Cancel</a>--}}
            <button type="submit" class="btn btn-success" onclick="$.LoadingOverlay('show');" style="float: right; margin-right: 100px" > Save</button>
          </div>
        </div>
  
        <style>
          .modal-backdrop {
            background-color: transparent;
          }
        </style>
        
      </form>
    </div>
  </div>
@endsection
