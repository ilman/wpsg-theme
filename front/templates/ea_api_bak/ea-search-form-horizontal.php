<?php 
    use Scienceguard\SG_Util; 
    use Scienceguard\SG_Form;
?>

<form class="ea-search-form horizontal" action="<?php echo $action ?>">
	<?php 
		$parsed_action = parse_url($action);
		$action_query = SG_Util::val($parsed_action,'query');

		parse_str($action_query, $parsed_queries);

		$areas = array(
            'Caterham',
            'Coulsdon',
            'Crawley',
            'Croydon',
            // 'East Grinstead',
            // 'Epsom',
            // 'Haywards Heath',
            'Horley',
            // 'Kingston',
            'Redhill',
            'Sutton',
            'South Coast',
            'Central London',
            // 'Worthing',
            // 'Horsham',
            'Nationwide',
        );

		sort($areas);

        $values = $_GET;
        $attr = array(
            'class' => 'form-control'
        );
	?>
	<?php foreach($parsed_queries as $key=>$val): ?>
	    <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>">
	<?php endforeach; ?>

    <div class="row">
    
    <div class="col-sm-4">
            <?php 
                $options = array(
                    array('label'=>'For Sale', 'value'=>'for-sale'),
                    array('label'=>'To Rent', 'value'=>'to-rent')
                );
                $this_attr = array(
                    'class' => 'radio-inline'
                );
                echo SG_Form::field('radio','dep',$values,$this_attr,'for-sale',$options);
            ?>
    
    </div>
        <!-- col -->
         <div class="col-sm-8">
             <div class="form-group">
                <label>Area</label>
                <?php 
                    $options = array();
                    foreach($areas as $area){
                        $options[] = array('label'=>htmlspecialchars($area), 'value'=>SG_Util::slug($area));
                    }
                    $this_attr = array(
                        'class' => 'form-control input-select2',
                        'multiple' => 'multiple',
                        'placeholder' => 'Select Areas'
                    );
                    echo SG_Form::field('select2','areas[]',$values,$this_attr,'',$options);
                ?>
            </div>
        </div>
        <!-- col -->
    
</div>
    <!-- row -->

    <div class="row">    
        <div class="col-sm-4">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12">
                        <label>Bed Rooms</label>
                        <?php 
                            $options = array(
                                array('label'=>'-Select Minimum Bedrooms-', 'value'=>''),
                                array('label'=>'Studio', 'value'=>'0')
                            );
                            $temps = array('1','2','3','4','5','6');
                            foreach($temps as $temp){
                                $options[] = array('label'=>$temp, 'value'=>$temp);
                            }

                            echo SG_Form::field('select','bed',$values,$attr,'',$options);
                        ?>
                    </div>
                </div>
            </div>
            <!-- form-group -->
        </div>
        <!-- col -->
        <div class="col-sm-4">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                        <label>Min. Price</label>
                        <?php 
                            $price_array = ea_price_array(SG_Util::val($values,'dep','for-sale'));
                        ?>
                        <?php 
                            $options = array(
                                array('label'=>'-No Minimum-', 'value'=>'')
                            );
                            
                            foreach($price_array as $temp){
                                $options[] = array('label'=>'&pound;'.$temp, 'value'=>$temp);
                            }

                            echo SG_Form::field('select','min',$values,$attr,'',$options);
                        ?>
                    </div>
                    <div class="col-xs-6">
                        <label>Max. Price</label>
                        <?php 
                            $options = array(
                                array('label'=>'-No Maximum-', 'value'=>'')
                            );
                            
                            foreach($price_array as $temp){
                                $options[] = array('label'=>'&pound;'.$temp, 'value'=>$temp);
                            }

                            echo SG_Form::field('select','max',$values,$attr,'',$options);
                        ?>
                    </div>
                </div>
            </div>
            <!-- form-group -->    
        </div>
        <!-- col -->
        <div class="col-sm-4">
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary">Search</button>
            </div>
            <!-- form-group -->
        </div>
        <!-- col -->
    </div>
    <!-- row -->
</form>