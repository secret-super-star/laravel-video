@extends('admin.layouts.admin')

@section('title')
  Add Combinational Image
@endsection

@section('content')
  
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <form method="POST" action="/admin/new/combination-images" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
        {{csrf_field()}}

        @if(\Session::has('error'))
          <div class="alert alert-danger">
            {{\Session::get('error')}}
          </div>
        @endif

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_title">
            City Name
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="city_id" id="city" class="form-control city">
              <option value="">Select City</option>
              @foreach($data as $cityKey => $cityVal)
                <option value="{{$cityVal->id}}" data-places="{{json_encode($cityVal->places)}}">{{$cityVal->name}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_title">
            Parent Image
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="checkbox" name="parent" id="parentImage">
          </div>
        </div>

        <div class="form-group" id="placeNameThumbnail">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_title">
            Place Name
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="place_id" id="places" class="form-control">
              <option > Select Place </option>
            </select>
          </div>
        </div>
  
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
            Combination Thumbnail
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
            <button type="submit" class="btn btn-success"> Save</button>
          </div>
        </div>
      
      </form>
    </div>
  </div>
@endsection
@section('scripts')
  <script>
      $('.city').on('change', function () {
        var palces = JSON.parse($(this).find(':selected').attr('data-places'));
        var html = "<select>";
        html += "<option value=''> Select Place </option>";
        $.each(palces, function(key, val){
            console.log(val);
            html += "<option value="+val.id+" > "+val.name+" </option>";
        });
        html += "</select>";
        $('#places').html(html);
      })

      $('#parentImage').on('click', function () {
	      if($(this).is(':checked')) {
            $('#placeNameThumbnail').hide('slow');
		  } else {
			$('#placeNameThumbnail').show('slow');
          }
      });
  </script>
@endsection
