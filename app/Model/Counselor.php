<?php
App::uses('AppModel', 'Model');
class Counselor extends AppModel {
	public $belongsTo = array(
		'School'
	);
}
?>