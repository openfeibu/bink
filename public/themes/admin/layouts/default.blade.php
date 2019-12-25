<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta content="telephone=no" name="format-detection" />
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="renderer" content="webkit">
    <title>冰壳科技后台管理系统</title>
    {!! Theme::asset()->styles() !!}
    {{--<script src='{{ asset('js/jquery-1.7.2.min.js') }}'></script>--}}
    {!! Theme::asset()->scripts() !!}
    {!! Theme::asset()->container('footer')->scripts() !!}
</head>
<body>
    {!! Theme::partial('header') !!}
    {!! Theme::partial('aside') !!}
    {!! Theme::content() !!}
    {!! Theme::partial('footer') !!}
</body>
</html>
