<div class="col-sm-3">
	<div class="row row1 panel panel-default">
		@include('client.includes.add3')
		@if(\Request::path() == '/')
			<div class="mb10">
			{!! $fb_page_widget !!}
			</div>
		@endif
		<div class="panel-heading text-center">
			<h2><i class="fa fa-list"> </i> Categories</h2>
		</div>
		<div class="panel-body">
			<div class="row">
				@if(count($categories ) < 1)
					<p class="txtCenter">No Categories Added Yet</p>
				@endif
				@foreach(array_chunk($categories->all(), 2) as $categoriesTags)
					<div class="row">
						@foreach($categoriesTags as $key => $val)
							<div class="col-sm-6 col-md-6 catThum center text-center cPointer" onclick="window.location='/category/{{str_replace(' ', '-', $val->category_title)}}'">
								{{--<div class="col-sm-6 catThum center">--}}
								<img src="{{$val->category_image}}" alt="{{$val->category_title}}" class="w80PH100p">
								<p class="pl2">{{$val->category_title }}</p>
							</div>
						@endforeach
					</div>
				@endforeach
			</div>
		
		</div>
		<div class="panel panel-default mt15">
			<div class="panel-heading text-center">
				<h2><i class="fa fa-tags"> </i> Tags</h2>
			
			</div>
			<div class="panel-body">
				<a href="#">
					@if(count($tags) < 1)
						<p class="txtCenter">No Tags Added Yet</p>
					@endif
					@foreach($tags as $val)
						<span class="badge cHand" onclick="window.location='/tags/{{str_replace(' ', '-', $val->tag)}}'">{{$val->tag}}</span>
					@endforeach
				</a><br>
			</div>
		</div>
	</div>
</div>