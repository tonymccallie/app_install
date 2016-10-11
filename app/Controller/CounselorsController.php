<?php
App::uses('AppController', 'Controller');
class CounselorsController extends AppController {
	function ajax_listing() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		
		$message = array(
			'status' => 'ERROR',
			'data' => 'Upcoming Init'
		);
		
		$counselors = $this->Counselor->find('all',array(
			'order' => array(
				'Counselor.school_id' => 'asc',
				'Counselor.last_name' => 'asc',
				'Counselor.first_name' => 'asc'
			)
		));
		
		
		$message = array(
			'status' => 'SUCCESS',
			'data' => $counselors
		);
		
		echo json_encode($message);
	}
	
	function admin_index() {
		$this->set('counselors',$this->paginate());
	}
	
	function admin_import() {
		if(!empty($this->request->data['Counselor']['data'])) {
			$orig = $this->request->data['Counselor']['data'];
			$arEntries = explode("\r\n",trim($orig));
			$counselors = array();
			foreach($arEntries as $index => $entry) {
				//$entry = str_ireplace(",","\t",$entry);
				$arEntry = explode("\t",$entry);
				$name = explode(" ",$arEntry[0]);
				$school_id = $this->Counselor->School->lookup(array(
					'title' => $arEntry[1]
				));
				$data = array(
					'Counselor' => array(
						'first_name' => $name[0],
						'last_name' => $name[1],
						'email' => $arEntry[2],
						'phone' => $arEntry[3],
						'school_id' => $school_id
					)
				);
				array_push($counselors, $data);
			}
			if($counselors) {
				$this->Counselor->deleteAll(array('1'));
				if($this->Counselor->saveAll($counselors)) {
					$this->Session->setFlash('Counselors Created','success');
					$this->redirect(array('action'=>'index'));
				}
			}
		}
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