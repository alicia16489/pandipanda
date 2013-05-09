<?php
	require_once('models/mediaClass.model.php');
	
	$template_left='media_search';
	
	// instance object
	$types = new Table('media_types');
	$types->dataField('name');
	$list_type=$types->getDataFields();
	
	$labels = new Table('admin_labels');
	$labels->dataField('name');
	$list_label=$labels->getDataFields();
	
	$keywords = new Table('keywords');
	$keywords->dataField('name');
	$list_keywords=$keywords->getDataFields();
	
	$category = new Table('category');
	$category->dataField('name');
	$list_category = $category->getDataFields();
	
	if(!empty($_POST)){
		$media = new Media();
		$data = $media->getMediasBySearch($post);
		
	}
	
?>