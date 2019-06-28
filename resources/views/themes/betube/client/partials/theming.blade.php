@if(\Cache::get('theme') == 'betube_light')
    <style>
        .headerStyle {
            width: 100%;
            background: #fff;
        }
        .top-bar, .top-bar ul {
            background-color: #fff;
        }
        #navBar .top-bar .menu > li:not(.menu-text) > a{
            color: #6c6c6c;
        }
        body {
            background-color: #f0f0f0;
        }
        .off-canvas-content, .off-canvas-content {
            background: #f0f0f0;
        }
        .secBg {
            background: #fff;
            border: 1px solid #ececec;
        }
        #category #owl-demo-cat .item-cat h6 a {
            font-weight: 600;
            color: #444;
        }
        .button {
            background-color: #444;
        }
        .category-heading {
            border-bottom: 1px solid #ececec;
        }
        #category #owl-demo-cat .item-cat figure {
            border-bottom: 2px solid #ececec;
        }
        .thumb-border {
            border: 1px solid #ececec;
        }

        h1, h2, h3, h4, h5, h6 {
            color: #444;
        }
        .content .post .post-des h6 a {
            color: #444444 !important;
        }
    </style>
@else
    @php
        $dark = "#2e2e2e";
        $white = "#fff";
        $light = "#444444";
    @endphp
    <style>
        .headerStyle {
            width: 100%;
            background: {{$dark}};
        }
        .top-bar, .top-bar ul {
            background-color: {{$dark}};
        }
        #navBar .top-bar .menu > li:not(.menu-text) > a{
            color: {{$white}};
        }
        body {
            background-color: {{$dark}} !important;
        }
        .off-canvas-content, .off-canvas-content {
            background: {{$dark}};
        }
        .secBg {
            background: {{$light}};
            border: 1px solid {{$dark}};
        }
        #category #owl-demo-cat .item-cat h6 a {
            font-weight: 600;
            color: {{$white}};
        }
        .button {
            background-color: {{$dark}};
        }
        .category-heading {
            border-bottom: 1px solid {{$dark}};
        }
        #category #owl-demo-cat .item-cat figure {
            border-bottom: 2px solid {{$dark}};
        }
        .thumb-border {
            border: 1px solid {{$dark}};
            background-color: {{$dark}};
        }

        h1, h2, h3, h4, h5, h6 {
            color: {{$white}};
        }
        .owl-carousel .owl-item {
            background-color: {{$dark}};
        }
        .tabs-content {
            background: {{$light}};
        }
        .content .post .post-des h6 a {
            color: {{$white}} !important;
        }
        .sticky-container {
            background-color: {{$dark}};
        }
        .content .head-text {
            border-bottom: 1px solid {{$dark}};

        }
        .pagination a.next {
            background: {{$dark}};
            color: {{$white}};
            border: 1px solid {{$dark}};
        }
        .pagination a.prev {
            background: {{$dark}};
            color: {{$white}};
            border: 1px solid {{$dark}};
        }
        .pagination a {
            background: {{$dark}};
            color: {{$white}};
            border: 1px solid {{$dark}};
        }
        .sidebar .widgetBox .widgetTitle h5 {
            border-bottom: 1px solid {{$dark}};
        }
        .sidebar .widgetBox .widgetContent .accordion .accordion-title {
            padding: 15px;
            font-size: 14px;
            font-weight: bold;
            background: {{$dark}};
            color: {{$white}};
            text-transform: capitalize;
        }
        .accordion-title {
            border-bottom: 1px solid {{$light}};
        }
        .sidebar .widgetBox .widgetContent .accordion {
            border-color: {{$light}};
        }
        .txtColor {
            color: {{$white}};
        }
        .moviesImage {
            border: 1px solid {{$dark}} !important;
        }
        p {
            color: {{$white}} !important;
        }
        a.colorWhite.font18 {
            color: {{$white}};
        }
        .sidebar .widgetBox .widgetContent .profile-overview li a {
            color: {{$white}};
        }
        .sidebar .widgetBox .widgetContent .profile-overview li {
            background-color: {{$dark}};
            border: 1px solid {{$dark}};
        }
        .sidebar .widgetBox .widgetContent .profile-overview li {
            border: 1px solid {{$light}};
        }
        .singlePostDescription .description button {
            padding: 0 10px;
            height: 30px;
            border: 1px solid {{$light}};
            border-radius: 4px;
            font-size: 13px;
            color: {{$white}};
            font-weight: bold;
            cursor: auto;
            background: {{$dark}};
        }
        .profile-inner .heading {
            border-bottom: 1px solid {{$dark}};
        }
        .profile-inner .profile-videos .profile-video {
            border: 1px solid {{$dark}};
        }
        .profile-inner .profile-videos .profile-video .media-object .video-img {
            border-right: none;
        }
        .title-bar {
            background: {{$dark}};
        }

        #navBar .topnav .title-bar {
            background: {{$dark}};

        }
        .light-off-menu {
            background: {{$dark}};
        }
        .light-off-menu .off-menu li a {
            color: {{$white}};
        }
        #premium {
            background: {{$white}} none repeat scroll 0 0;
            border-bottom: 1px solid {{$dark}};
            border-top: 1px solid {{$dark}};
            margin-bottom: 30px;
            margin-top: 30px;
            background-color: {{$dark}};
        }
        .registration {
            background-color: {{$dark}};
        }
        .registration .middle-text p span {
            color: {{$white}};
        }
        label {
            color: white;
        }
        .registration .register-form .loginclick a {
            color: white;
        }
        .SinglePostStats .media-object .author-des .post-title h4 {
            color: {{$white}}
        }
        .SinglePostStats .media-object .author-img-sec p a {
            color: {{$white}};
        }
        .thumbnail {
            border-radius: 50% !important;
            border: none;
        }
        .borderCircle {
            border-radius: 50% !important;
        }
        @media screen and (max-width: 480px) and (min-width: 320px) {
            #navBar .topnav .title-bar .menu-icon::after {
                background: {{$white}} ;
                box-shadow: 0 7px 0 {{$white}}, 0 14px 0 {{$white}};
            }
        }
        @media screen and (max-width: 1024px) and (min-width: 640px){
            #navBar .topnav .title-bar .menu-icon::after {
                background: {{$white}};
                box-shadow: 0 7px 0 {{$white}}, 0 14px 0 {{$white}};
            }
        }
        .cHand {
            cursor: pointer;
        }
    </style>
@endif