<!DOCTYPE html>
<html lang="en" xml:lang="en" xmlns= "http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset() ?>
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>SJ Connect</title>
        <link href="/img/sj-connect-favicon.png" type="image/x-icon" rel="icon" />
        <?php
            // echo $this->Html->css('../js/js/tinymce/skins/ui/oxide/skin.min.css');
            // echo $this->Html->css('../js/js/tinymce/skins/ui/oxide/content.min.css');
            // echo $this->Html->css('../js/js/tinymce/skins/content/default/content.min.css');

            echo $this->Html->css('../dist/css/bootstrap.min.css');

            echo $this->Html->css('../dist/css/style');
            echo $this->Html->css('../dist/css/theme.css');
            echo $this->Html->css('../dist/css/blue.css');
            echo $this->Html->css('../dist/css/sweetalert.css');
            echo $this->Html->css('../dist/css/steps.css');
            echo $this->Html->css('../dist/css/bootstrap-datepicker.min');
            echo $this->Html->css('../dist/css/select2.min');
            echo $this->Html->css('../dist/css/switchery.min');
            //echo $this->Html->css('../css/style2');
            echo $this->Html->css('../css/chosen');
            echo $this->Html->css('../css/prism');
            echo $this->Html->css('../css/custom.css');
            $this->Html->css(
                'http://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css',
                array(
                    'inline' => false
                )
            );
        ?>
        <?php
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
        ?>
        <style>
            .mypagination .disabled {
                pointer-events:none; //This makes it not clickable
                opacity:0.6;         //This grays it out to look disabled
            }
            .mypagination .active {
                pointer-events: none;
            }
        </style>
    </head>

    <body class="fix-sidebar fix-header card-no-border">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div>
        <div id="main-wrapper">
            <?php echo $this->element('header'); ?>
            <?php echo $this->element('sidebar'); ?>
            <div class="page-wrapper">
                <div class="container-fluid">
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
            echo $this->Html->script('../dist/js/select2.min');
            echo $this->Html->script('../dist/js/sidebarmenu');
            echo $this->Html->script('../dist/js/sticky-kit.min');
            echo $this->Html->script('../dist/js/jquery.sparkline.min');
            echo $this->Html->script('../dist/js/custom.min');
            echo $this->Html->script('../dist/js/jQuery.style.switcher');
            echo $this->Html->script('../dist/js/prism');
            echo $this->Html->script('../dist/js/sweetalert.min');
            echo $this->Html->script('../dist/js/jquery.steps.min');
            echo $this->Html->script('../dist/js/jquery.validate.min');
            echo $this->Html->script('../dist/js/steps');
            echo $this->Html->script('../dist/js/bootstrap-datepicker.min');
            echo $this->Html->script('../dist/js/switchery.min');
            echo $this->Html->script('../dist/js/employee');
            echo $this->Html->script("../dist/js/tinymce.min.js");
            echo $this->Html->script("../dist/js/dashboard.js");
            echo $this->Html->script('../dist/js/jspdf.min.js');
            echo $this->Html->script('../dist/js/leaverequest.js');
            echo $this->Html->script('../dist/js/cancelleaverequest.js');
            echo $this->Html->script('../js/chosen.jquery.js');
            echo $this->Html->script('../js/init.js');
            echo $this->Html->script('../js/prism.js');
            echo $this->Html->script('../src/js/employeeAttendence.js');
            echo $this->Html->script('procressDocumentation.js');
            echo $this->Html->script('../select2/dist/js/select2.min.js');
            echo $this->Html->css('../select2/dist/css/select2.min.css');
            echo $this->Html->script('custom.js'); //added by sankalp
            echo $this->Html->script('hubstaffHours.js');
            echo $this->Html->script('skils.js');
            echo $this->Html->script('empSkills.js');
            echo $this->Html->script('forms.js');
        ?>
        <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    </body>
</html>
