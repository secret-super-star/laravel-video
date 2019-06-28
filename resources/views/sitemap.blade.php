<?php
echo '<?xml version="1.0" encoding="UTF-8"?>'
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
	@foreach($videos as $video)
		<url>
		<loc>{{secure_url('video/'.str_replace('#', '_', str_replace(' ', '-', $video->link)))}}</loc>
		<video:video>
			<video:thumbnail_loc>{{ str_replace('http:', 'https:', $video->thumbnail) }}</video:thumbnail_loc>
			<video:title>{{$video->name}}</video:title>
			<video:description>{{$video->description}}</video:description>
			<video:view_count>{{count($video->videoViews)}}</video:view_count>
			<video:publication_date>{{\Carbon\Carbon::parse($video->created_at)->toIso8601String()}}</video:publication_date>
			<video:family_friendly>yes</video:family_friendly>
			<video:gallery_loc title="{{$video->seriesCategory->categoryDetail->category_title}}">{{secure_url('video/'.str_replace('#', '_', str_replace(' ', '-', $video->name)))}}</video:gallery_loc>
			<video:requires_subscription>no</video:requires_subscription>
			<video:uploader info="{{URL::to('user/').'/'.str_replace(' ', '-', $video->createdByUser->name)}}">{{URL::to('user/').'/'.str_replace(' ', '-', $video->createdByUser->name)}}</video:uploader>
		</video:video>
		</url>
	@endforeach
	

</urlset>