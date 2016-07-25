<div class="page-property-details">
    <div class="row">

    <style>
        .property-desc{ margin-bottom:20px; }
        .property-desc .rooms{ padding-left:1.5em; }
        .property-desc .room h6{ margin:0; }
    </style>
    
    <div class="col-sm-6">
            <div class="magnific-gallery">
                <div id="property-image-main">
                    <div class="anim-ch ch-slide-in-bottom">
                        <div class="hover-thumb">
                            <img class="hover-image" src="<?php echo $row->advert_image ?>" alt="image">
                        </div>
                        <div class="hover-body">
                            <div class="abs-center">
                                <div class="inner">
                                    <a class="btn btn-circle btn-lg bg-white border-white text-primary hover-trans hover-outline-outward magnific-item" href="<?php echo $row->advert_image ?>"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="property-images row post-list list-column">
                    <?php 
                        $row_images = json_decode($row->pictures);
                    ?>
                    <?php $i=0; foreach($row_images as $image): $i++; ?>
                        <?php if($i<=1){ continue; } ?>
                        <li class="col-xs-6 post-item">
                            <div class="anim-ch ch-slide-in-bottom">
                                <div class="hover-thumb">
                                    <img class="hover-image" src="<?php echo $image->file_name ?>" alt="<?php echo $image->name ?>">
                                </div>
                                <div class="hover-body">
                                    <div class="abs-center">
                                        <div class="inner">
                                            <a class="btn btn-circle btn-lg bg-white border-white text-primary hover-trans hover-outline-outward magnific-item" href="<?php echo $image->file_name ?>"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>            
                </ul>
            </div>
    
    </div>
        <div class="col-sm-6">
            <h1 class="property-address"><?php echo SG_Util::val($row, 'advert_heading') ?></h1>

            <p class="property-meta">
                <span class="property-status bg-primary"><?php echo SG_Util::val($row, 'priority') ?></span>   
                <span class="property-price">Price: <?php echo str_replace('Â','',SG_Util::val($row, 'price_text')) ?></span> 
                <span class="property-ref">Ref: <?php echo SG_Util::val($row, 'reference') ?></span>    
                <span class="property-type">Property Type: <?php echo SG_Util::val($row, 'property_type') ?></span>    
            </p>
            
            <?php 
                $row_actions = SG_Util::val($row, 'actions');

                $aid_pid = substr($row->web_link, (strrpos($row->web_link, '?') ?: -1) +1);

                $row_action_map = 'http://maps.google.co.uk/maps?q='.$row->post_code.'&spn='.$row->latitude.','.$row->longitude.'&hl=en';
                $row_action_brochure = SG_Util::val($row, 'brochure');
                $row_action_epc = SG_Util::val($row, 'epc');
                $row_action_floorplan = SG_Util::val($row, 'floor_plans');
                $row_action_reqview = SG_Util::val($row_actions, 'reqview');
            ?>
            <ul class="property-action row no-padding" style="list-style:none;">
                <?php if($row_action_map): ?>
                    <li class="col-xs-6">
                        <a href="<?php echo "javascript:void(window.open('".$row_action_map."'))" ?>"><i class="fa fa-fw fa-location-arrow"></i> View Map</a>
                    </li>
                <?php endif; ?>

                <?php if($row_action_brochure): ?>
                    <li class="col-xs-6">
                        <a href="<?php echo "javascript:void(window.open('".$row_action_brochure."'))" ?>"><i class="fa fa-fw fa-file"></i> Get PDF Details</a>
                    </li>
                <?php endif; ?>

                <?php if($row_action_floorplan): ?>
                    <li class="col-xs-6">
                        <a href="<?php echo "javascript:void(window.open('http://powering2.expertagent.co.uk/propertyFloorplan.aspx?".$aid_pid."','_blank','width=600,height=650,left=20,top=20,resizable=yes,status=no,scrollbars=no'))" ?>"><i class="fa fa-fw fa-building"></i> Floor Plans</a>
                    </li>
                <?php endif; ?>

                <?php if($row_action_epc): ?>
                    <li class="col-xs-6">
                        <a href="<?php echo "javascript:void(window.open('".$row_action_epc."','_blank','width=750,height=350,left=20,top=20,resizable=yes,status=no,scrollbars=no'))" ?>"><i class="fa fa-fw fa-bar-chart-o"></i> EPC Graphs</a>
                    </li>
                <?php endif; ?>

                <?php if($row_action_reqview): ?>
                    <li class="col-xs-6">
                        <a href="<?php echo $row_action_reqview ?>"><i class="fa fa-fw fa-search"></i> Request Viewing</a>
                    </li>
                <?php endif; ?>
            </ul>

            <h5 class="choices-branch">
                <?php echo SG_Util::val($row, 'branch') ?>
            </h5>

            <div class="property-desc">
                <?php 
                    $prop_desc = SG_Util::val($row, 'advert');
                    echo preg_replace('/[Â]/i', '', $prop_desc);
                ?>
            </div>

            <?php 
                $row_rooms = json_decode($row->rooms);
                if($row_rooms):
            ?>
                <div class="property-desc">
                    <h4>Rooms</h4>
                    <?php 
                        echo '<ul class="rooms">';
                        foreach($row_rooms as $room){
                            if(!$room->measurement_text && !$room->description){
                                echo '<li class="alert alert-info">'.$room->name.'</li>';
                            }
                            else{
                                echo '<li class="room">';
                                echo '<h6>'.$room->name.' <em>'.$room->measurement_text.'</em></h6>';
                                echo '<p>'.$room->description.'</p>';
                                echo '</li>';
                            }
                        }
                        echo '</ul>';
                    ?>
                </div>
            <?php endif; ?>
        </div>
    
</div>
</div>


<!-- <?php echo htmlspecialchars($url) ?> -->