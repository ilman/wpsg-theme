<?php 

require_once(TEMPLATEPATH.'/settings/helpers/admin_helper.php');

function sg_admin_metabox_test(){

// Field Array
$prefix = '_test_'; //always use prefix _ for metabox

$sample_options = array (
	array (
		'label' => 'Option One',
		'value'	=> 'one'
	),
	array (
		'label' => 'Option Two',
		'value'	=> 'two'
	),
	array (
		'label' => 'Option Three',
		'value'	=> 'three'
	)
);

$fields = array(
	array(
		'label'=> 'Heading 1',
		'type'	=> 'heading'
	),
	array(
		'label'		=> 'Text Input',
		'desc'		=> 'A description for the field.',
		'id'		=> $prefix.'text',
		'default'	=> 'test',
		//'repeat'	=> true,
		'type'		=> 'text'
	),
	array(
		'label'		=> 'Text Input',
		'desc'		=> 'A description for the field.',
		'id'		=> $prefix.'textasd',
		'default'	=> array('asd','zxc'),
		'repeat'	=> true,
		'type'		=> 'text'
	),
	array(
		'label'		=> 'tabs',
		'type'		=> 'fieldset',
		'fields'	=> array(
			array(
				'label'		=> 'Logo aad',
				'id'		=> 'logo1',
				'default'	=> 'falcon-logo.png',
				'type'		=> 'text',
			),
			array(
				'label'		=> 'Logo',
				'id'		=> 'logo2',
				'default'	=> 'logo.png',
				'type'		=> 'text',
			),
			array(
				'label'		=> 'Bla bla',
				'id'		=> 'blu_blu',
				'default'	=> 'lorem ipsum dolor sit amet consectuer adisplicing elit',
				'type'		=> 'textarea',
			),
		)
	),
	
);
	return $fields;
}

// $sample_box = new sg_metabox(array(
// 	'id'		=> 'sample_box', 
// 	'title'		=> 'Sample Box', 
// 	'fields'	=> 'sg_admin_metabox_test', 
// 	'post_type'	=> 'page',
// 	'context'	=> 'advanced',
// 	'priority'	=> 'hight'
// ));