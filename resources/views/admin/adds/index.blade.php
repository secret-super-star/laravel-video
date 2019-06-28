@extends('admin.layouts.admin')

@section('title', 'Adds')
@section('headerButton')
@endsection

@section('content')
	
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<form id="demo-form" data-parsley-validate=""  method="post">
				{{csrf_field()}}
				<label for="fullname">First Add :</label>
				<textarea name="add1" id="" class="form-control">{{isset($adds->add1) ? $adds->add1 : ''}}</textarea>
				
				<label for="email">Second Add :</label>
				<textarea name="add2" id="" class="form-control">{{isset($adds->add2) ? $adds->add2 : ''}}</textarea>
				
				<label for="email">Third Add :</label>
				<textarea name="add3" id="" class="form-control">{{isset($adds->add3) ? $adds->add3 : ''}}</textarea>
				<br/>
				
				<input type="submit" class="btn btn-success pull-right" value="Save Add">
			</form>
		</div>
		
	</div>

@endsection