@extends('admin.layouts.admin')

@section('title')
  Add Video
@endsection
@section('js')
  <script>
		$(function () {
			$('#name').on('change paste keyup', function(){
				var vidTitle = ($('#name').val());
				$('#description').text( vidTitle + ' {{$config->video_description or ''}}');
			});

            $('#name').on('change paste keyup', function(){
                console.log($(this).val());

                $.ajax({
                    url: '/api/validate/series?name='+$(this).val(),
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(result){
                        console.log((result.validate));
                        if (result.validate) {
	                        $('#videxisterrr').show();
	                        $("#btnSubmit").attr("disabled", "disabled");

                        } else {
                        	$('#videxisterrr').hide();
	                        $("#btnSubmit").removeAttr("disabled");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            })
		})
  </script>
@endsection
@section('content')
  <style>
    .text-danger {
      color: red;
      font-size: 15px;
    }
  </style>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <form method="POST" action="/admin/videos/addVideo/multiple" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
        {{csrf_field()}}
        <div style="color: red">{{($errors->first())}}</div>
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Video Name
            <span class="required">
              *
            </span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="name" type="text" value="{{old('name')}}" class="form-control col-md-7 col-xs-12 " name="name" required="" autocomplete="off">

            <div class="col-md-6 col-sm-6 col-xs-12">
              <span class="text text-danger" id="videxisterrr" style="display: none">Video Already Exist..!</span>
            </div>
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
            Video Thumbnail
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
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Featured Video
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="checkbox" class="" name="featured">
          </div>
        </div>
        
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Video Description
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <textarea name="description" id="description" cols="30" rows="10"  class="form-control col-md-7 col-xs-12 ">{{old('description')}}</textarea>
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Video Categories
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="category" id="category" class="form-control">
              <option value="">Select Category</option>
              @foreach($categories as $val)
                <option value="{{$val->id}}">{{$val->category_title}}</option>
              @endforeach
            </select>
          </div>
        </div>
        
        <div class="form-group" id="subcategories">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Video Sub Categories
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="subcategory" id="subcategory" class="form-control">
              <option value="">Select Sub Category</option>
              <span id="subcategoriesvalues"></span>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Video Tags
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="tags[]" id="" class="js-example-basic-multiple"  multiple="multiple" style="width: 100%">
              @foreach($tags as $val)
                <option value="{{$val->id}}">{{$val->tag}}</option>
              @endforeach
            </select>
          </div>
        </div>

        @if(isset($celebrity_module) && $celebrity_module)
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="celebrities">
            Video Celebrities
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="celebrities[]" id="" class="js-example-basic-multiple"  multiple="multiple" style="width: 100%">
              @foreach($celebrities as $val)
                <option value="{{$val->id}}">{{$val->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        @endif
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Publish Video
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="checkbox" class="" name="publish" checked>
          </div>
        </div>
  
        
  
        <hr style="border-color: #999;width: 77%;">
  

        
        @for($i=1; $i < 4; $i++ )
        
        <div class="form-group" id="videoDiv_src{{$i}}">
          <h4 class="col-md-offset-1">Source # {{$i}}</h4>

          <div class="col-md-11 col-md-offset-1 videoDivInner" id="videoDivInner">
            <div class="col-md-1">
              <label for="" class="label label-info">Add Video</label>
            </div>
            <div class="col-md-3 sourceTypeDiv">
              <select name="sourceType{{$i}}[]" id="sourceType" class="form-control sourceType">
                <option value="">Select Method</option>
                <option value="1" selected>3rd Party</option>
                <option value="2">Own Upload</option>
              </select>
              <input type="hidden" id="srcMethod" value="{{$i}}" name="asd ">

            </div>
            <div class="col-md-3 showHideClass">
              <span class="local" >
                <input type="text" name="textSource{{$i}}[]" value="" placeholder="i.e. youtube.com/abcxyz" class="form-control">
              </span>
              <span class="outsource"  style="display: none">
                <input type="file" name="uploadFile{{$i}}[]">
              </span>
            </div>

            <div class="col-md-3">
              <input type="hidden" id="srcRemove" value="{{$i}}">
              <input type="button"  value="Remove" class="form-control btn btn-danger removeMe" >
            </div>
          </div>
        </div>
  
        <div class="form-group" >
          {{--<p href="" style="float: right" class="addMore"><u><b>Add More Videos</b></u></p>--}}
          <input type="hidden" id="src" value="{{$i}}">
          <input type="button" class="addMore btn btn-primary pull-right" value="Add More Videos" style="margin-right: 10%">
        </div>
        
        @endfor
        {{--<div id="videoSource">--}}
          {{--<div class="form-group">--}}
            {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">--}}
              {{--Videos--}}
              {{--<span class="required">*</span>--}}
            {{--</label>--}}
            {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
              {{--<select name="sourceType" id="sourceType" class="form-control">--}}
                {{--<option value="">Select Method</option>--}}
                {{--<option value="1">3rd Party</option>--}}
                {{--<option value="2">Own Upload</option>--}}
              {{--</select>--}}
            {{--</div>--}}
          {{--</div>--}}
          {{----}}
          {{--<div class="form-group local" style="display: none">--}}
            {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">--}}
             {{----}}
              {{--<span class="required">*</span>--}}
            {{--</label>--}}
            {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
              {{--<input type="file" >--}}
            {{--</div>--}}
          {{--</div>--}}
          {{----}}
          {{--<div class="form-group outsource" style="display: none">--}}
            {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">--}}
             {{----}}
              {{--<span class="required">*</span>--}}
            {{--</label>--}}
            {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
              {{--<input type="text"  value="" placeholder="i.e. youtube.com/abcxyz" class="form-control">--}}
            {{--</div>--}}
          {{--</div>--}}
        {{--</div>--}}
        {{----}}
          {{--<div class="form-group actions" style="display: none">--}}
            {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">--}}
              {{----}}
              {{--<span class="required"></span>--}}
            {{--</label>--}}
            {{--<div class="col-md-3 col-sm-3 col-xs-12">--}}
              {{--<input type="button"  value="Add More" class="form-control btn btn-primary addVideo">--}}
            {{--</div>--}}
            {{--<div class="col-md-3 col-sm-3 col-xs-12">--}}
              {{--<input type="button"  value="Remove" class="form-control btn btn-danger">--}}
            {{--</div>--}}
          {{--</div>--}}
        {{----}}
      
        
        <br/>
        <br/>
        <br/>
        <br/>
        <div class="form-group">

          <br/>
          <div class="col-md-12 col-sm-12 col-xs-12 ">
            {{--<a class="btn btn-primary" href="http://localhost:8000/admin/users"> Cancel</a>--}}
            <button type="submit" class="btn btn-success" onclick="$.LoadingOverlay('show');" style="float: right; margin-right: 100px" id="btnSubmit" disabled> Save Video</button>
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
