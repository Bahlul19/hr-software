<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset() ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>SJ Connect</title>

<!--        --><?php //echo $this->Html->meta('icon') ?>
        <link
                href="/img/sj-connect-favicon.png"
                type="image/x-icon"
                rel="icon"
        />
        <?php
            echo $this->Html->css('../dist/css/bootstrap.min.css');
            echo $this->Html->css('../dist/css/theme.css');
            echo $this->Html->css('../dist/css/blue.css');
        ?>

        <?php
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
        ?>
    </head>

    <body class="fix-sidebar fix-header card-no-border">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div>

        <section id="wrapper" class="login-register login-sidebar" style="background-image:url(/img/SJI-world-map.png);;background-color:#171717;   ">
            <div class="login-box card">
                <div class="card-body">
                    <?php echo $this->Flash->render(); ?>

                    <?php echo $this->fetch('content') ?>

                    <?php //echo $this->element('timezone'); ?>


                </div>
            </div>
        </div>
        <?php
            echo $this->Html->script('../dist/js/jquery.min');
            echo $this->Html->script('../dist/js/bootstrap.min');
            echo $this->Html->script('../dist/js/jquery.slimscroll');
            echo $this->Html->script('../dist/js/waves');
            echo $this->Html->script('../dist/js/sidebarmenu');
            echo $this->Html->script('../dist/js/sticky-kit.min');
            echo $this->Html->script('../dist/js/jquery.sparkline.min');
            echo $this->Html->script('../dist/js/custom.min');
            echo $this->Html->script('../dist/js/jQuery.style.switcher');
            echo $this->Html->script('../dist/js/prism');



        ?>
    </body>
</html>
