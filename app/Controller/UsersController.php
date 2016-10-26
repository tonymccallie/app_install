<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController {
	public $careersteps = array(
		'step1' => "Choose Career School",
		'step2' => "Tour Career School",
		'step3' => "Interview Past Graduate",
		'step4' => "Fill Out Application",
		'step5' => "Submit Application Fee (If Required)",
		'step6' => "Schedule Start Date"
	);

	public $militarysteps = array(
		'step1' => "Decide Enlisted or Officer",
		'step2' => "Visiting a Recruiter",
		'step3' => "Military Entrance Processing Station (MEPS)",
		'step4' => "Pass the Armed Services Vocational Aptitude Battery (ASVAB)",
		'step5' => "Pass the Physical Examination",
		'step6' => "Meet With a MEPS Career Counselor and Determine a Career",
		'step7' => "Take the Oath of Enlistment (swearing in)",
		'step8' => "Basic Training (Boot Camp)"
	);

	public $collegesteps = array(
		'step1' => "Get the application",
		'step2' => "Make a note of the regular application deadline",
		'step3' => "Make a note of the early application deadline",
		'step4' => "Request high school transcript sent",
		'step5' => "Request midyear grade report sent",
		'step6' => "Find out if an admission test is required",
		'step7' => "Take an admission test, if required",
		'step8' => "Take required or recommended tests (SAT, ACT, TSI, AP Exams)",
		'step9' => "Send admission-test scores",
		'step10' => "Send other test scores",
		'step11' => "Request recommendation letters",
		'step12' => "Send thank-you notes to recommendation writers",
		'step13' => "Draft initial essay",
		'step14' => "Proofread essay for spelling and grammar",
		'step15' => "Revise your essay",
		'step16' => "Interview at college campus",
		'step17' => "Submit FAFSA",
		'step18' => "Make a note of the priority financial aid deadline",
		'step19' => "Make a note of the regular financial aid deadline",
		'step20' => "Complete college application",
		'step21' => "Make copies of all application materials",
		'step22' => "Pay application fee",
		'step23' => "Sign and send application",
		'step24' => "Submit college aid form, if needed",
		'step25' => "Submit state aid form, if needed",
		'step26' => "Confirm receipt of application materials",
		'step27' => "Send additional material, if needed",
		'step28' => "Tell school counselor that you applied",
		'step29' => "Receive letter from office of admission",
		'step30' => "Receive financial aid award letter",
		'step31' => "Meet deadline to accept admission and send deposit",
		'step32' => "Accept financial aid offer",
		'step33' => "Notify the colleges you will not attend"
	);
	
	function ajax_login() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		
		$message = array(
			'status' => 'ERROR',
			'data' => 'Init'
		);
		
		$params = json_decode(file_get_contents('php://input'),true);
		if($params) {
			$user = $this->User->findByEmail($params['email']);
			if(!$user) {
				$message = array(
					'status' => 'MESSAGE',
					'data' => 'No user found with that email address.'
				);
			} else {
				if($user['User']['passwd'] == Authsome::hash($params['password'])) {
					$message = array(
						'status' => 'SUCCESS',
						'data' => $user
					);
				} else {
					$message = array(
						'status' => 'MESSAGE',
						'data' => 'Incorrect password'
					);
				}
			}
		}
		
		echo json_encode($message);
	}
	
	function ajax_facebook() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		
		$message = array(
			'status' => 'ERROR',
			'data' => 'Init'
		);
		
		$params = json_decode(file_get_contents('php://input'),true);
		if($params) {
			$user = $this->User->findByFacebook($params['id']);
			if(!$user) {
				$user = $this->User->findByEmail($params['email']);
				if(!$user) {
					$user = array(
						'User' => array(
							'facebook_id' => $params['id'],
							'email' => $params['email'],
							'first_name' => $params['first_name'],
							'last_name' => $params['last_name'],
							'role_id' => 2,
							'verified' => 'NOW()',
							'link_code' => Common::generateRandom(9,true)
						)
					);	
				} else {
					$user['User']['facebook_id'] = $params['id'];
					$user['User']['email'] = $params['email'];
				}
				$this->User->create();
				if($this->User->save($user,false)) {
					$user = $this->User->findByFacebookId($params['id']);
					$message = array(
						'status' => 'SUCCESS',
						'data' => $user
					);
				} else {
					
				}
			} else {
				$message = array(
					'status' => 'SUCCESS',
					'data' => $user
				);
			}
			$message['data'] = $user;
		}
		
		echo json_encode($message);
	}
	
	function ajax_register() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		
		$message = array(
			'status' => 'ERROR',
			'data' => 'Init'
		);
		
		$params = json_decode(file_get_contents('php://input'),true);
		
		if($params) {
			$bolCreate = true;
			$user = $this->User->findByEmail($params['email']);
			if(!$user) {
				$user = array(
					'User' => array(
						'passwd' => Authsome::hash($params['password']),
						'email' => $params['email'],
						'first_name' => $params['first_name'],
						'last_name' => $params['last_name'],
						'role_id' => 2,
						'verified' => 'NOW()',
						'link_code' => Common::generateRandom(9,true)
					)
				);	
			} else {
				if((!empty($user['User']['passwd']))&&($user['User']['passwd'] != Authsome::hash($params['password']))) {
					$message = array(
						'status' => 'MESSAGE',
						'data' => 'A user with this email address already exists. Please log in to continue.'
					);
					$bolCreate = false;
				} else {
					$user['User']['passwd'] = Authsome::hash($params['password']);
				}
				if(empty($user['User']['link_code'])) {
					$user['User']['link_code'] = Common::generateRandom(9,true);
				}
			}
			if($bolCreate) {
				$this->User->create();
				if($this->User->save($user, false)) {
					$user = $this->User->findByEmail($params['email']);
					$message = array(
						'status' => 'SUCCESS',
						'data' => $user
					);
				} else {
					$message['data'] = 'There was an error saving the User';
				}
			}
		}
		
		echo json_encode($message);
	}
	
	function ajax_link() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		
		$message = array(
			'status' => 'ERROR',
			'data' => 'Init'
		);
		
		$params = json_decode(file_get_contents('php://input'),true);

		if($params) {
			$user = $this->User->findById($params['user_id']);
			$spouse = $this->User->findByLinkCode($params['code']);
			if(!$user) {
				$message = array(
					'status' => 'MESSAGE',
					'data' => 'No user found with that id.'
				);
			} else {
				if(!$spouse) {
					$message = array(
						'status' => 'MESSAGE',
						'data' => 'No spouse found with that code.'
					);
				} else {
					$data = array(
						array('User'=>$user['User']),
						array('User'=>$spouse['User'])
					);
					$data[0]['User']['spouse_id'] = $spouse['User']['id'];
					$data[1]['User']['spouse_id'] = $user['User']['id'];
					if($this->User->saveAll($data, array('validate'=>false))) {
						$newuser = $this->User->findById($user['User']['id']);
						$message = array(
							'status' => 'SUCCESS',
							'data' => $newuser
						);
					}
				}
			}
		} else {
			$message['data'] = 'No params';
		}

		
		echo json_encode($message);
	}
	
	function ajax_recover() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		
		$message = array(
			'status' => 'ERROR',
			'data' => 'Recover Init'
		);
		
		$input = file_get_contents('php://input');
		
		$params = json_decode($input,true);
		
		if($params) {
			//send email
			$user = $this->User->findByEmail($params['email']);
			if(!$user) {
				$message['data'] = 'No user with that email found.';
			} else {
				$url = Common::currentUrl().'users/recover/'.$user['User']['id'].'-'.substr($user['User']['passwd'],0,6);
			
				Common::email(array(
					'to' => $user['User']['email'],
					'subject' => 'Password Reset Instructions',
					'template' => 'recover',
					'variables' => array(
						'url' => $url
					)
				),'');
	
				$message = array(
					'status' => 'SUCCESS',
					'data' => $user
				);
			}
		}
		
		echo json_encode($message);
	}
	
	function ajax_update() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		
		$message = array(
			'status' => 'ERROR',
			'data' => 'Init'
		);
		
		$params = array('User'=>array());
		
		$params['User'] = json_decode(file_get_contents('php://input'),true);
		$this->log($params);
		
		if($this->User->save($params,array('validate'=>false))) {
			$user = $this->User->findById($params['User']['id']);
			$message = array(
				'status' => 'SUCCESS',
				'data' => am($user,$params)
			);
		}
		
		//$message['data'] = $params;
		
		echo json_encode($message);
	}
	
	function ajax_upload() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		
		$message = array(
			'status' => 'ERROR',
			'data' => 'Init'
		);
		
		$params = json_decode(file_get_contents('php://input'),true);
		
		$this->log(array($this->request->params, $_POST));
		$tempFile = $this->request->params['form']['post']['tmp_name'];
		move_uploaded_file($tempFile,APP . 'webroot/uploads/image_'.$_POST['user_id'].'.jpg');
		
		$message = '/uploads/image_'.$_POST['user_id'].'.jpg';
		
		echo $message;
	}
	
	function ajax_counselor() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		
		$message = array(
			'status' => 'SUCCESS',
			'data' => 'Init'
		);
		
		$params = json_decode(file_get_contents('php://input'),true);
		//$this->log(array('COUNSELOR',$params));
		
		$Schools = ClassRegistry::init('School');
		
		$school = $Schools->findByTitle($params['User']['school']);
		
		if($school) {
			$counselors = Set::extract('/Counselor/email', $school);
			$json = json_decode($params['User']['json'], true);
			
			switch($json['path']) {
				case 'Career School':
					$steps = $this->careersteps;
					break;
				case 'Military':
					$steps = $this->militarysteps;
					break;
				default:
					$steps = $this->collegesteps;
					break;
			}
			
			Common::email(array(
				'to' => $counselors,
				'subject' => "Here's my plan - ".$params['User']['first_name'].' '.$params['User']['last_name'],
				'template' => 'share',
				'replyTo' => $params['User']['email'],
				'variables' => array(
					'data' => $params,
					'steps' => $steps,
					'json' => $json
				)
			),'');
		}
		
		echo json_encode($message);
	}
	
	function ajax_share() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		
		$message = array(
			'status' => 'SUCCESS',
			'data' => 'Init'
		);
		
		$params = json_decode(file_get_contents('php://input'),true);
		
		$json = json_decode($params['user']['User']['json'], true);
			
		switch($json['path']) {
			case 'Career School':
				$steps = $this->careersteps;
				break;
			case 'Military':
				$steps = $this->militarysteps;
				break;
			default:
				$steps = $this->collegesteps;
				break;
		}
		
		Common::email(array(
			'to' => $params['email'],
			'subject' => "Here's my plan - ".$params['user']['User']['first_name'].' '.$params['user']['User']['last_name'],
			'template' => 'share',
			'replyTo' => $params['user']['User']['email'],
			'variables' => array(
				'data' => $params['user'],
				'steps' => $steps,
				'json' => $json
			)
		),'');
		
		echo json_encode($message);
	}
	
	
	
	function ajax_cron() {
		Configure::write('debug', 0);
		$this->layout = "ajax";
		$this->view = "ajax";
		$decisions = "";
	}
	
	
	function oauthlogin() {
		$this->layout = "ajax";
		$this->view = "ajax";
	}
	
	function oauthlogout() {
		$this->layout = "ajax";
		$this->view = "ajax";
	}
	
	function login() {
		Authsome::logout();
		if(empty($this->request->data)) {
			return;
		}
		$user = Authsome::login($this->request->data['User']);

		if (!$user) {
			$this->Session->setFlash('Unable to login with that information. Did you verify the account?','alert');
			$this->redirect(array('action'=>'login'));
			return;
		}
		
		Authsome::persist('1 month');
		
		if(!empty($user['User']['refer_url'])) {
			$this->request->data['User']['url'] = $user['User']['refer_url'];
			$user['User']['refer_url'] = "";
			unset($user['User']['passwd']);
			$this->User->save($user);
			$this->Session->write('User',$this->User->update($this->Session->read('User')));
		}
		$this->Session->delete('dashboard_url');
		if((empty($this->request->data['User']['url']))||($this->request->data['User']['url']=='/users/logout')) {
			$this->request->data['User']['url'] = "/dashboard/";
		}
		

		return $this->redirect($this->request->data['User']['url']);

	}
	
	function logout() {
		Authsome::logout();
		return $this->redirect('/');
	}
	
	function recover($key = null) {
		if(!empty($key)) {
			if(!empty($this->request->data)) {
				if($this->User->save($this->request->data)) {
					$this->Session->setFlash('Password successfully changed.', 'success');
					$this->redirect(array('action'=>'login'));
				} else {
					$this->Session->setFlash('There was an error changing the password.', 'error');
				}
			}
			$keyArray = explode('-',$key);
			$this->request->data = $this->User->findById($keyArray[0]);
			$this->request->data['User']['passwd'] = '';
			$this->view = 'password';
		} else {
			if(!empty($this->request->data)) {
				
				$user = $this->User->findByEmail($this->request->data['User']['email']);
				if(!$user) {
					$this->Session->setFlash('We were unable to find an account with that email address.', 'alert');
					return true;
				}
				$url = Common::currentUrl().'users/recover/'.$user['User']['id'].'-'.substr($user['User']['passwd'],0,6);
				
				Common::email(array(
					'to' => $this->request->data['User']['email'],
					'subject' => 'Password Reset Instructions',
					'template' => 'recover',
					'variables' => array(
						'url' => $url
					)
				),'');

				$this->Session->setFlash('An email has been sent to '.$this->request->data['User']['email'].' with a link to reset your password.', 'success');
				$this->redirect(array('controller'=>'users','action'=>'login'));
			}
		}
	}
	
	function password() {
		if(!empty($this->request->data)) {
			if($this->User->save($this->request->data)) {
				$this->Session->setFlash('Password successfully changed.', 'success');
				$this->redirect(array('action'=>'dashboard'));
			} else {
				$this->Session->setFlash('There was an error changing the password.', 'error');
			}
		} else {
			$this->request->data = $this->User->findById(Authsome::get('id'));
			$this->request->data['User']['passwd'] = '';
		}
	}
	
	function register($regkey = '') {
		if(!empty($regkey)) {
			$arRegkey = explode('-',$regkey);
			
			$user = $this->User->find('first',array(
				'conditions' => array(
					'User.id' => $arRegkey[0],
					'SUBSTR(User.passwd,1,6)' => $arRegkey[1],
					'User.verified' => null
				)
			));

			if(!$user) {
				$this->Session->setFlash('That user could not be located or has already been verified.','alert');
			} else {
				$this->User->updateAll(
					array(
						'verified' => "'".date('Y-m-d H:i')."'"
					),
					array(
						'User.id' => $user['User']['id']
					)
				);
				$this->Session->setFlash('Thank you for confirming your email. You may now login!', 'success');
				$this->redirect(array('controller'=>'users','action'=>'login'));
			}
		} else {
			if (!empty($this->request->data)) {
				$this->User->create();

				$this->User->validate['passwd'] = array(
					'ruleTitle' => array(
						'rule' => array('notEmpty'),
						'message' => 'A Password is required.'
					)
				);
				
				//Get User Role
				$this->request->data['User']['role_id'] = $this->User->Role->lookup(array(
					'name'=>'User',
					'permissions' => '*:*,!*:admin_*',
				));
								
				if ($this->User->save($this->request->data)) {
					$this->request->data['User']['passwd'] = Authsome::hash($this->request->data['User']['passwd']);
					$url = Common::currentUrl().'users/register/'.$this->User->getLastInsertId().'-'.substr($this->request->data['User']['passwd'],0,6);
					Common::email(array(
						'to' => $this->request->data['User']['email'],
						'subject' => 'New User Registration',
						'template' => 'register',
						'variables' => array(
							'url' => $url
						)
					),'');
					$this->Session->setFlash('Thank you for registering. An email has been sent to '.$this->request->data['User']['email'].'. Please click on the link in the email to verify your account.','success');
					$this->redirect(array('action'=>'login'));
				} else {
					$this->Session->setFlash('There was a problem creating the account, see below.','error');
				}
			}
		}
	}
	
	
	function dashboard() {
		
	}
	
	
	public function admin_index() {
		//$this->User->recursive = 0;
/*
		$this->paginate = array(
			'contain' => array()
		);
*/
		
		$this->set('users', $this->paginate());
	}

	public function admin_edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('The user has been saved','success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The user could not be saved. Please, try again.','error');
			}
		} else {
			$options = array('conditions' => array('User.id' => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$this->set('roles',$this->User->Role->find('list'));
	}
	
	public function admin_push() {
		//curl -u 70df943bed932fae7ff8f09a57b632769575bc24a217fb9e: -H "Content-Type: application/json" -H "X-Ionic-Application-Id: b5459458" https://push.ionic.io/api/v1/push -d '{"user_ids": ["949afe04-02e7-4d6f-84eb-f4a9d57a876e"],"production": false,"notification":{"title": "Test Multiple", "alert":"Heyo"}}'
	}


	public function admin_delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash('User deleted','success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('User was not deleted','error');
		$this->redirect(array('action' => 'index'));
	}
}
?>