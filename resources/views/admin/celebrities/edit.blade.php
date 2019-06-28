@extends('admin.layouts.admin')

@section('title')
Edit Celebrity
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <form method="POST" action="/admin/edit/celebrity" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
            {{csrf_field()}}
  
            <div style="color: red">{{($errors->first())}}</div>
            <input type="hidden" name="id" value="{{$celebrity->id}}">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                Name
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="name" type="text" value="{{$celebrity->name}}" class="form-control col-md-7 col-xs-12 " name="name" required="">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                Image
              </label>
              <div class="col-sm-2">
                <a class="fancybox" rel="group" href="{{asset('filemanager/dialog.php')}}??type=1&field_id=mythumbnail&relative_url=0">
                  <button type="button" class="btn btn-primary">
                    <span class="">Select Image</span>
                  </button>
                </a>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-12">
                <input id="mythumbnail" name="mythumbnail" type="text" value="" class="form-control" style="display: none">
                <img src="{{$celebrity->image}}" alt="Thumbnail of Image" style="width: 100px;" id="addVideoThumb" >
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                Banner
              </label>
              <div class="col-sm-2">
                <a class="fancybox banner" rel="group" href="{{asset('filemanager/dialog.php')}}??type=1&field_id=bannerThumb&relative_url=0">
                  <button type="button" class="btn btn-primary">
                    <span class="">Select Image</span>
                  </button>
                </a>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-12">
                <input id="bannerThumb" name="bannerThumb" type="text" value="" class="form-control" style="display: none">
                <img src="{{$celebrity->banner}}" alt="Thumbnail of Image" style="width: 100px;" id="bannerVideoThumb" >
              </div>
            </div>
    
            {{--<div class="form-group">--}}
              {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="contact">--}}
                {{--Contact --}}
              {{--</label>--}}
              {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                {{--<input id="contact" type="text" value="{{$celebrity->contact or ''}}" class="form-control col-md-7 col-xs-12 " name="contact" required="">--}}
              {{--</div>--}}
            {{--</div>--}}
  
            {{--<div class="form-group">--}}
              {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">--}}
                {{--City --}}
              {{--</label>--}}
              {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
               {{--<select name="city" id="city" class="form-control" required="">--}}
                  {{--@foreach($cities as $key => $val)--}}
                    {{--@if(isset($celebrity->cityLocated->id) && $celebrity->cityLocated->id == $val->id)--}}
                    {{--<option selected value="{{$val->id}}">{{$val->name}}</option>--}}
                    {{--@else                    --}}
                    {{--<option value="{{$val->id}}">{{$val->name}}</option>--}}
                    {{--@endif--}}
                  {{--@endforeach--}}
               {{--</select>--}}
              {{--</div>--}}
            {{--</div>--}}
            {{----}}

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bio">
                Bio
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea name="bio" id="bio" class="form-control col-md-7 col-xs-12 ">{{$celebrity->bio}}</textarea>
              </div>
            </div>
    
            {{--<div class="form-group">--}}
              {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="dob">--}}
                {{--Date of Birth--}}
              {{--</label>--}}
              {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                {{--<input type="date" class="form-control" name="dob" id="dob" value="{{$celebrity->dob}}">--}}
              {{--</div>--}}
            {{--</div>--}}
    {{----}}
            {{--<div class="form-group">--}}
              {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="bio">--}}
                {{--Country--}}
              {{--</label>--}}
              {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                {{--<select name="country" id="" class="form-control">--}}
                  {{--@foreach($countries as $key => $val)--}}
                    {{--@if($val->short_name == $celebrity->country)--}}
                      {{--<option value="{{$val->short_name}}" selected>{{$val->long_name}}</option>--}}
                    {{--@else--}}
                      {{--<option value="{{$val->short_name}}">{{$val->long_name}}</option>--}}
                    {{--@endif--}}
                  {{--@endforeach--}}
                {{--</select>--}}
              {{--</div>--}}
            {{--</div>--}}
    
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                {{--<a class="btn btn-primary" href="http://localhost:8000/admin/users"> Cancel</a>--}}
                <button type="submit" class="btn btn-success"> Save Celebrity</button>
              </div>
            </div>
 
          </form>
        </div>
    </div>
  @section('scriptEnd')
    <script>tinymce.init({ selector:'textarea' });</script>
  @endsection
@endsection
