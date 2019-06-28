@if($multisource_videos)
	@include('client.multiple_seriesVideo')
@else
	@include('client.single_seriesVideo')
@endif
