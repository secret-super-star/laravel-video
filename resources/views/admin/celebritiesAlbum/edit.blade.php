@extends('admin.layouts.admin')

@section('title')
  Add Album
@endsection

@section('content')
  <script src="{{asset('assets/admin/js/jquery-2.2.3.min.js')}}"></script>
  
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <form method="POST" action="/admin/celebrity/postEditCelebrityAlbum" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
        {{csrf_field()}}
        <div style="color: red">{{($errors->first())}}</div>
        <input type="hidden" name="id" value="{{$data->id}}">
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Album Name
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="name" type="text" value="{{$data->name}}" class="form-control col-md-7 col-xs-12 " name="name" required="" >
          </div>
        </div>
        
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
            <img src="{{$data->thumbnail}}" alt="Thumbnail of Video Image" style="width: 100%;" id="addVideoThumb" >
          </div>
        </div>
        
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Celebrity
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="celebrity" id="editceleb" class="form-control">
              <option value="">Select Celebrity</option>
              @foreach($celebrities as $val)
                @if($data->celebrity->id == $val->id)
                  <option value="{{$val->id}}" selected>{{$val->name}}</option>
                @else
                <option value="{{$val->id}}">{{$val->name}}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Celebrity Video
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="celebrityVideo[]" id="celebrityVideo" class="js-example-basic-multiple"  multiple="multiple" style="width: 100%">

              @if(isset($data->celebrity->celebritiesVideos))
                @foreach($data->celebrity->celebritiesVideos as $key => $val)
                  <?php
                    $select= '';
                  ?>
                  @if(isset($data->series))
                    @foreach($data->series as $key1 => $val1)
                      @if(isset($val1->series_id) && isset($val->seriesDetail->id))
                        @if($val1->series_id == $val->seriesDetail->id)
                            <?php
                            $select= 'selected';
                            ?>
                        @endif
                      @endif
                    @endforeach
                  @endif
                  <option value="{{$val->seriesDetail->id or ''}}" {{$select or ''}}>{{$val->seriesDetail->name or ''}}</option>
                    <?php
                    $select= '';
                    ?>
                @endforeach
              @endif
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
