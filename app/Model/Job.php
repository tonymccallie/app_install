<?php
App::uses('AppModel', 'Model');
class Job extends AppModel {
	var $order = array('Job.title' => 'asc');
	
	public $belongsTo = array(
		'Description' => array(
			'className' => 'Description',
			'foreignKey' => 'occ_code'
		),
	);
}
?>