@extends('admin.layouts.admin')

@section('title')
  Add Album
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <form method="POST" action="/admin/celebrity/postCelebrityAlbum" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
        {{csrf_field()}}
        <div style="color: red">{{($errors->first())}}</div>
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Album Name
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="name" type="text" value="{{old('name')}}" class="form-control col-md-7 col-xs-12 " name="name" required="" >
          </div>
        </div>
        
        
        {{--<div class="form-group">--}}
          {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">--}}
            {{--Video Title--}}
            {{--<span class="required">*</span>--}}
          {{--</label>--}}
          {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
            {{--<input id="title" type="text" value="" class="form-control col-md-7 col-xs-12 " name="title" required="">--}}
          {{--</div>--}}
        {{--</div>--}}
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
            Album Thumbnail
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
            <input id="mythumbnail" name="mythumbnail" type="text" value="" class="form-control" style="display: none">
            <img src="" alt="Thumbnail of Video Image" style="width: 100%;" id="addVideoThumb" >
          </div>
        </div>
        
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Celebrity
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="celebrity" id="celeb" class="" style="width:100%">
              <option value="">Select Celebrity</option>
              @foreach($celebrities as $val)
                <option value="{{$val->id}}">{{$val->name}}</option>
              @endforeach
            </select>
          </div>
        </div>

        @section('js')
        <script>
          $(document).ready(function() { $("#celeb").select2(); });
        </script>
        @endsection
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Celebrity Video
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="celebrityVideo[]" id="celebrityVideo" class="js-example-basic-multiple"  multiple="multiple" style="width: 100%">
                <option value="">Select Celebrity Videos</option>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Publish Album
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="checkbox" class="" name="publish" value="1" checked>
          </div>
        </div>
  
        <div class="form-group">
          <div class="col-md-12 col-sm-12 col-xs-12 ">
            {{--<a class="btn btn-primary" href="http://localhost:8000/admin/users"> Cancel</a>--}}
            <button type="submit" class="btn btn-success" onclick="$.LoadingOverlay('show');" style="float: right; margin-right: 100px" > Save Album</button>
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
