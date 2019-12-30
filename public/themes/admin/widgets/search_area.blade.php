
    <div class="layui-input-inline">
        <select name="province_code" class="search_key" lay-filter="province" id="s_province" lay-verify="required"  lay-search>
            <option value="">{{ trans('app.select_province') }}</option>
            @foreach($provinces as $key => $province)
                <option value="{{ $province->code }}" @if(isset($province_code) && $province->code == $province_code) selected @endif>{{ $province->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="layui-input-inline">
        <select name="city_code" class="search_key"  lay-filter="city" id="s_city" lay-search>
            <option value="">{{ trans('app.select_city') }}</option>
        </select>
    </div>
    <div class="layui-input-inline">
        <select name="county_code" class="search_key"  lay-filter="county" id="s_county" lay-search>
            <option value="">{{ trans('app.select_county') }}</option>
        </select>
    </div>




@if(isset($province_code))
    <script type="text/javascript">

        layui.use(['form', 'layer', 'laytpl', 'jquery'], function () {
            var form = layui.form, $ = layui.jquery;

            form.on('select(province)', function (data) {

                if(data.id)
                {
                    var p = data.id;
                }else{
                    var p = $("#s_province").val();
                }

                if (p) {
                    layer.load();
                    $.get("{{ guard_url('area/list') }}?parent_code=" + p, function (result) {
                        layer.closeAll("loading");
                        var c = result.data;
                        $("#s_city").html("");
                        if(c.length > 0)
                        {
                            $("#s_city").append("<option value=''>{{ trans('app.select_city') }}</option>");
                            for (v in c) {
                                var cc = c[v].code;
                                if(cc == "{{$city_code}}")
                                {
                                    $("#s_city").append("<option value=" + cc + " selected>" + c[v].name + "</option>")
                                    layui.event.call(this,'form','select(city)',{id:"{{ $city_code }}"});
                                }else{
                                    $("#s_city").append("<option value=" + cc + ">" + c[v].name + "</option>")
                                }
                            }
                        }else{
                            $("#s_city").append("<option value=''>--------</option>");
                            $("#s_county").html("");
                            $("#s_county").append("<option value=''>--------</option>");
                        }
                        form.render();
                    })
                }
            });
            form.on('select(city)', function (data) {
                @if(isset($province_code))
                if(data.id)
                {
                    var p = data.id;
                }else{
                    var p = $("#s_city").val();
                }
                @endif
                if (p) {
                    layer.load();
                    $.get("{{ guard_url('area/list') }}?parent_code=" + p, function (result) {
                        layer.closeAll("loading");
                        var c = result.data;
                        $("#s_county").html("");
                        if(c.length > 0) {
                            $("#s_county").append("<option value=''>{{ trans('app.select_county') }}</option>");
                            for (v in c) {
                                var cc = c[v].code;
                                if(cc == "{{$county_code}}")
                                {
                                    $("#s_county").append("<option value=" + cc + " selected>" + c[v].name + "</option>")
                                }else{
                                    $("#s_county").append("<option value=" + cc + ">" + c[v].name + "</option>")
                                }
                            }
                        }else {
                            $("#s_county").append("<option value=''>--------</option>");
                        }
                        form.render();
                    })
                }
            });

            @if(isset($province_code))
            layui.event.call(this,'form','select(province)',{id:"{{ $province_code }}"});
            @endif

        });


    </script>
@else
    <script type="text/javascript">

        layui.use(['form', 'layer', 'laytpl', 'jquery'], function () {
            var form = layui.form, $ = layui.jquery;

            form.on('select(province)', function (data) {
                var p = $("#s_province").val();
                if (p) {
                    layer.load();
                    $.get("{{ guard_url('area/list') }}?parent_code=" + p, function (result) {
                        layer.closeAll("loading");
                        var c = result.data;
                        $("#s_city").html("");
                        if(c.length > 0)
                        {
                            $("#s_city").append("<option value=''>{{ trans('app.select_city') }}</option>");
                            for (v in c) {
                                var cc = c[v].code;
                                $("#s_city").append("<option value=" + cc + ">" + c[v].name + "</option>")
                            }
                        }else{
                            $("#s_city").append("<option value=''>--------</option>");
                            $("#s_county").html("");
                            $("#s_county").append("<option value=''>--------</option>");
                        }
                        form.render();
                    })
                }
            });
            form.on('select(city)', function (data) {
                var p = $("#s_city").val();
                if (p) {
                    layer.load();
                    $.get("{{ guard_url('area/list') }}?parent_code=" + p, function (result) {
                        layer.closeAll("loading");
                        var c = result.data;
                        $("#s_county").html("");
                        if(c.length > 0) {
                            $("#s_county").append("<option value=''>{{ trans('app.select_county') }}</option>");
                            for (v in c) {
                                var cc = c[v].code;
                                $("#s_county").append("<option value=" + cc + ">" + c[v].name + "</option>")
                            }
                        }else {
                            $("#s_county").append("<option value=''>--------</option>");
                        }
                        form.render();
                    })
                }
            });
        });


    </script>
@endif