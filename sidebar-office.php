<div class="widget widget-box box-full">
	<div class="widget-header"><div class="sg-title title-fill">Address</div></div>
	<div class="widget-container">
		<?php 
			echo '<p>'.get_post_meta(get_the_ID(), '_sg_mb_office_address', true).'</p>';
			
			echo'<p>';
			echo 'Tel:'.get_post_meta(get_the_ID(), '_sg_mb_office_phone', true).'<br/>';
			echo 'Fax:'.get_post_meta(get_the_ID(), '_sg_mb_office_fax', true).'<br/>';
			echo 'Email:'.do_shortcode(get_post_meta(get_the_ID(), '_sg_mb_office_email', true)).'<br/>';
			echo'</p>';
		?>

		<?php 

			$field_value = get_post_meta(get_the_ID(), '_sg_mb_map_location', true);
			$address_value = get_post_meta(get_the_ID(), '_sg_mb_office_address', true);
			$latlen_value = get_post_meta(get_the_ID(), '_sg_mb_map_latlen', true);

			if(trim($address_value)){
				$field_default = $address_value;
			}

			if(!$field_value){
				$field_value = $field_default;
			}

			if(trim($latlen_value)){
				$field_value = $latlen_value;
			}

		?>
		<input type="hidden" id="sg-mb-map-location" value="<?php echo $field_value ?>" />
		<div class="map-container"><div id="map-canvas" style="width:100%; height:200px;"></div></div>
	</div>
</div>


<div class="widget widget-box box-full">
	<div class="widget-header"><div class="sg-title title-fill">Office Hours</div></div>
	<div class="widget-container">
		<?php 
			$office_hours = get_post_meta(get_the_ID(), '_sg_mb_office_opening_hour', true);
			if(!$office_hours){
				$office_hours = 'Monday: 09:00 – 19:00
					Tuesday: 09:00 – 19:00 
					Wednesday: 09:00 – 19:00 
					Thursday: 09:00 – 19:00 
					Friday: 09:00 – 18:30 
					Saturday: 09:00 – 17:00';
			}
			$office_hours = trim($office_hours);
			$office_hours = explode("\n", $office_hours);

			echo '<table class="table table-striped">';
			foreach ($office_hours as $row) {
				echo '<tr>';
				$cols = explode(': ', $row);

				$i=0;
				foreach ($cols as $col) {
					
					if($i==0){
						echo '<th>'.trim($col).'</th>';
					}	
					else{
						echo '<td>'.trim($col).'</td>';
					}

					$i++;
				}
				echo '</tr>';
			}
			echo '</table>';
		?>
	</div>
</div>