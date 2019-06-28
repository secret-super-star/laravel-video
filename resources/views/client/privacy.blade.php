@extends('client.layouts.app')

@section('content')
	<style>
		.content h1 {
			font-size: 36px !important;
		}

		.content h2 {
			font-size: 30px !important;
		}

		.content h3 {
			font-size: 16px !important;
		}

		.content .h1, .h2, .h3, h1, h2, h3 {
			margin-top: 20px;
			margin-bottom: 10px;
		}
	</style>

	<div class="row">
		<div class="col-sm-9">
			@include('client.includes.add1')
			<div class="row panel panel-default privacy1">
				<div class="panel-heading colorWhite content">
				{!! isset($content->content) ? $content->content : 'No Content Found..!' !!}
					
							{{--<h5>Privacy</h5>--}}
					{{--<p>--}}
						{{--Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.--}}
					{{--</p>--}}
					{{--<p>--}}
						{{--Why do we use it?--}}
						{{--It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).--}}
					{{--</p>--}}
					{{--<p>--}}
						{{--Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.--}}
					{{--</p>--}}
					{{--<p>--}}
						{{--Why do we use it?--}}
						{{--It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).--}}
					{{--</p>--}}
				</div>
			</div>
		</div>
		
		@include('client.categoriesAndTags')
	</div>
@endsection