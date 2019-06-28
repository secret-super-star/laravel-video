@extends('admin.layouts.admin')

@section('title')
Edit {{$data->name}}
@endsection

@section('content')
  
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <form method="POST" action="/admin/places/updatePlace/{{$data->id}}" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
            {{csrf_field()}}
  
            
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_title">
                Place Name
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="name" type="text" value="{{$data->name}}" class="form-control col-md-7 col-xs-12 " name="name" required="">
              </div>
            </div>

            {{--<div class="form-group">--}}
              {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_title">--}}
                {{--Place Name ( اردو )--}}
                {{--<span class="required">*</span>--}}
              {{--</label>--}}
              {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                {{--<input id="name_urd" type="text" value="{{$data->name_urd}}" class="form-control col-md-7 col-xs-12 " name="name_urd" required="">--}}
              {{--</div>--}}
            {{--</div>--}}
            
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_title">
                City Name
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="city_id" id="city" class="form-control">
                  @foreach($cities as $key => $val)
                    @if($data->city->id == $val->id)
                    <option value="{{$val->id}}" selected >{{$val->name}}</option>
                    @else
                      <option value="{{$val->id}}">{{$val->name}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>
  
  
  
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                Place Thumbnail
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
                <img src="{{$data->thumbnail}}" alt="Thumbnail of Video Image" style="width: 100%;" id="addVideoThumb" >
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                {{--<a class="btn btn-primary" href="http://localhost:8000/admin/users"> Cancel</a>--}}
                <button type="submit" class="btn btn-success"> Save</button>
              </div>
            </div>
 
          </form>
        </div>
    </div>
@endsection
