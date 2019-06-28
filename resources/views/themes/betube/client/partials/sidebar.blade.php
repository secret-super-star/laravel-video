
<!-- sidebar -->
<div class="large-4 columns padding-right-remove">
    <aside class="secBg sidebar">
        <div class="row">


            <!-- ad Section -->
            <div class="googleAdv text-center">
                @include('client.partials.add3')
            </div><!-- End ad Section -->


            <div class="large-12 medium-7 medium-centered columns">
                <div class="widgetBox">
                    <div class="widgetTitle">
                        <h5>categories</h5>
                    </div>
                    <div class="widgetContent">
                        <ul class="accordion" data-accordion="wtkjkg-accordion" role="tablist">
                            @foreach($categories as $key => $val)
                                <li class="accordion-item " data-accordion-item="">
                                    <a href="javascript:;" onclick="showCategories('{{str_replace(' ', '-', $val->category_title)}}')"  class="accordion-title" aria-controls="i2bjiu-accordion" role="tab" id="i2bjiu-accordion-label" aria-expanded="true" aria-selected="true">
                                        <span onclick="showCategories('{{str_replace(' ', '-', $val->category_title)}}')">
                                            {{$val->category_title}}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>


        </div>
    </aside>
</div><!-- end sidebar -->