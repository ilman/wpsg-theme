<?php 
	if(sg_val($_GET,'param')=='h1'){
		echo '<h1>Heading 1 Text</h1>';
	}
	elseif(sg_val($_GET,'param')=='h2'){
		echo '<h2>Heading 2 Text</h2>';
	}
	elseif(sg_val($_GET,'param')=='h3'){
		echo '<h3>Heading 3 Text</h3>';
	}
	elseif(sg_val($_GET,'param')=='h4'){
		echo '<h4>Heading 4 Text</h6>';
	}
	elseif(sg_val($_GET,'param')=='h5'){
		echo '<h5>Heading 5 Text</h6>';
	}
	elseif(sg_val($_GET,'param')=='h6'){
		echo '<h6>Heading 6 Text</h6>';
	}
?>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eleifend dui vel sollicitudin ornare. Nam lacus nisl, varius ac blandit a, tempor vitae justo. Nam et purus sed elit posuere lacinia.</p>