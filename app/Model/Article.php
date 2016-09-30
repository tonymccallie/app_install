<?php
App::uses('AppModel', 'Model');
class Article extends AppModel {
	var $order = array('Article.start'=>'desc');

	
}
?>