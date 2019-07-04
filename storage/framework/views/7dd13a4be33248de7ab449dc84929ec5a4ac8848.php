<?php echo Theme::partial('header'); ?>


<div class="main pb pt">
    <div class="home-btn">
        <div class="home-btn-item shopIcon">
            <a href="<?php echo e(setting('apply_shop_url')); ?>">
                <p>已在销售bink？<br>立即登记门店信息</p>
                <div class="btn">登记门店信息</div>
            </a>
        </div>
        <div class="home-btn-item applyIcon">
            <a href="<?php echo e(setting('apply_distributor_url')); ?>">
                <p>想要销售bink？<br>申请成为本地代理</p>
                <div class="btn">申请本地代理</div>
            </a>
        </div>
    </div>

</div>

<?php echo $__env->make('city', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
