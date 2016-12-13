<?php 
    use Scienceguard\SG_Util; 
    use Scienceguard\SG_Form;
?>

<form class="ea-search-form" action="<?php echo $action ?>">
	<?php 
		$parsed_action = parse_url($action);
		$action_query = SG_Util::val($parsed_action,'query');

		parse_str($action_query, $parsed_queries);

		$areas = array(
			'London North' => 'london-north',
            'London South' => 'london-south',
            'Surrey and Sussex' => 'surrey-sussex',
            'Essex and Kent' => 'essex-kent',
            'East Midlands' => 'east-midlands',
            'West Midlands' => 'west-midlands',
            'Central Southern England' => 'central-southern-england',
            'South West Counties' => 'south-west-counties',
            'North of England' => 'north-england',
		);

		asort($areas);

        $values = $_GET;
        $attr = array(
            'class' => 'form-control'
        );
	?>

    <input type="hidden" name="dep" value="for-investment">

	<?php foreach($parsed_queries as $key=>$val): ?>
	    <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>">
	<?php endforeach; ?>
   
    <div class="form-group">
    	<label>Area</label>
        <?php 
            $options = array();
            $options[] = array('label'=>'Select Area', 'value'=>'');
            foreach($areas as $area=>$val){
                $options[] = array('label'=>htmlspecialchars($area), 'value'=>SG_Util::slug($val));
            }
            $this_attr = array(
                'class' => 'form-control input-select2',
                'multiple' => 'multiple',
                'placeholder' => 'Select Areas'
            );
            echo SG_Form::field('select2','areas[]',$values,$this_attr,'',$options);
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

    <div class="form-group">
        <div class="row">
            <div class="col-xs-6">
            	<label>Min. Price</label>
                <?php 
                    $price_array = ea_price_array('for-sale');
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

    <div class="form-group">
        <button type="submit" class="btn btn-block btn-primary">Search</button>
    </div>
    <!-- form-group -->
</form>