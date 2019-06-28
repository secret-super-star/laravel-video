@if($multisource_videos)
    @include('admin.videos.partials.multisource_add')
@else
    @include('admin.videos.partials.singlesource_add')
@endif
