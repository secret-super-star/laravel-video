@extends('admin.layouts.admin')


@section('title')
  Add Video Group
@endsection

@section('content')

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <form method="POST" action="/admin/new/video-groups/" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
        {{csrf_field()}}

        @if(\Session::has('error'))
          <div class="alert alert-danger">
            {{\Session::get('error')}}
          </div>
        @endif
        <div style="color: red">{{($errors->first())}}</div>

        <input type="hidden" name="cityName" id="cityName">
        <input type="hidden" name="placeName" id="placeName">

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Group Type
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="group_type" id="group_type" class="form-control">
              <option value="1">مجلسِ عزا</option>
              <option value="2">جشن</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Date Recorded ( اسلامک )
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" class="form-control" name="islamic_calender" id="islamic_calender">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
            Date Recorded
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="date_recorded" type="text" value="{{old('date_recorded')}}" class="form-control col-md-7 col-xs-12 " name="date_recorded" required="" autocomplete="off">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            City
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="city_id" id="cities" class="form-control" >
              <option value="">Select City</option>
              @foreach($cities as $key => $val)
                <option value="{{$val->id}}" data-name="{{$val->name_urd}}">{{$val->name}} </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Place
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="place_id" id="places" class="form-control">

            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Name
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="name" type="text" value="{{old('name')}}" class="form-control col-md-7 col-xs-12 " name="name" required="" >
          </div>
        </div>
        
        
        {{--<div class="form-group">--}}
          {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">--}}
            {{--Thumbnail--}}
            {{--<span class="required">*</span>--}}
          {{--</label>--}}
          {{--<div class="col-sm-2">--}}
            {{--<a class="fancybox" rel="group" href="{{asset('filemanager/dialog.php')}}??type=1&field_id=mythumbnail&relative_url=0">--}}
              {{--<i class="fa fa-upload" aria-hidden="true"></i>--}}
              {{--<button type="button" class="btn btn-primary">--}}
                {{--<span class="">Select Image</span>--}}
              {{--</button>--}}
            {{--</a>--}}
          {{--</div>--}}
          {{--<div class="col-md-4 col-sm-4 col-xs-12">--}}
            {{--<input id="mythumbnail" name="mythumbnail" type="text" value="" class="form-control" style="display: none">--}}
            {{--<img src="" alt="Thumbnail of Video Image" style="width: 100%;" id="addVideoThumb" >--}}
          {{--</div>--}}
        {{--</div>--}}
        

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id">
            Group Category
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="category_id" id="category_id" class="form-control">
              <option value="">Select Group Category</option>
              @foreach($videoGroupCategories as $key => $val)
                <option value="{{$val->id}}">{{$val->name}}</option>
              @endforeach
            </select>
          </div>
        </div>

  
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Videos
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="videos[]" id="videos" class="js-example-basic-multiple"  multiple="multiple" style="width: 100%">
                @foreach($videos as $key => $val)
                 <option value="{{$val->id}}">{{$val->name}}</option>
                @endforeach
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Publish
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
