<?php
App::uses('AppController', 'Controller');
class EventsController extends AppController {
	function ajax_upcoming() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		
		$message = array(
			'status' => 'ERROR',
			'data' => 'Upcoming Init'
		);
		
		$events = $this->Event->find('all',array(
			'conditions' => array(
				'Event.event_date >=' => date('Y-m-d')
			)
		));
		
		$months = array();
		$curMonth = null;
		$index = -1;
		
		foreach($events as $event) {
			$monthName = date('F Y',strtotime($event['Event']['event_date']));
			if($curMonth != $monthName) {
				$curMonth = $monthName;
				$index++;
				$months[$index] = array(
					'title' => $curMonth,
					'events' => array()
				);
			}
			array_push($months[$index]['events'], $event);
		}
		
		$message = array(
			'status' => 'SUCCESS',
			'data' => $months
		);
		
		echo json_encode($message);
	}
	
	function admin_index() {
		$this->set('events',$this->paginate());
	}
	
	function admin_add() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['Event']['event_date'] = date('Y-m-d',strtotime($this->request->data['Event']['event_date']['year'].'-'.$this->request->data['Event']['event_date']['month'].'-'.$this->request->data['Event']['event_date']['day']));
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash('The event has been saved','success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The event could not be saved. Please, try again.','error');
			}
		}
	}
	
	function admin_edit($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid event'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash('The event has been saved','success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The event could not be saved. Please, try again.','error');
			}
		} else {
			$options = array('conditions' => array('Event.id' => $id));
			$this->request->data = $this->Event->find('first', $options);
		}
	}
	
	function admin_delete($id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}
		if ($this->Event->delete()) {
			$this->Session->setFlash('Event deleted','success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Event was not deleted','error');
		$this->redirect(array('action' => 'index'));
	}
}
?>