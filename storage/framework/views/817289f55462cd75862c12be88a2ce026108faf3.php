<div class="layui-input-block">
    <div class="layui-upload">
        <button type="button" class="layui-btn" id="uploadImage_<?php echo $field; ?>">多图片上传</button>
        <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;width: 88%">
            预览图：
            <div class="layui-upload-list uploader-list" style="overflow: auto;" id="uploader-list-<?php echo $field; ?>">
                <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div id="" class="file-iteme">
                        <div class="handle"><i class="layui-icon layui-icon-delete delete" style="font-size: 30px; color: #fff;"></i>  </div>
                        <img src="<?php echo url("/image/original".$file['path']); ?>">
                        <input type="hidden" name="<?php echo $field; ?>[]" id="path_<?php echo $field; ?>" value="<?php echo e($file['path']); ?>"/>
                     </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </blockquote>
    </div>
</div>

<script>
    layui.use(['jquery','element','form','table','upload'], function(){
        var $ = layui.$;
        var form = layui.form;
        var upload = layui.upload;
        upload.render({
            elem: '#uploadImage_<?php echo $field; ?>'
            ,accept:'images'
            ,url: '<?php echo $url; ?>'
            ,multiple:true
            ,data: {
                '_token':$('meta[name="csrf-token"]').attr('content')
            }
            ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                layer.load(); //上传loading
            }
            ,done: function(res, index, upload){
                //<i class="layui-icon layui-icon-left left" style="font-size: 30px; color: #fff;"></i><i class="layui-icon layui-icon-right right" style="font-size: 30px; color: #fff;"></i>
                $('#uploader-list-<?php echo $field; ?>').append(
                    '<div id="" class="file-iteme">' +
                    '<div class="handle"><i class="layui-icon layui-icon-delete delete" style="font-size: 30px; color: #fff;"></i>  </div>' +
                    '<img src='+ res.data.url +'>' +
                    '<input type="hidden" name="<?php echo $field; ?>[]" id="path_<?php echo $field; ?>" value="'+ res.data.path +'"/>' +
                    '</div>'
                );
                layer.closeAll('loading'); //关闭loading
                layer.msg(res.msg);

            }
            ,error: function(index, upload){
                layer.closeAll('loading'); //关闭loading
            }
        });
        $(document).on("mouseenter mouseleave", ".file-iteme", function(event){
            if(event.type === "mouseenter"){
                $(this).children(".info").fadeIn("fast");
                $(this).children(".handle").fadeIn("fast");
            }else if(event.type === "mouseleave") {
                $(this).children(".info").hide();
                $(this).children(".handle").hide();
            }
        });
        
            
            
            
        
        
            
        
        $(document).on("click", ".file-iteme .delete", function(event){
            $(this).parents(".file-iteme").remove();
        });

    });
</script>