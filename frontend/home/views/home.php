<?php echo Modules::run('slides'); ?>
<div class="row">
    <div class="col-md-8">
        <?php // echo Modules::run('home/blog/index'); ?>
        <?php echo Modules::run('posts'); ?>
    </div>
    <div class="col-md-4">
        <!-- Widget: user widget style 1 -->
        <?php echo Modules::run('posts/sidebar'); ?>
    </div>
    
</div>