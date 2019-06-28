<table class="table table-striped table-bordered dt-responsive" id="example" cellspacing="0" width="100%" style="word-wrap:break-word;
              table-layout: fixed;">
    <thead>
    <tr>
        <th>Id</th>
        <th>Image</th>
        <th>Series Name</th>
        <th>Category</th>
        <th>Status</th>
        <th>Views Count</th>
        <th>Create By</th>
        <th>Create</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @if(count($series) < 1)
        <tr>
            <td colspan="5">No Video Found</td>
        </tr>
    @endif
    @foreach($series as $val)
        @php
            $color = $val->publish >= 1 ? 'label label-success' : 'label label-danger';
            $text = $val->publish >= 1 ? 'Published' : 'UnPublished';
        @endphp
        <tr>
            <td width="2%">{{ (int)$loop->index + 1 }}</td>
            <td><img src="{{ $val->thumbnail }}" alt="{{$val->name}}" style="width: 100%; height: 70px"></td>
            <td>{{ $val->name }}</td>
            <td>{{$val->seriesCategory->categoryDetail->category_title or ''}}</td>
            <td>
                <p class="{{$color}}">{{$text}}</p>
            </td>
            <td>{{count($val->videoViews)}}</td>
            <td>{{$val->createdByUser->name or ''}}</td>
            <td>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</td>
            <td>
                <a class="btn btn-xs btn-primary" href="/admin/videos/{{$val->id}}" data-toggle="tooltip" data-placement="top" data-title="Edit" data-original-title="" title="">
                    <i class="fa fa-pencil"></i>
                </a>
                {{--/admin/video/{{$val->id}}--}}
                <a class="btn btn-xs btn-danger" href="#" data-toggle="tooltip" data-placement="top" data-title="Delete" data-original-title="" title="" onclick="var r = window.confirm('are you sure you want to delete this video?'); if(r==true){window.location='/admin/video/{{$val->id}}'}">
                    <i class="fa fa-trash"></i>
                </a>

                <a class="btn btn-xs btn-primary" href="#" data-toggle="tooltip" data-placement="top" data-title="Send Notification" data-original-title="" title="" onclick="window.location='/admin/sendNotification/?series_id={{$val->id}}'">
                    <i class="fa fa-bell"></i>
                </a>

            </td>
        </tr>
    @endforeach
    </tbody>

</table>


@if(($paginate))
    @include('admin.videos.partials.links')
@endif