<?php 
    use Scienceguard\SG_Util; 
    use Scienceguard\SG_Form;
?>

<form class="ea-search-bar" id="ea-search-bar" action="<?php echo $action ?>">
	<?php 
		$parsed_action = parse_url($action);
		$action_query = SG_Util::val($parsed_action,'query');

		parse_str($action_query, $parsed_queries);

        $areas = clean_ea_branch_list();

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
    
         <div class="col-xs-8">
            <div class="form-group">
                <?php 
                    $options = array();
                    $options[] = array('label'=>'Select Area', 'value'=>'');
                    foreach($areas as $area){
                        $options[] = array('label'=>htmlspecialchars($area), 'value'=>$area);
                    }
                    $this_attr = array(
                        'class' => 'form-control input-select2 input-block',
                        'multiple' => 'multiple',
                        'placeholder' => 'Select Areas'
                    );
                    echo SG_Form::field('select2','xbranches[]',$values,$this_attr,'',$options);
                ?>
            </div>
        </div>
        <!-- col -->

        <div class="col-xs-2">
            <div class="form-group">
                <button type="submit" name="dep" class="btn btn-primary btn-block" value="for-sale">Buy</button>
            </div>
            <!-- form-group -->
        </div>
        <!-- col -->

        <div class="col-xs-2">
            <div class="form-group">
                <button type="submit" name="dep" class="btn btn-primary btn-block" value="to-rent">Rent</button>
            </div>
            <!-- form-group -->
        </div>
        <!-- col -->
    
    </div>
    <!-- row -->
</form>