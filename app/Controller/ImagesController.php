<?php
App::uses('AppController', 'Controller');
class ImagesController extends AppController {
	var $helpers = array('Cache');
	function thumb($url = "") {
		Configure::write('debug', 2);
		$this->layout = "image";
	}
}
?>