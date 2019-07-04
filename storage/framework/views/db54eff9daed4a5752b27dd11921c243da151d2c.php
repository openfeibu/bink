<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="﻿<?php echo e(route('home')); ?>">主页</a><span lay-separator="">/</span>
            <a><cite><?php echo e(trans('distributor.name')); ?></cite></a><span lay-separator="">/</span>
            <a><cite>添加<?php echo e(trans('distributor.name')); ?></cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            <?php echo Theme::partial('message'); ?>

            <div class="fb-main-table">
                <form class="layui-form" action="<?php echo e(guard_url('distributor')); ?>" method="POST" lay-filter="fb-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?php echo e(trans('distributor.label.distributor_name')); ?></label>
                        <div class="layui-input-inline">
                            <input type="text" name="distributor_name" lay-verify="required" autocomplete="off" placeholder="请输入<?php echo e(trans('distributor.label.distributor_name')); ?>" class="layui-input" >
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?php echo e(trans('distributor.label.distributor_name')); ?></label>
                        <div class="layui-input-block">
                            <?php $__currentLoopData = app('city_repository')->getCities(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="checkbox" name="city_code[]" title="<?php echo e($city['name']); ?>" value="<?php echo e($city['city_code']); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                        </div>
                    </div>
                    <?php echo Form::token(); ?>

                </form>
            </div>

        </div>
    </div>
</div>
