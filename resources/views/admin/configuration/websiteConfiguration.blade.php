@extends('admin.layouts.admin')

@section('title')
	Configure Website
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<form method="POST" action="/admin/websiteConfiguration" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
				{{csrf_field()}}
				
				<div style="color: red">{{($errors->first())}}</div>
				
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="website_name">
						Website Name
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="website_name" type="text" value="{{isset($config->website_name) ? $config->website_name : ''}}" class="form-control col-md-7 col-xs-12 " name="website_name" required="">
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="website_favicon">
						Website FavIcon
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="website_favicon" type="file" name="web_favicon" onchange="previewFileBySrc('website_favicon', 'favicon_preview')">
						<img src="{{isset($config->website_favicon) ? $config->website_favicon : ''}}" alt="" style="width: 100px;" id="favicon_preview">
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="website_logo">
						Website Logo
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="website_logo" type="file" name="web_logo" onchange="previewFileBySrc('website_logo', 'preview_logo')">
						<img src="{{isset($config->website_logo) ? $config->website_logo : ''}}" alt="" style="width: 100px;" id="preview_logo">
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="meta_title">
						Website Theme
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<select name="website_theme" id="website_theme" class="form-control">
							@php
							  $dark = '';
							  $bt_light = '';
							  $bt_dark = '';
							@endphp
							@if($config->website_theme == 'default')
								@php
									$dark = 'selected';
								@endphp
							@elseif($config->website_theme == 'betube_light')
								@php
									$bt_light = 'selected';
								@endphp
							@elseif($config->website_theme == 'betube_dark')
								@php
									$bt_dark = 'selected';
								@endphp
							@endif

							<option value="default" {{$dark}}>Default</option>
							<option value="betube_light" {{$bt_light}}>Betube Light</option>
							<option value="betube_dark" {{$bt_dark}}>Betube Dark</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="meta_title">
						Meta Title
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<textarea name="meta_title" class="form-control" id="meta_title">{{$config->meta_title or ''}}</textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="meta_title">
						Video Description (static text)
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="video_description" class="form-control" value="{{$config->video_description or ''}}">
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="meta_description">
						Meta Description
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<textarea class="form-control" name="meta_description" id="meta_description" >{{isset($config->meta_description) ? $config->meta_description : ''}}</textarea>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="g_analytics">
						Google Analytics
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<textarea class="form-control" name="g_analytics" id="g_analytics" >{{isset($config->g_analytics)  ? $config->g_analytics : ''}}</textarea>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook_app_id">
						Facebook App ID
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="facebook_app_id" type="text" value="{{isset($config->fb_app_id) ? $config->fb_app_id : ''}}" name="fb_app_id" class="form-control col-md-7 col-xs-12 " >
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="fb_app_secret">
						Facebook App Secret
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="fb_app_secret" type="text" value="{{isset($config->fb_app_secret) ? $config->fb_app_secret : ''}}" name="fb_app_secret" class="form-control col-md-7 col-xs-12 " >
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="fb_page_widget">
						Facebook Page Widget
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<textarea name="fb_page_widget" id="fb_page_widget"  class="form-control">{{isset($config->fb_page_widget) ?  $config->fb_page_widget : ''}}</textarea>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_user_name">
						SMTP Email
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="smtp_user_name" type="text" value="{{isset($config->smtp_user_name) ? $config->smtp_user_name : ''}}" name="smtp_user_name" class="form-control col-md-7 col-xs-12" placeholder="i.e. abc@gmail.com">
					</div>
					<div class="col-md-3 col-sm-3 col-sx-12">
						<p><i>i.e.  abc@gmail.com</i></p>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_user_password">
						SMTP Password
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="smtp_user_password" type="password" value="{{isset($config->smtp_user_password) ? $config->smtp_user_password : ''}}" name="smtp_user_password" class="form-control col-md-7 col-xs-12 " >
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_user_host">
						SMTP Host
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="smtp_user_host" type="text" value="{{isset($config->smtp_user_host) ? $config->smtp_user_host : ''}}" name="smtp_user_host" class="form-control col-md-7 col-xs-12 " placeholder="smtp.gmail.com">
					</div>
					
					<div class="col-md-3 col-sm-3 col-sx-12">
						<p><i>i.e. smtp.gmail.com</i></p>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_user_port">
						SMTP Port
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="smtp_user_port" type="text" value="{{isset($config->smtp_user_port) ? $config->smtp_user_port : ''}}" name="smtp_user_port" class="form-control col-md-7 col-xs-12 " placeholder="i.e. 587">
					</div>
					
					<div class="col-md-3 col-sm-3 col-sx-12">
						<p><i>i.e. 587</i></p>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_user_encryption">
						SMTP Encryption
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="smtp_user_encryption" type="text" value="{{isset($config->smtp_user_encryption) ? $config->smtp_user_encryption : ''}}" name="smtp_user_encryption" class="form-control col-md-7 col-xs-12 " placeholder="i.e tls">
					</div>
					
					<div class="col-md-3 col-sm-3 col-sx-12">
						<p><i>i.e. tls</i></p>
					</div>
				</div>
				
				
				<div class="form-group">
					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						{{--<a class="btn btn-primary" href="http://localhost:8000/admin/users"> Cancel</a>--}}
						<button type="submit" class="btn btn-success"> Save </button>
					</div>
				</div>
			
			</form>
		</div>
	</div>
@endsection
