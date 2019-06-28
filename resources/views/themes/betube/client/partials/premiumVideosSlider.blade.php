
<!-- Premium Videos -->
<section id="premium" class="premium">
    <div class="row">
        <div class="heading clearfix">
            <div class="large-11 columns">
                <h4><i class="fa fa-play-circle-o"></i>Featured Videos</h4>
            </div>
            <div class="large-1 columns">
                <div class="navText show-for-large">
                    <a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
                    <a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div id="owl-demo" class="owl-carousel carousel" data-car-length="4" data-items="4" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="3000" data-dots="false" data-auto-width="false" data-responsive-small="1" data-responsive-medium="2" data-responsive-xlarge="5">
        @foreach($featuredSeries as $val)
            <div class="item">
                <input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}">

                <figure class="premium-img">
                    <img src="{{$val->thumbnail}}" alt="carousel" onclick="redirectMe('{{$val->id}}')">
                    <figcaption>
                        <h5>{{$val->name}}</h5>
                    </figcaption>
                </figure>
                <a href="javascript:;" class="hover-posts" onclick="redirectMe('{{$val->id}}')">
                    <span><i class="fa fa-play"></i>Watch {{$val->name}}</span>
                </a>
            </div>
        @endforeach
    </div>
</section><!-- End Premium Videos -->
