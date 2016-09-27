<?php
App::uses('AppModel', 'Model');
class Description extends AppModel {
	var $order = array('Description.title'=>'asc');
	public $hasMany = array(
		'Job' => array(
			'className' => 'Job',
			'foreignKey' => 'occ_code',
			'order' => '',
			'dependent' => true //true = delete child records on delete
		),
	);
}
?>