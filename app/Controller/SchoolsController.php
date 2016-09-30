<?php
App::uses('AppController', 'Controller');
class SchoolsController extends AppController {
	function admin_index() {
		$this->set('schools',$this->paginate());
	}
	
	function admin_add() {
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->School->save($this->request->data)) {
				$this->Session->setFlash('The school has been saved','success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The school could not be saved. Please, try again.','error');
			}
		}
	}
	
	function admin_edit($id = null) {
		if (!$this->School->exists($id)) {
			throw new NotFoundException(__('Invalid school'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->School->save($this->request->data)) {
				$this->Session->setFlash('The school has been saved','success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The school could not be saved. Please, try again.','error');
			}
		} else {
			$options = array('conditions' => array('School.id' => $id));
			$this->request->data = $this->School->find('first', $options);
		}
	}
	
	function admin_delete($id = null) {
		$this->School->id = $id;
		if (!$this->School->exists()) {
			throw new NotFoundException(__('Invalid school'));
		}
		if ($this->School->delete()) {
			$this->Session->setFlash('School deleted','success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('School was not deleted','error');
		$this->redirect(array('action' => 'index'));
	}
}
?>