@extends('admin.layouts.admin')

@section('title')
	Mass Notification
@endsection

@section('content')
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<form method="POST" action="/admin/sendNotification" accept-charset="UTF-8" enctype="multipart/form-data"  class="form-horizontal form-label-left">
				{{csrf_field()}}
				
				<div style="color: red">{{($errors->first())}}</div>
				
				
				<div class="form-group">
					<label class="control-label col-md-12 col-sm-12 col-xs-12" for="website_name" style="float: left; text-align: left">
						Select Video
					</label>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<select name="series_id" id="series_id" class="form-control">
							@foreach($videos as $key => $val)
								<option value="{{$val->id}}">{{$val->name}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12" >
						{{--<a class="btn btn-primary" href="http://localhost:8000/admin/users"> Cancel</a>--}}
						<button type="submit" class="btn btn-success" onclick="$.LoadingOverlay('show');">Send</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
