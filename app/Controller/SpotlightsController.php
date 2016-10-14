<?php
App::uses('AppController', 'Controller');
class SpotlightsController extends AppController {
	function ajax_listing() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		
		$message = array(
			'status' => 'ERROR',
			'data' => 'Upcoming Init'
		);
		
		$spotlights = $this->Spotlight->find('all');
		
		
		$message = array(
			'status' => 'SUCCESS',
			'data' => $spotlights
		);
		
		echo json_encode($message);
	}
	
	function admin_index() {
		$this->set('spotlights',$this->paginate());
	}
	
	function admin_add() {
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Spotlight->save($this->request->data)) {
				$this->Session->setFlash('The spotlight has been saved','success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The spotlight could not be saved. Please, try again.','error');
			}
		}
	}
	
	function admin_edit($id = null) {
		if (!$this->Spotlight->exists($id)) {
			throw new NotFoundException(__('Invalid spotlight'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Spotlight->save($this->request->data)) {
				$this->Session->setFlash('The spotlight has been saved','success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The spotlight could not be saved. Please, try again.','error');
			}
		} else {
			$options = array('conditions' => array('Spotlight.id' => $id));
			$this->request->data = $this->Spotlight->find('first', $options);
		}
	}
	
	function admin_delete($id = null) {
		$this->Spotlight->id = $id;
		if (!$this->Spotlight->exists()) {
			throw new NotFoundException(__('Invalid spotlight'));
		}
		if ($this->Spotlight->delete()) {
			$this->Session->setFlash('Spotlight deleted','success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Spotlight was not deleted','error');
		$this->redirect(array('action' => 'index'));
	}
}
?>