<?php 

require_once(TEMPLATEPATH.'/settings/helpers/admin_helper.php');

function sg_mb_page_settings(){

	$prefix = '_sg_mb_page_'; //always use prefix _ for metabox

	/*----options----*/

	$option_layouts = array(
		array('label'=>'Default', 'value'=>''),
		array('label'=>'Full', 'value'=>'layout-full'),
		array('label'=>'Side Right', 'value'=>'layout-side-right'),
		array('label'=>'Side Left', 'value'=>'layout-side-left'),
		array('label'=>'Side Both', 'value'=>'layout-side-both'),
	);

	/*----fields----*/

	$fields = array(
		
		array(
			'label'		=> 'Layout',
			'id'		=> $prefix.'layout',
			'default'	=> '',
			'type'		=> 'select',
			'options'	=> $option_layouts
		),
		array(
			'label'		=> 'Add Section',
			'id'		=> $prefix.'add_section',
			'default'	=> '',
			'type'		=> 'checkbox'
		),
		array(
			'label'		=> 'Section Class',
			'id'		=> $prefix.'section_class',
			'default'	=> '',
			'type'		=> 'text'
		),
		array(
			'label'		=> 'Add Container',
			'id'		=> $prefix.'add_container',
			'default'	=> '',
			'type'		=> 'checkbox'
		),
		array(
			'label'		=> 'Hide Title',
			'id'		=> $prefix.'hide_title',
			'default'	=> '',
			'type'		=> 'checkbox'
		),
		
	);

	return $fields;
}

$sg_mb_layout = new sg_metabox(array(
	'id'		=> 'sg_mb_page_settings', 
	'title'		=> 'Page Settings', 
	'fields'	=> 'sg_mb_page_settings', 
	'post_type'	=> 'page',
	'context'	=> 'side',
	'priority'	=> 'high'
));