<style>
    .property-images{ overflow-y:auto; max-height:600px; }
    .property-images .post-item{ height:100px; overflow:hidden; }
</style>

<div class="page-property-details">
    <div class="row">

        <div class="col-sm-6 pull-right">
            <h1 class="property-address">
                <?php echo SG_Util::val($result, 'type').' in '.SG_Util::val($result, 'country'); ?>
                <?php if(SG_Util::val($result, 'area')){ echo ', '.SG_Util::val($result, 'area'); } ?>
                <?php if(SG_Util::val($result, 'location')){ echo ', '.SG_Util::val($result, 'location'); } ?>
            </h1>

            <p class="property-meta">
                <span class="property-status bg-primary"><?php echo SG_Util::val($result, 'status') ?></span>   
                <span class="property-price">Price: <?php echo str_replace('Â','',SG_Util::val($result, 'price')).' '.SG_Util::val($result, 'cur') ?></span> 
                <span class="property-ref">Ref: <?php echo SG_Util::val($result, 'ref') ?></span>    
            </p>

            <p class="property-meta">
                <span class="property-meta-item">Beds: <?php echo SG_Util::val($result, 'beds') ?></span>
                <span class="property-meta-item">Baths: <?php echo SG_Util::val($result, 'baths') ?></span>
                <span class="property-meta-item">Build: <?php echo SG_Util::val($result, 'build').'M<sup>2</sup>' ?></span>
                <span class="property-meta-item">Terrace: <?php echo SG_Util::val($result, 'terrace'.'M<sup>2</sup>') ?></span>
            </p>
            
            <?php 
                $result_actions = SG_Util::val($result, 'actions');

                $result_action_map = SG_Util::val($result_actions, 'map');
                $result_action_floorplan = SG_Util::val($result_actions, 'floorplan');
                $result_action_brochure = SG_Util::val($result_actions, 'brochure');
                $result_action_epc = SG_Util::val($result_actions, 'epc');
                $result_action_reqview = SG_Util::val($result_actions, 'reqview');
            ?>
            <ul class="property-action row no-padding" style="list-style:none;">
                <?php if($result_action_map): ?>
                    <li class="col-xs-6">
                        <a href="<?php echo $result_action_map ?>"><i class="fa fa-fw fa-location-arrow"></i> View Map</a>
                    </li>
                <?php endif; ?>

                <?php if($result_action_brochure): ?>
                    <li class="col-xs-6">
                        <a href="<?php echo $result_action_brochure ?>"><i class="fa fa-fw fa-file"></i> Get PDF Details</a>
                    </li>
                <?php endif; ?>

                <?php if($result_action_floorplan): ?>
                    <li class="col-xs-6">
                        <a href="<?php echo $result_action_floorplan ?>"><i class="fa fa-fw fa-building"></i> Floor Plans</a>
                    </li>
                <?php endif; ?>

                <?php if($result_action_epc): ?>
                    <li class="col-xs-6">
                        <a href="<?php echo $result_action_epc ?>"><i class="fa fa-fw fa-bar-chart-o"></i> EPC Graphs</a>
                    </li>
                <?php endif; ?>

                <?php if($result_action_reqview): ?>
                    <li class="col-xs-6">
                        <a href="<?php echo $result_action_reqview ?>"><i class="fa fa-fw fa-search"></i> Request Viewing</a>
                    </li>
                <?php endif; ?>
            </ul>

            <h5 class="choices-branch">
                <?php echo SG_Util::val($result, 'branch') ?>
            </h5>

            <div class="property-desc">
                <?php 
                    $prop_desc = SG_Util::val($result, 'desc');
                    echo preg_replace('/[Â]/i', '', $prop_desc);
                ?>
            </div>
            <div class="property-desc">
                <?php echo SG_Util::val($result, 'roomdet') ?>
            </div>
        </div>
        <!-- col -->

        <div class="col-sm-6 pull-left">
            <div class="magnific-gallery">
                <div id="property-image-main">
                    <div class="anim-ch ch-slide-in-bottom">
                        <div class="hover-thumb">
                            <img class="hover-image" src="<?php echo $result->images[0] ?>" alt="image">
                        </div>
                        <div class="hover-body">
                            <div class="abs-center">
                                <div class="inner">
                                    <a class="btn btn-circle btn-lg bg-white border-white text-primary hover-trans hover-outline-outward magnific-item" href="<?php echo $result->images[0] ?>"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <ul class="property-images row post-list list-column">
                    <?php $i=0; foreach($result->images as $image): $i++; ?>
                        <?php if($i<=1){ continue; } ?>
                        <li class="col-xs-6 post-item">
                            <div class="anim-ch ch-slide-in-bottom">
                                <div class="hover-thumb">
                                    <img class="hover-image" src="<?php echo $image ?>" alt="image">
                                </div>
                                <div class="hover-body">
                                    <div class="abs-center">
                                        <div class="inner">
                                            <a class="btn btn-circle btn-lg bg-white border-white text-primary hover-trans hover-outline-outward magnific-item" href="<?php echo $image ?>"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>            
                </ul>
            </div>
        
        </div>
        <!-- col -->
    </div>
    <!-- row -->
</div>


<!-- <?php echo htmlspecialchars($url) ?> -->