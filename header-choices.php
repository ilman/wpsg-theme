<nav class="navbar navbar-blank navbar-static-top" role="navigation">
    <div class="container">
        <div class="row">
        
			<div class="col-sm-2">
                <div class="navbar-header">
                    <button class="navbar-toggle btn btn-primary" type="button" data-toggle="collapse" data-target="#nav-main"> <i class="fa fa-fw fa-bars"></i> </button>
                    <a class="navbar-brand" href="<?php echo home_url(); ?>">
                        <img class="brand-default" src="<?php echo sg_opt('logo') ?>" alt="logo">
                    </a>
                </div>
        
            </div>
            <!-- col -->
            <div class="col-sm-10">
                 <?php /*if(is_user_logged_in()): ?>
                <div class="clearfix hidden-xs" id="nav-top-link">
                    <ul class="nav navbar-nav navbar-right" style="height:38px;">
                       
                            <?php $current_user = wp_get_current_user(); ?>
                            <li><a>Hi, <?php echo $current_user->display_name ?></a></li>
                            <li><a href="<?php echo wp_logout_url(); ?>"><span><i class="fa fa-sign-out"></i> Logout</span></a></li>
                        <?php else: ?>
                            <li><a href="<?php echo wp_login_url(); ?>"><span><i class="fa fa-sign-in"></i> Choices Login</span></a></li>
                        <?php endif; */?>
                        <?php /* ?>
                        <li><a href="http://choices.co.uk/clients/index.php/client_center/direct_payment"><i class="fa fa-home"></i> Pay Your Rent Online</a></li>
                        
                    </ul>
                </div>
                <?php */ ?>
                <div class="collapse navbar-collapse" id="nav-main">
                    <?php 
                    	wp_nav_menu( 
                    		array( 
                    			'theme_location' => 'primary', 
                    			'container' => false,
                    			'menu_class' => 'nav navbar-nav navbar-right',
                    			'walker' => new sg_walker_menu(),
                                'fallback_cb'  => 'sg_no_menu_cb'
                    		) 
                    	);
                    ?>
                </div>
            </div>
            <!-- col -->
        
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</nav>
<!-- nav -->