@extends('admin.layouts.admin')

@section('title')
	Enable Modules
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<form method="POST" action="/admin/setupModules" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
				{{csrf_field()}}
				
				<div style="color: red">{{($errors->first())}}</div>

				@php
					$celebritycheck = '';
					$videocheck = '';
					$multiVideos = '';
					if(isset($modules)) {
					foreach($modules as $key => $val) {
					        try {
							if($val->module_name == "Celebrities") {
								if ((int)$val->modulesStatus->status == 1) {
									$celebritycheck = 'checked';
								}
							}
							} catch(\Exception $e){
									$celebritycheck = '';
							}

					        try {
							if($val->module_name == "Groups") {
								if ((int)$val->modulesStatus->status == 1) {
									$videocheck = 'checked';
								}
							}
							} catch(\Exception $e){
									$videocheck = '';
							}

							try{
							if($val->module_name == "Multi Source") {
								if ((int)$val->modulesStatus->status == 1) {
									$multiVideos = 'checked';
								}
							}
							} catch(\Exception $e){
									$multiVideos = '';
							}
					}
				}
				@endphp
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="website_name">
						Celebrity
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="checkbox" name="celebrity"  value="0" {{$celebritycheck}}>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="website_name">
						Video Groups
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="checkbox" name="groups" value="0" {{$videocheck}}>
					</div>
				</div>


				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="website_name">
						Multiple Videos
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="checkbox" name="multiple_videos" value="0" {{$multiVideos or ''}}>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						<button type="submit" class="btn btn-success"> Save </button>
					</div>
				</div>
			
			</form>
		</div>
	</div>
@endsection
