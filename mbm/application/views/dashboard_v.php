<!-- BEGIN PAGE BREADCRUMB -->

<!-- END PAGE BREADCRUMB -->
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- KONTEN DI SINI YA -->
       <!--<img id="id_imgCR" src="<?php /* //echo base_url('metronic/img/rusun05.jpg'); */ ?>" alt=""/>-->
        <h3 class="font-grey-cascade">Dashboard <small>Operasional Laundry</small></h3>
    </div>

</div>
<!-- BEGIN ROW -->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN DASHBOARD STATS 1-->
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="<?php echo $cm_hr_ini; ?>"><?php echo $cm_hr_ini; ?></span>
                        </div>
                        <div class="desc"> Cucian Masuk Hari Ini </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="<?php echo $ca_hr_ini; ?>"><?php echo $ca_hr_ini; ?></span> </div>
                        <div class="desc"> Cucian Diambil Hari Ini </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="<?php echo $cs_hr_ini; ?>"><?php echo $cs_hr_ini; ?></span>
                        </div>
                        <div class="desc"> Cucian Selesai hari Ini </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 yellow" href="#">
                    <div class="visual">
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="details">
                        <div class="number"> 
                            <span data-counter="counterup" data-value="<?php echo $chs_hr_ini; ?>"><?php echo $chs_hr_ini; ?></span> </div>
                        <div class="desc"> Cucian harus selesai hari ini </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 yellow-crusta" href="#">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="<?php echo $um_hr_ini; ?>"><?php echo $um_hr_ini; ?></span>
                        </div>
                        <div class="desc"> Uang Masuk Hari Ini </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green-jungle" href="#">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="<?php echo $ca_hr_ini; ?>"><?php echo $ca_hr_ini; ?></span> </div>
                        <div class="desc"> Uang Keluar </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="<?php echo $cs_hr_ini; ?>"><?php echo $cs_hr_ini; ?></span>
                        </div>
                        <div class="desc"> Cucian Selesai hari Ini </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 yellow" href="#">
                    <div class="visual">
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="details">
                        <div class="number"> 
                            <span data-counter="counterup" data-value="<?php echo $chs_hr_ini; ?>"><?php echo $chs_hr_ini; ?></span> </div>
                        <div class="desc"> Cucian harus selesai hari ini </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- END DASHBOARD STATS 1-->


    </div>
</div>
<!-- END ROW -->

<!-- END PAGE CONTENT-->

<!--[if lt IE 9]>
<script src="<?php echo base_url('metronic/global/plugins/respond.min.js'); ?>"></script>
<script src="<?php echo base_url('metronic/global/plugins/excanvas.min.js'); ?>"></script> 
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo base_url('metronic/global/plugins/jquery.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('metronic/global/plugins/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('metronic/global/plugins/js.cookie.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('metronic/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('metronic/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('metronic/global/plugins/jquery.blockui.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('metronic/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js'); ?>" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo base_url('metronic/global/scripts/app.min.js'); ?>" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?php echo base_url('metronic/layouts/layout4/scripts/layout.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('metronic/layouts/layout4/scripts/demo.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('metronic/layouts/global/scripts/quick-sidebar.min.js'); ?>" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->