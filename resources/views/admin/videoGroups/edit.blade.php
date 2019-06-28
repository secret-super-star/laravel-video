@extends('admin.layouts.admin')

@section('title')
  Edit {{$data->name}}
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <form method="POST" action="/admin/edit/video-groups/{{$data->id}}" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
        {{csrf_field()}}


        @if(\Session::has('error'))
          <div class="alert alert-danger">
            {{\Session::get('error')}}
          </div>
        @endif


        <div style="color: red">{{($errors->first())}}</div>

        <input type="hidden" name="cityName" id="cityName">
        <input type="hidden" name="placeName" id="placeName">
        <input type="hidden" name="oldThumb" id="oldThumb" value="{{$data->thumbnail}}">

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Group Type
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            @php
              $groupType = (int)$data->group_type;
              $groupone = $groupType == 1 ? 'selected' : '';
              $grouptwo = $groupType == 2 ? 'selected' : '';
            @endphp
            <select name="group_type" id="group_type" class="form-control">
              <option value="1" {{$groupone}}>مجلسِ عزا</option>
              <option value="2" {{$grouptwo}}>جشن</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Date Recorded ( اسلامک )
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" class="form-control" name="islamic_calender" id="islamic_calender" value="{{$data->date_recorded_urd}}">
          </div>
        </div>


        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
            Date Recorded
            @php
              $input  = Carbon\Carbon::parse($data->date_recorded)->format('d/m/Y');
            @endphp
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="date_recorded" type="text" value="{{$input}}" class="form-control col-md-7 col-xs-12 " name="date_recorded" autocomplete="off" required="" >
          </div>
        </div>

      <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            City
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="city_id" id="cities" class="form-control">
              <option value="" selected>Select City</option>
              @foreach($cities as $key => $val)
                @if($data->city_id == $val->id)
                  <option value="{{$val->id}}" data-name="{{$val->name_urd}}" selected>{{$val->name}}</option>
                  <script>
                    window.cityName = '{{$val->name_urd}}';
                  </script>
                @else
                  <option value="{{$val->id}}"  data-name="{{$val->name_urd}}">{{$val->name}}</option>
                @endif
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
              <option value="" selected>Select Place</option>
              @foreach($selectedPlaces as $key => $val)
                @if((int)$val->id == (int)$data->place_id)
                  <option value="{{$val->id}}" data-name="{{$val->name_urd}}" selected>{{$val->name}}</option>
                  <script>
				            window.placeName = '{{$val->name_urd}}';
                  </script>
                @else
                  <option value="{{$val->id}}" data-name="{{$val->name_urd}}">{{$val->name}}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div>


        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Name
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="name" type="text" value="{{$data->name}}" class="form-control col-md-7 col-xs-12 " name="name" required="" >
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
            {{--<input id="mythumbnail" name="mythumbnail" type="text" value="{{$data->thumbnail}}" class="form-control" style="display: none" >--}}
            {{--<img src="{{$data->thumbnail}}" alt="Thumbnail of Video Image" style="width: 100%;" id="addVideoThumb" >--}}
          {{--</div>--}}
        {{--</div>--}}


        @php
        try {
         $catId = $data->groupCategory->groups_categories_id;
        } catch(\Exception $e) {
         $catId = -1;
        }
        @endphp
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id">
            Group Category
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="category_id" id="category_id" class="form-control">
              <option value="">Select Group Category</option>
              @foreach($videoGroupCategories as $key => $val)
                @if($catId == $val->id)
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
            Videos
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="videos[]" id="videos" class="js-example-basic-multiple"  multiple="multiple" style="width: 100%">
              @foreach($videos as $key => $val)
		            <?php
		            $select= '';
		            ?>
                @foreach($data->series as $key1 => $val1)
                  @if($val1->series_id == $val->id)
                    <?php
                    $select= 'selected';
                    ?>
                  @endif
                @endforeach
                <option value="{{$val->id}}" {{$select}}> {{$val->name}}</option>
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
@section('scripts')
  <script src="{{asset('/assets/admin/js/custom.js')}}"></script>
  <script>
    $(function () {
      setTimeout(function () {
      	$('#cityName').val(window.cityName);
      	$('#placeName').val(window.placeName);
//        alert(window.placeName);
//        alert(window.cityName);
      })
    }, 3000)
  </script>
@endsection
