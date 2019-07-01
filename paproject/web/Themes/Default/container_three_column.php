<!-- Site wrapper -->
<div class="wrapper">
    <?php echo $top_navigation_bar; ?>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <?php echo $left_sitebar; ?>
            <?php
            if (isset($array_leftmenu_modules) and (count($array_leftmenu_modules) > 0)) {
                foreach ($array_leftmenu_modules as $leftmenu_module) {
                    echo $leftmenu_module;
                }
            }
            ?>            
        </section>
        <!-- /.sidebar -->
    </aside>
    <!-- =============================================== -->    

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?php echo $header; ?>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if (!empty($array_toprow_modules)) {
                        foreach ($array_toprow_modules as $toprow_module) {
                            echo $toprow_module;
                        }
                        echo '<br/>';
                    }
                    ?>            
                </div>
            </div>     

            <div class="row">
                <div class="col-md-3">
                    <?php
                    if (isset($array_left_modules) and (count($array_left_modules) > 0)) {
                        foreach ($array_left_modules as $left_module) {
                            echo $left_module;
                        }
                    }
                    ?> 
                </div>
                <!-- /.col -->                
                <div class="col-md-6">
                    <?php
                    if (isset($array_middle_modules) and (count($array_middle_modules) > 0)) {
                        foreach ($array_middle_modules as $middle_module) {
                            echo $middle_module;
                        }
                    }
                    ?>
                </div>
                <!-- /.col -->
                <div class="col-md-3">
                    <?php
                    if (isset($array_right_modules) and (count($array_right_modules) > 0)) {
                        foreach ($array_right_modules as $right_module) {
                            echo $right_module;
                        }
                    }
                    ?> 
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->                   
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if (!empty($array_footerrow_modules)) {
                        foreach ($array_footerrow_modules as $footerrow_module) {
                            echo $footerrow_module;
                        }
                        echo '<br/>';
                    }
                    ?>            
                </div>
            </div>  
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php echo $footer; ?> 
    <?php echo $footer_sitebar; ?> 
</div>
<!-- ./wrapper -->
<?php echo $footer_script; ?> 
</body>
</html>