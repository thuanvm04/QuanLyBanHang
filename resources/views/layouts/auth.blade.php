<!doctype html>
<html class="no-js" lang="">


<!-- Mirrored from affixtheme.com/html/xmee/demo/login-9.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Jul 2024 15:02:46 GMT -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>@yield('title')</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Favicon -->
	<link rel="shortcut icon" type="{{ asset ('assets/auth/image/x-icon')}}" href="img/favicon.png">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset ('assets/auth/css/bootstrap.min.css')}}">
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset ('assets/auth/css/fontawesome-all.min.css')}}">
	<!-- Flaticon CSS -->
	<link rel="stylesheet" href="{{ asset ('assets/auth/font/flaticon.css')}}">
	<!-- Google Web Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="{{ asset ('assets/auth/css/style.css')}}">
</head>

<body>

    <div id="preloader" class="preloader">
        <div class='inner'>
            <div class='line1'></div>
            <div class='line2'></div>
            <div class='line3'></div>
        </div>
    </div>
	<section class="fxt-template-animation fxt-template-layout9" data-bg-image="{{ asset ('assets/auth/img/figure/bg9-l.jpg')}}">
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-lg-3">
					<div class="fxt-header">
						<a href="{{ asset ('assets/auth/login-9.html')}}" class="fxt-logo"><img src="{{ asset ('assets/auth/img/logo-9.png')}}" alt="Logo"></a>
					</div>
				</div>
				@yield('content')
			</div>
		</div>
	</section>
	<!-- jquery-->
	<script src="{{ asset ('assets/auth/js/jquery.min.js')}}"></script>
	<!-- Bootstrap js -->
	<script src="{{ asset ('assets/auth/js/bootstrap.min.js')}}"></script>
	<!-- Imagesloaded js -->
	<script src="{{ asset ('assets/auth/js/imagesloaded.pkgd.min.js')}}"></script>
	<!-- Validator js -->
	<script src="{{ asset ('assets/auth/js/validator.min.js')}}"></script>
	<!-- Custom Js -->
	<script src="{{ asset ('assets/auth/js/main.js')}}"></script>

</body>


<!-- Mirrored from affixtheme.com/html/xmee/demo/login-9.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Jul 2024 15:02:47 GMT -->
</html>