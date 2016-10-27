<?php
class EmailConfig {

	public $default = array(
		'transport' => 'Mail',
		'from' => 'you@localhost',
		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
	);
	
	public $gmail = array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => 465,
        'username' => 'tony@threeleaf.net',
        'password' => 'Crystalann0411',
        'transport' => 'Smtp'
    );

public $smtp = array(
                'transport' => 'Smtp',
                'from' => array('email@goamarillo.org' => 'Go Amarillo'),
                'host' => 'ssl://email-smtp.us-east-1.amazonaws.com',
                'port' => 465,
                'timeout' => 30,
                'username' => 'AKIAJX3LZ4E7C4S3PPZA',
                'password' => 'AhinLKTr0nxAVBmNUBhsYskhPHKXS8Td+ytJ/JXe3uGG',
                //'client' => null,
                'log' => true
                //'charset' => 'utf-8',
                //'headerCharset' => 'utf-8',
        );

	public $smtpX = array(
		'transport' => 'Smtp',
		'from' => array('site@localhost' => 'My Site'),
		'host' => 'localhost',
		'port' => 25,
		'timeout' => 30,
		'username' => 'user',
		'password' => 'secret',
		'client' => null,
		'log' => false,
		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
	);

	public $fast = array(
		'from' => 'you@localhost',
		'sender' => null,
		'to' => null,
		'cc' => null,
		'bcc' => null,
		'replyTo' => null,
		'readReceipt' => null,
		'returnPath' => null,
		'messageId' => true,
		'subject' => null,
		'message' => null,
		'headers' => null,
		'viewRender' => null,
		'template' => false,
		'layout' => false,
		'viewVars' => null,
		'attachments' => null,
		'emailFormat' => null,
		'transport' => 'Smtp',
		'host' => 'localhost',
		'port' => 25,
		'timeout' => 30,
		'username' => 'user',
		'password' => 'secret',
		'client' => null,
		'log' => true,
		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
	);

}
