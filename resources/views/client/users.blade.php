@extends('client.layouts.app')

@section('content')
	<div class="row">
		<div class="col-sm-9">
			
			@include('client.includes.add1')
			
			<div class="row panel panel-default subCatView">
				<div class="panel-heading">
					<i class="fa fa-star"> </i> Celebrities
				</div>
			</div>
			
			<div class="row panel-body">
				
				@foreach(array_chunk($celebrities->all(), 6) as $videos)
					<div class="col-sm-12">
						@foreach($videos as $val)
							<div class="col-sm-2 pl3pr3">
								
								<div class="card hovercard">
									<div class="cardheader banner banner_{{$val->id}}">
										<script>
											if('{{$val->banner}}'.length > 0) {
                        $('.banner_{{$val->id}}').css('background', 'url({{$val->banner}})');
                      } else {
                        $('.banner_{{$val->id}}').css('background', 'url({{$logo}})');
                        $('.banner_{{$val->id}}').css('background-repeat', 'no-repeat !important');
                        $('.banner_{{$val->id}}').css('background-position', 'center center !important');
											}
										</script>
									</div>
									<div class="avatar">
										<img alt="user image" src="{{$val->image}}" onerror="this.src='{{asset('assets/client/images/nothumbuser.png')}}'" >
									</div>
									<div class="info">
										<div class="title">
											<a class="colorWhite font18" href="/user/{{str_replace(' ', '-', $val->name)}}">{{$val->name}}</a>
										</div>
										{{--<div class="desc colorDarkGray" >Passionate designer</div>--}}
									</div>
								
								</div>
							
							</div>
						@endforeach
					</div>
				@endforeach
					{{$celebrities->links()}}
			</div>
			
		</div>
		
		@include('client.categoriesAndTags')
	</div>
	

@endsection