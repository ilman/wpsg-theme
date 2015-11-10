<form class="ea-search-form resales-search-form" action="<?php echo $action ?>">
	<?php 
		$parsed_action = parse_url($action);
		$action_query = SG_Util::val($parsed_action,'query');

		parse_str($action_query, $parsed_queries);

        $values = $_GET;
        $attr = array(
            'class' => 'form-control'
        );
	?>
	<?php foreach($parsed_queries as $key=>$val): ?>
	    <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>">
	<?php endforeach; ?>
    <p>
        <?php 
            $options = array(
                array('label'=>'For Sale', 'value'=>'for-sale'),
                array('label'=>'To Rent', 'value'=>'to-rent'),
                array('label'=>'Featured', 'value'=>'featured')
            );
            $this_attr = array(
                'class' => 'radio-inline'
            );
            echo SG_Form::field('radio','dep',$values,$this_attr,'for-sale',$options);
        ?>
    </p>

    <div class="form-group">
        <label>Type</label>
        <?php 
            $options = array(
                array('label'=>'- Select Property Type -', 'value'=>''),
            );
            foreach($data_property_types as $p_type){
                $options[] = (array) $p_type;
                foreach($p_type->sub_types as $sub){
                    $options[] = array('label'=>' -- '.$p_type->label.' - '.$sub['label'], 'value'=>$sub['value']);
                }
            }
            $this_attr = array(
                'class' => 'form-control',
                'placeholder' => 'Select Type'
            );
            echo SG_Form::field('select','ptype',$values,$this_attr,'',$options);
        ?>
    </div>
    <!-- form-group -->

    <div class="form-group">
    	<label>Area</label>
        <?php 
             $options = array(
                array('label'=>'- Select Property Location -', 'value'=>''),
            );
            foreach($data_property_locations as $p_loc){
                $options[] = array('label'=>htmlspecialchars($p_loc), 'value'=>htmlspecialchars($p_loc));
            }
            $this_attr = array(
                'class' => 'form-control',
                'placeholder' => 'Select Locations'
            );
            echo SG_Form::field('select2','location',$values,$this_attr,'',$options);
        ?>
    </div>
    <!-- form-group -->

    <div class="form-group">
        <div class="row">
            <div class="col-xs-12">
            	<label>Minimum Bed Rooms</label>
                <?php 
                    $options = array(
                        array('label'=>'-Select Minimum Bedrooms-', 'value'=>''),
                        array('label'=>'Studio', 'value'=>'0')
                    );
                    $temps = array('1','2','3','4','5','6','7','8','9','9+');
                    foreach($temps as $temp){
                        $options[] = array('label'=>$temp, 'value'=>$temp);
                    }

                    echo SG_Form::field('select','bed',$values,$attr,'',$options);
                ?>
            </div>
        </div>
    </div>
    <!-- form-group -->

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
                        $options[] = array('label'=>'&euro;'.$temp, 'value'=>$temp);
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
                        $options[] = array('label'=>'&euro;'.$temp, 'value'=>$temp);
                    }

                    echo SG_Form::field('select','max',$values,$attr,'',$options);
                ?>
            </div>
        </div>
    </div>
    <!-- form-group -->

    <div class="form-group">
        <button type="submit" class="btn btn-block btn-primary">Search</button>
    </div>
    <!-- form-group -->
</form>