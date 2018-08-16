
<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
<div id="container">
    <header class="header">
        <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </header>

   <div class="main">
    <!-- sidebar content -->
        <div class="sidebar">
            <?php echo $__env->make('includes.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>

        <!-- main content -->
        <div class="content">
            <?php echo $__env->make('includes.content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>

    </div>

    <footer class="footer">
        <?php echo $__env->make('includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </footer>

</div>
</body>
</html>

