<?php
App::uses('AppController', 'Controller');
class DescriptionsController extends AppController {
	function admin_index() {
		$this->set('descriptions',$this->paginate());
	}
	
	function admin_import() {
		if(!empty($this->request->data['Description']['data'])) {
			$orig = $this->request->data['Description']['data'];
			$arEntries = explode("\r\n",trim($orig));
			$descriptions = array();
			foreach($arEntries as $index => $entry) {
				//$entry = str_ireplace(",","\t",$entry);
				$arEntry = explode("\t",$entry);
				if($index > 6) {
						$data = array(
							'Description' => array(
								'id' => $arEntry[0],
								'title' => $arEntry[1],
								'description' => $arEntry[2]
							)
						);
						array_push($descriptions, $data);
				}
			}
			if($descriptions) {
				$this->Description->deleteAll(array('1'));
				if($this->Description->saveAll($descriptions)) {
					$this->Session->setFlash('Descriptions Created','success');
					$this->redirect(array('action'=>'index'));
				}
			}
		}
	}
}
?>