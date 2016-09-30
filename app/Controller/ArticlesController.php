<?php
App::uses('AppController', 'Controller');
class ArticlesController extends AppController {
	function ajax_latest() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		
		$message = array(
			'status' => 'ERROR',
			'data' => 'Upcoming Init'
		);
		
		$articles = $this->Article->find('all',array(
			'conditions' => array(
				'Article.start <=' => date('Y-m-d')
			)
		));
		
		
		$message = array(
			'status' => 'SUCCESS',
			'data' => $articles
		);
		
		echo json_encode($message);
	}
	
	function admin_index() {
		$this->set('articles',$this->paginate());
	}
	
	function admin_add() {
		if ($this->request->is('post') || $this->request->is('put')) {
			//Common::dateFix($this->request->data['Article']['start']);
			if(!$this->request->data['Article']['imagefile']['error'] == 4) {
				$targetPath = $_SERVER['DOCUMENT_ROOT'] . $this->webroot . 'app/webroot/uploads/';
				$filename = 'article_'.date('Y.m.d_His').'_'.$this->request->data['Article']['imagefile']['name'];
				move_uploaded_file($this->request->data['Article']['imagefile']['tmp_name'], $targetPath.$filename);
				$this->request->data['Article']['image'] = $filename;
			}
			if ($this->Article->save($this->request->data)) {
				$this->Session->setFlash('The article has been saved','success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The article could not be saved. Please, try again.','error');
			}
		}
	}
	
	function admin_edit($id = null) {
		if (!$this->Article->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			//die(debug($this->request->data['Article']['start']));
			//Common::dateFix($this->request->data['Article']['start']);
			if(!$this->request->data['Article']['imagefile']['error'] == 4) {
				$targetPath = $_SERVER['DOCUMENT_ROOT'] . $this->webroot . 'app/webroot/uploads/';
				$filename = 'article_'.date('Y.m.d_His').'_'.$this->request->data['Article']['imagefile']['name'];
				move_uploaded_file($this->request->data['Article']['imagefile']['tmp_name'], $targetPath.$filename);
				$this->request->data['Article']['image'] = $filename;
			}
			if ($this->Article->save($this->request->data)) {
				$this->Session->setFlash('The article has been saved','success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The article could not be saved. Please, try again.','error');
			}
		} else {
			$options = array('conditions' => array('Article.id' => $id));
			$this->request->data = $this->Article->find('first', $options);
		}
	}
	
	function admin_delete($id = null) {
		$this->Article->id = $id;
		if (!$this->Article->exists()) {
			throw new NotFoundException(__('Invalid article'));
		}
		if ($this->Article->delete()) {
			$this->Session->setFlash('Article deleted','success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Article was not deleted','error');
		$this->redirect(array('action' => 'index'));
	}
}
?>