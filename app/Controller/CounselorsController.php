<?php
App::uses('AppController', 'Controller');
class CounselorsController extends AppController {
	function admin_index() {
		$this->set('counselors',$this->paginate());
	}
	
	function admin_add() {
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Counselor->save($this->request->data)) {
				$this->Session->setFlash('The counselor has been saved','success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The counselor could not be saved. Please, try again.','error');
			}
		}
	}
	
	function admin_edit($id = null) {
		if (!$this->Counselor->exists($id)) {
			throw new NotFoundException(__('Invalid counselor'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Counselor->save($this->request->data)) {
				$this->Session->setFlash('The counselor has been saved','success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The counselor could not be saved. Please, try again.','error');
			}
		} else {
			$options = array('conditions' => array('Counselor.id' => $id));
			$this->request->data = $this->Counselor->find('first', $options);
		}
	}
	
	function admin_delete($id = null) {
		$this->Counselor->id = $id;
		if (!$this->Counselor->exists()) {
			throw new NotFoundException(__('Invalid counselor'));
		}
		if ($this->Counselor->delete()) {
			$this->Session->setFlash('Counselor deleted','success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Counselor was not deleted','error');
		$this->redirect(array('action' => 'index'));
	}
}
?>