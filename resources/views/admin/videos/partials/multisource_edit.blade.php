@extends('admin.layouts.admin')

@section('title')
  Add Video
@endsection
@section('js')
  <script>
		$(function () {
			$('#name').on('change', function(){
				var vidTitle = ($('#name').val());
				$('#description').text( vidTitle + ' {{$config->video_description or ''}}');
			})
		})
  </script>
@endsection
@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <form method="POST" action="/admin/videos/updateVideo/multiple" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
        {{csrf_field()}}
{{--        @if($errors->has())--}}
        <div>
          @foreach ($errors->all() as $error)
            <div style="color: red">{{ $error }}</div>
          @endforeach
        </div>
        {{--@endif--}}
  
        <input type="hidden" name="series_id" value="{{$series->id}}">
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Video Name
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="name" type="text" value="{{$series->name}}" class="form-control col-md-7 col-xs-12 " name="name" required="">
            <input id="name" type="hidden" value="{{$series->name}}" class="form-control col-md-7 col-xs-12 " name="oldname" required="">
          </div>
        </div>
        
        
        {{--<div class="form-group">--}}
          {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">--}}
            {{--Video Title--}}
            {{--<span class="required">*</span>--}}
          {{--</label>--}}
          {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
            {{--<input id="title" type="text" value="{{$series->title}}" class="form-control col-md-7 col-xs-12 " name="title" required="">--}}
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
            <input id="mythumbnail" name="mythumbnail" type="text" value="{{$series->thumbnail}}" class="form-control" style="display: none">
            <img src="{{$series->thumbnail}}" alt="{{$series->name}}" style="width: 100px;" id="addVideoThumb">
            {{--<a class="fancybox" rel="group" href="{{$series->thumbnail}}" id="addVideoThumbHeader">--}}
            {{--<img src="{{$series->thumbnail}}" id="addVideoThumb" alt="" style="width: 100px;" />--}}
            {{--</a>--}}
          </div>
        </div>
  
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Featured Video
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="checkbox" class="" name="featured" {{$series->featured == 1 ? 'checked' : ''}}>
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Video Description
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <textarea name="description" id="description" cols="30" rows="10"  class="form-control col-md-7 col-xs-12 ">{{$series->description or ''}}</textarea>
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
                @if($series->seriesCategory->category_id == $val->id)
                  <option value="{{$val->id}}" selected>{{$val->category_title}}</option>
                @else
                <option value="{{$val->id}}">{{$val->category_title}}</option>
                @endif
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
              @foreach($subCategories->subCategories as $key => $val)
                @if($series->seriesCategory->subCategoryDetail->id == $val->id)
                  <option value="{{$val->id}}" selected>{{$val->category_title}}</option>
                @else
                <option value="{{$val->id}}">{{$val->category_title}}</option>
                @endif
              @endforeach
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
                @if($series->seriesTag->contains('tag_id', $val->id))
                  <option value="{{$val->id}}" selected>{{$val->tag}}</option>
                @else
                <option value="{{$val->id}}">{{$val->tag}}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div>

        @if(isset($celebrity_module) && $celebrity_module)
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="celebrities">
            Video Celebrities
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="celebrities[]" id="" class="js-example-basic-multiple"  multiple="multiple" style="width: 100%">
              @foreach($celebrities as $val)
                @if($series->seriesCelebrities->contains('celebrities_id', $val->id))
                  <option value="{{$val->id}}" selected>{{$val->name}}</option>
                @else
                <option value="{{$val->id}}">{{$val->name}}</option>
                @endif
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
            <input type="checkbox" class="" name="publish" {{$series->publish == 1 ? 'checked' : ''}}>
          </div>
        </div>
        
        
        <hr style="border-color: #999;width: 77%;">
  
  
        @for($i=1; $i < 4; $i++ )
  
        <div class="form-group" id="videoDiv_src{{$i}}">
          <h4 class="col-md-offset-1">Source # {{$i}}</h4>

        <?php
           $oldData = array();
          ?>
          @foreach($series->seriesVideos as $val)
          <div class="col-md-11 col-md-offset-1 videoDivInner" data-obj="{{$val}}" id="videoDivInner{{$loop->first ? '' : '_'.$loop->index}}">
            @if($loop->first)
            @endif
            
           @if($val->source_no == 0) 
				@php($val->source_no = 1)
		   @endif
		   
           @if($val->source_no == $i) 
            <div class="col-md-1">
              <label for="" class="label label-info">Add Video</label>
            </div>
            <div class="col-md-3 sourceTypeDiv">
              <select name="sourceType{{$i}}[]" id="sourceType" class="form-control sourceType">
                <?php
                $third = '';
                $own = '';
                $display = 'none';
                $thirdDisplay = 'block';
                  if((int)$val->source_type == 1) {
                    $third = 'selected';
                  } else {
                    $own = 'selected';
                    $display = 'block';
                    $thirdDisplay = 'none';
                  }
                ?>
                <option value="">Select Method</option>
                <option value="1" {{$third}}>3rd Party</option>
                <option value="2" {{$own}}>Own Upload</option>
              </select>
            </div>
            
            <div class="col-md-3 showHideClass">
              <span class="local" style="display: {{$thirdDisplay}}">
                <input type="text" name="textSource{{$i}}[]" value="{{$thirdDisplay == 'block' ? $val->path : ''}}" placeholder="i.e. youtube.com/abcxyz" class="form-control">
              </span>
              <span class="outsource"  style="display: {{$display}}">
                <input type="file" name="uploadFile{{$i}}[]">
                <span style="word-wrap: break-word">{{$display == 'block' ? $val->path : ''}}</span>
              </span>
            </div>
            
            <?php
            if (isset($index) && $index > 0) {
	            //$index++;
            }else {
                $index = 0;
               // $index++;
            }
            array_push($oldData, array(
              'sourceType' => $val->source_type,
              'path' => $val->path,
              'id' => $val->id,
              'thumbnail' => $val->thumbnail,
              'source_no' => $i,
              'key' => $index
            ));
            if (isset($index) && $index >= 0) {
              $index++;
            }else {
              $index = 0;
              $index++;
            }
            ?>
            
            <div class="col-md-3">
              <input type="hidden" id="srcRemove" value="{{$i}}">
              <input type="button"  value="Remove" class="form-control btn btn-danger removeMeNow" >
            </div>
            
           @endif
          </div>
            @if($loop->last)
                <input type="hidden" value="{{json_encode($oldData)}}" name="oldData">
                  @php
                  $index = 0;
                  @endphp
            @endif
          @endforeach
        </div>
  
        <input type="hidden" value="{{json_encode($series->seriesVideos)}}" name="dat">
        <div class="form-group" >
          <input type="hidden" id="src" value="{{$i}}">
          <input type="button" class="addMore btn btn-primary pull-right" value="Add More Videos" style="margin-right: 10%">
        </div>
        @endfor
  
        <br/>
        <br/>
        <br/>
        <br/>
        <div class="form-group">

          <br/>
          <div class="col-md-12 col-sm-12 col-xs-12">
            {{--<a class="btn btn-primary" href="http://localhost:8000/admin/users"> Cancel</a>--}}
            <button type="submit" class="btn btn-success" style="float: right; margin-right: 100px" onclick="$.LoadingOverlay('show');" > Save Video</button>
          </div>
        </div>
  

        
      </form>
    </div>
  </div>
@endsection
