<?php
App::uses('AppModel', 'Model');
class School extends AppModel {
	public $hasMany = array(
		'Counselor'
	);
}
?>