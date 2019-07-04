<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="﻿{{ route('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('distributor.name') }}</cite></a><span lay-separator="">/</span>
            <a><cite>添加{{ trans('distributor.name') }}</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="fb-main-table">
                <form class="layui-form" action="{{guard_url('distributor/'.$distributor->id)}}" method="POST" lay-filter="fb-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('distributor.label.distributor_name') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="distributor_name" lay-verify="required" autocomplete="off" placeholder="请输入{{ trans('distributor.label.distributor_name') }}" class="layui-input" value="{{ $distributor['distributor_name'] }}" >
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('distributor.label.distributor_name') }}</label>
                        <div class="layui-input-block">
                            @foreach(app('city_repository')->getCities() as $key => $city)
                                <input type="checkbox" name="city_code[]" title="{{ $city['name'] }}" value="{{ $city['city_code'] }}" @if(in_array($city["city_code"],$distributor_city_codes)) checked @endif>
                            @endforeach
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                        </div>
                    </div>
                    {!!Form::token()!!}
                    <input type="hidden" name="_method" value="PUT">
                </form>
            </div>

        </div>
    </div>
</div>
