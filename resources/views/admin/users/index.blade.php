@extends('admin.layouts.admin')

@section('title', 'Users')
@section('headerButton')
	{{--<input type="button" onclick="window.location='/admin/new/categories'" class="btn btn-success" style="float: right" value="Add Category   ">--}}
@endsection

@section('content')
	
	<style>
	 .table-responsive {
		 overflow-x: inherit !important;
	 }
	</style>
	<div class="row table-responsive">
		<table class="table table-striped table-bordered dt-responsive nowrap" id="datatable_wrapper" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th>Email</th>
				<th>User Names</th>
				<th>Roles</th>
				<th>Status</th>
				<th>Confirmed</th>
				<th>Created</th>
				<th>Last Updated</th>
				<th>Actions</th>
			</tr>
			</thead>
			<tbody>
			@if(count($users) < 1)
			<tr>
				<td colspan="5">No Categories Found</td>
			</tr>
			@endif
			@foreach($users as $user)
				<tr>
					<td>{{ $user->email }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->roles->pluck('name')->implode(',') }}</td>
					<td>
						@if($user->active)
							<span class="label label-primary">{{ __('views.admin.users.index.active') }}</span>
						@else
							<span class="label label-danger">{{ __('views.admin.users.index.inactive') }}</span>
						@endif
					</td>
					<td>
						@if($user->confirmed)
							<span class="label label-success">{{ __('views.admin.users.index.confirmed') }}</span>
						@else
							<span class="label label-warning">{{ __('views.admin.users.index.not_confirmed') }}</span>
						@endif</td>
					<td>{{ $user->created_at }}</td>
					<td>{{ $user->updated_at }}</td>
					<td>
						<a class="btn btn-xs btn-primary" href="{{ route('admin.users.show', [$user->id]) }}" data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.users.index.show') }}">
							<i class="fa fa-eye"></i>
						</a>
						<a class="btn btn-xs btn-info" href="{{ route('admin.users.edit', [$user->id]) }}" data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.users.index.edit') }}">
							<i class="fa fa-pencil"></i>
						</a>
						@if(!$user->hasRole('administrator'))
						<button onclick="window.location = '/admin/deleteUser/{{$user->id}}'" class="btn btn-xs btn-danger user_destroy"
						data-url="{{ route('admin.users.destroy', [$user->id]) }}" data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.users.index.delete') }}">
						<i class="fa fa-trash"></i>
						</button>
						@endif
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		
	</div>
@endsection