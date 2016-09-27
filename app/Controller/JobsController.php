<?php
App::uses('AppController', 'Controller');
class JobsController extends AppController {
	function ajax_search() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		
		$message = array(
			'status' => 'ERROR',
			'data' => 'Search Init'
		);
		
		$conditions = array(
			'OR' => array()
		);
		
		$params = json_decode(file_get_contents('php://input'),true);
		
		if($params) {
			
			foreach($params as $param => $value) {
				if($param != 'salary') {
					$conditions['OR'][$param] = $value;
				} else {
					switch($value) {
						case "A":
							$conditions['annual <'] = 40000;
							break;
						case "B":
							$conditions['annual >'] = 40000;
							$conditions['annual <'] = 60000;
							break;
						case "C":
							$conditions['annual >'] = 60000;
							$conditions['annual <'] = 80000;
							break;
						case "D":
							$conditions['annual >'] = 80000;
							$conditions['annual <'] = 100000;
							break;
						case "E":
							$conditions['annual >'] = 100000;
							break;
					}
				}
			}
		}
		
		$jobs = $this->Job->find('all',array(
			'conditions' => $conditions,
			'order' => array('Job.title'=>'asc')
		));
		
		$message = array(
			'status' => 'SUCCESS',
			'data' => $jobs
		);
		
		echo json_encode($message);
	}
	
	function admin_index() {
		$this->set('jobs', $this->paginate());
	}
	
	function admin_import() {
		if(!empty($this->request->data['Job']['data'])) {
			$orig = $this->request->data['Job']['data'];
			$arEntries = explode("\r\n",trim($orig));
			$jobs = array();
			foreach($arEntries as $entry) {
				//$entry = str_ireplace(",","\t",$entry);
				$arEntry = explode("\t",$entry);
				if(strlen($arEntry[0])==1) {
					if(substr($arEntry[1], 4)!='000') {
						$hourly = preg_replace("/[^0-9.]/", "", $arEntry[28]);
						$annual = preg_replace("/[^0-9.]/", "", $arEntry[29]);
						$data = array(
							'Job' => array(
								'title' => $arEntry[2],
								'occ_code' => $arEntry[1],
								'extrovert' => ($arEntry[3]=='X')?1:0,
								'planner' => ($arEntry[4]=='X')?1:0,
								'technology' => ($arEntry[5]=='X')?1:0,
								'creativity' => ($arEntry[6]=='X')?1:0,
								'risk_taker' => ($arEntry[7]=='X')?1:0,
								'outdoor' => ($arEntry[8]=='X')?1:0,
								'variety' => ($arEntry[9]=='X')?1:0,
								'manager' => ($arEntry[10]=='X')?1:0,
								'cause_driven' => ($arEntry[11]=='X')?1:0,
								'problem_solving' => ($arEntry[12]=='X')?1:0,
								'math' => ($arEntry[13]=='X')?1:0,
								'science' => ($arEntry[14]=='X')?1:0,
								'teaching' => ($arEntry[15]=='X')?1:0,
								'public_speaking' => ($arEntry[16]=='X')?1:0,
								'education' => $arEntry[25],
								'experience' => $arEntry[26],
								'training' => $arEntry[27],
								'hourly' => $hourly,
								'annual' => $annual
							)
						);
						array_push($jobs, $data);
					}
				}
			}
			if($jobs) {
				$this->Job->deleteAll(array('1'));
				if($this->Job->saveAll($jobs)) {
					$this->Session->setFlash('Jobs Created','success');
					$this->redirect(array('action'=>'index'));
				}
			}
		}
	}
}
?>