<?php
App::uses('AppModel', 'Model');
class Event extends AppModel {
	var $order = array('Event.event_date'=>'asc');

	var $validate = array(
		'title' => array(
			'ruleName' => array(
				'rule' => array('notBlank'),
				'message' => 'title is required'
			)
		),
		'event_date' => array(
			'ruleName' => array(
				'rule' => array('notBlank'),
				'message' => 'Date is required'
			)
		),
	);
}
?>