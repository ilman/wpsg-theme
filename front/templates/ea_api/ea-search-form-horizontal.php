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
		<div class="col-sm-4">
			 <div class="form-group">
				<label>Area</label>
				<?php 
					$options = array();
					$options[] = array('label'=>'Select Area', 'value'=>'');
					foreach($areas as $area){
						$options[] = array('label'=>htmlspecialchars($area), 'value'=>$area);
					}
					$this_attr = array(
						'class' => 'form-control input-select2',
						'multiple' => 'multiple',
						'placeholder' => 'Select Areas'
					);
					echo SG_Form::field('select2','xbranches[]',$values,$this_attr,'',$options);
				?>
			</div>
		</div>
		<!-- col -->
		<div class="col-sm-2">
			<div class="form-group">
				<div class="row">
					<div class="col-xs-12">
						<label>Bed Rooms</label>
						<?php 
							$options = array(
								array('label'=>'-Min Room-', 'value'=>''),
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
		<div class="col-sm-3">
			<div class="form-group">
				<div class="row">
					<div class="col-xs-6">
						<label>Min. Price</label>
						<?php 
							$price_dep = SG_Util::val($values,'dep','for-sale');
							if($price_dep == 'new-homes'){
								$price_dep = 'for-sale';
							}
							$price_array = ea_price_array($price_dep);
						?>
						<?php 
							$options = array(
								array('label'=>'-Min Price-', 'value'=>'')
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
								array('label'=>'-Max Price-', 'value'=>'')
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
		<div class="col-sm-3">
			<div class="form-group">
				<div class="row">
					<div class="col-xs-6">
						<button type="submit" class="btn btn-block btn-primary" name="dep" value="for-sale">Buy</button>
					</div>
					<!-- col -->
					<div class="col-xs-6">
						<button type="submit" class="btn btn-block btn-primary" name="dep" value="to-rent">Rent</button>
					</div>
					<!-- col -->
				</div>
				<!-- row -->
			</div>
			<!-- form-group -->
		</div>
		<!-- col -->
	</div>
	<!-- row -->
</form>