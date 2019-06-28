
<!-- Category -->
<section id="category" class="marginzero">
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="column row">
                <div class="heading category-heading clearfix">
                    <div class="cat-head pull-left">
                        <i class="fa fa-folder-open"></i>
                        <h1>Browse Videos By Category</h1>
                    </div>
                    <div>
                        <div class="navText pull-right show-for-large">
                            <a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
                            <a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- category carousel -->
            <div id="owl-demo-cat" class="owl-carousel carousel" data-car-length="6" data-items="6" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="4000" data-auto-width="true" data-margin="10" data-dots="false">
                @foreach($categories as $ley => $val)
                <div class="item-cat item thumb-border">
                    <figure class="premium-img" onclick="window.location='/category/{{str_replace(' ', '-', $val->category_title)}}'">
                        <img src="{{$val->category_image}}" alt="{{$val->category_title}}">
                        <a href="javascript:;"  class="hover-posts">
                            <span><i class="fa fa-search"></i></span>
                        </a>
                    </figure>
                    <h6><a href="javascript:;"  onclick="window.location='/category/{{str_replace(' ', '-', $val->category_title)}}'">{{$val->category_title }}</a></h6>
                </div>
                @endforeach
            </div><!-- end carousel -->
            <div class="row collapse">
                <div class="large-12 columns text-center row-btn">
                    <a href="/categories" class="button radius">View All Categories</a>
                </div>
            </div>
        </div>
    </div>
</section><!-- End Category -->
<style>
.owl-carousel {
    display: block !important;
}
</style>