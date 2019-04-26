<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>{{ config('app.name', 'Laravel') }}</title>
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<!-- CSRF Token -->

		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>

        <script>

		    window.default_locale = "{{ config('app.locale') }}";
		    window.fallback_locale = "{{ config('app.fallback_locale') }}";
		    window.messages = @json($messages);

		</script>

        <!-- Scripts -->
	    <script src="{{ mix('js/app.js') }}" defer></script>

		<!--end::Web font -->

		<!--begin::Global Theme Styles -->
		<link href="/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />

		<link href="/assets/demo/demo12/base/style.bundle.css" rel="stylesheet" type="text/css" />

		<!--end::Global Theme Styles -->

		<!--begin::Page Vendors Styles -->
		<link href="/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />

		<!--end::Page Vendors Styles -->
		<link rel="shortcut icon" href="/assets/demo/demo12/media/img/logo/favicon.ico" />

		@yield ('styles')
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
		<div id="app">
			<!-- begin:: Page -->
			<div class="m-grid m-grid--hor m-grid--root m-page">

				@include ('layouts.admin._header')

				<!-- begin::Body -->
				<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

					<!-- BEGIN: Left Aside -->
					<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
					<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

						@include ('layouts.admin._aside_menu')
					</div>

					<!-- END: Left Aside -->

					<div class="m-grid__item m-grid__item--fluid m-wrapper">
						@yield ('content')
					</div>
				</div>

				<!-- end:: Body -->

				@include ('layouts.admin._footer')
			</div>

			<!-- end:: Page -->

			{{-- @include ('layouts.admin._quick_sidebar') --}}

			<!-- begin::Scroll Top -->
			<div id="m_scroll_top" class="m-scroll-top">
				<i class="la la-arrow-up"></i>
			</div>

		<!-- end::Scroll Top -->

		</div>

		{{-- @include ('layouts.admin._quick_nav') --}}

		<!--begin::Global Theme Bundle -->
		<script src="/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="/assets/demo/demo12/base/scripts.bundle.js" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts -->

		@yield('scripts')

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>