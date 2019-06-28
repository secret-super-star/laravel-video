@if($multisource_videos)
    @include('admin.videos.partials.multisource_edit')
@else
    @include('admin.videos.partials.singlesource_edit')
@endif
