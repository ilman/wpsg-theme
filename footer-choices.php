<div class="container">
    <div class="navbar-left">
        &copy; 2015 Choices Estate Agents Ltd | <a href="<?php echo site_url('privacy-policy') ?>">Privacy Policy</a>
    </div>
    <!-- navbar-left -->
    <div class="navbar-left" id="nav-social-links">
        <?php 
            $social_links = array();
            if(sg_opt('facebook_url')){
                $social_links['facebook'] = array(
                    'url'=>sg_opt('facebook_url'),
                    'icon'=>'icon-facebook',
                );
            }

            if(sg_opt('twitter_url')){
                $social_links['twitter'] = array(
                    'url'=>sg_opt('twitter_url'),
                    'icon'=>'icon-twitter',
                );
            }

            if(sg_opt('youtube_url')){
                $social_links['youtube'] = array(
                    'url'=>sg_opt('youtube_url'),
                    'icon'=>'icon-youtube',
                );
            }

            if(sg_opt('linkedin_url')){
                $social_links['linkedin'] = array(
                    'url'=>sg_opt('linkedin_url'),
                    'icon'=>'icon-linkedin',
                );
            }

            foreach($social_links as $link){
                echo '<a href="'.$link['url'].'"><i class="icon-socials '.$link['icon'].'"></i></a>';
            }
        ?>
    </div>
    <!-- navbar-collapse -->
</div>
<!-- container -->