@extends('admin.layouts.admin')

@section('title')
	Mass Emails
@endsection

@section('content')
	
	<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />



	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<form method="POST" action="/admin/postMassEmail" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
				{{csrf_field()}}
				
				<div style="color: red">{{($errors->first())}}</div>
				
				
				<div class="form-group">
					<label class="control-label col-md-12 col-sm-12 col-xs-12" for="website_name" style="float: left; text-align: left">
						Email Subject
					</label>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<input class="form-control" type="text" name="subject">
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="control-label col-md-12 col-sm-12 col-xs-12" for="website_name" style="float: left; text-align: left">
						Email Content
					</label>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<textarea name="content" id="" class="form-control">{{isset($config->content) ? $config->content : ''}}</textarea>
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
