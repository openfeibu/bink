<?php $__currentLoopData = $shops_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="shopList-item">
        <a href="<?php echo e(url('/shop/'.$shop['id'])); ?>">
            <div class="img">
                <img src="<?php echo e(url('image/original/'.$shop['image'])); ?>" alt="">
            </div>
            <div class="test">
                <div class="name fb-overflow-1"><?php echo e($shop['shop_name']); ?></div>
                <div class="map  fb-overflow-2"><?php echo e($shop['address']); ?></div>
                <div class="date">营业时间：<?php echo e(date('H:i',strtotime($shop['opening_time']))); ?> - <?php echo e(date('H:i',strtotime($shop['closing_time']))); ?></div>
            </div>
        </a>
        <div class="mapNav">
            <div class="distance">20km</div>
            <div class="mapNav-icon"></div>
        </div>

    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>