@extends('admin.layouts.admin')

@section('title')
	Privacy Policy
@endsection

@section('content')
	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
	
	<!-- Include Editor style. -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/froala_style.min.css" rel="stylesheet" type="text/css" />

	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<form method="POST" action="/admin/postCreatePrivacyPolicy" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
				{{csrf_field()}}
				
				<div style="color: red">{{($errors->first())}}</div>
				
				
				<div class="form-group">
					<label class="control-label col-md-12 col-sm-12 col-xs-12" for="website_name" style="float: left; text-align: left">
						Privacy Policy
					</label>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<textarea name="content" id="" class="form-control">{{isset($config->content) ? $config->content : ''}}</textarea>
					</div>
				</div>
				
				
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12" >
						{{--<a class="btn btn-primary" href="https://localhost:8000/admin/users"> Cancel</a>--}}
						<button type="submit" class="btn btn-success"> Save </button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
