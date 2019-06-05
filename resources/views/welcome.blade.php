<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Simon Kibaru">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Authentication jwt/Auth</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    {{--<link href="http://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet" type="text/css">--}}
    <link href="vendor/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>


    <!-- PAGE LEVEL PLUGIN STYLES -->
    <link href="css/animate.css" rel="stylesheet">
    <link href="vendor/swiper/css/swiper.min.css" rel="stylesheet" type="text/css"/>

    <!-- THEME STYLES -->
    {{--<link href="css/layout.min.css" rel="stylesheet" type="text/css"/>--}}

</head>
<body>
<div id="app">

</div>
<script src="{{ route('dataset') }}"></script>

<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>




<script src="vendor/jquery.min.js" type="text/javascript"></script>
<script src="vendor/jquery-migrate.min.js" type="text/javascript"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

{{--<!-- PAGE LEVEL PLUGINS -->--}}
{{--<script src="vendor/jquery.easing.js" type="text/javascript"></script>--}}
{{--<script src="vendor/jquery.back-to-top.js" type="text/javascript"></script>--}}
{{--<script src="vendor/jquery.smooth-scroll.js" type="text/javascript"></script>--}}
{{--<script src="vendor/jquery.wow.min.js" type="text/javascript"></script>--}}
{{--<script src="vendor/swiper/js/swiper.jquery.min.js" type="text/javascript"></script>--}}
{{--<script src="vendor/masonry/jquery.masonry.pkgd.min.js" type="text/javascript"></script>--}}
{{--<script src="vendor/masonry/imagesloaded.pkgd.min.js" type="text/javascript"></script>--}}

{{--<!-- PAGE LEVEL SCRIPTS -->--}}
{{--<script src="js/layout.min.js" type="text/javascript"></script>--}}
{{--<script src="js/components/wow.min.js" type="text/javascript"></script>--}}
{{--<script src="js/components/swiper.min.js" type="text/javascript"></script>--}}
{{--<script src="js/components/masonry.min.js" type="text/javascript"></script>--}}


</body>
</html>
