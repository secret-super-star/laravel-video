<div class="col-sm-3">
	<div class="row panel panel-default mt15 row2">
		@include('client.includes.add3')
		
		<div class="panel-heading text-center"><i class="fa fa-list"> </i> Related VideosX
		</div>
		<div class="panel-body related_container p0" >
			@foreach($relatedSeries as $key => $val)
				<div class="row related">
					<div class="col-xs-12 col-sm-4 col-md-5 ts-thumbnail-view pl0pr5">
						<article data-title-position="below-image" class="post-88 video type-video status-publish has-post-thumbnail hentry tag-slimvideo tag-theme tag-top-video-theme tag-touchsize tag-videotheme tag-wordpress-themes videos_categories-music mb0">
							<div class="image-holder">
								<input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', $val->link))}}">
								
								<a href="#" onclick="redirectMe('{{$val->id}}')" class="video_img_link">
									<img src="{{$val->thumbnail}}" alt="{{$val->name}}" data-name="6ww51" data-tipo="custom" data-current="1" data-total="1" class="redMe">
								</a>
								@if($val->duration > 0)
								<div class="duration-small">{{$val->getMSDuration()}}</div>
								@endif
							</div>
						</article>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-7 ts-thumbnail-view pl5pr0">
						<article data-title-position="below-image" class="post-88 video type-video status-publish has-post-thumbnail hentry tag-slimvideo tag-theme tag-top-video-theme tag-touchsize tag-videotheme tag-wordpress-themes videos_categories-music mb0">
							<section>
								<div class="inner-section">
									<div class="entry-content">
										<div class="entry-title">
											<a href="#" onclick="redirectMe('{{$val->id}}')"><h5>{{strlen($val->name) > 45 ? substr($val->name,0,45)."..." : $val->name}}</h5></a>
										</div>
										<ul class="entry-meta">
											<li class="entry-article-date">{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</li>
										</ul>
									</div>
								</div>
							</section>
						</article>
					</div>
				</div>
			@endforeach
		</div>
	
	</div>
</div>