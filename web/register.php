<?php
	include_once './lib/User.php';
	class Register extends User
	{
		public function __construct(){

		}

		public function md5Func($password){
			return md5($password);
		}

		/*public function check($property,$value){
			this
		}*/
		public function check () {
			if(!preg_match('/^[\w\x80-\xff]{3,15}$/', $this->username)){
				exit(json_encode([
						'message'=>'用户名不符合规范'
					]));
			}
			if(strlen($this->password)<6){
				exit(json_encode([
						'message'=>'密码长度需要大于六位'
					]));
			}
		}
	}

	$reg = new Register();

	$reg->setUsername($_POST['username']);
	$reg->setPassword($_POST['password']);
	$reg->setRole($_POST['role']);

	$reg->check();
	$result = array();
	$result = $reg->getBypro(array('username'=>$reg->getUsername()));
	if(count($result) != 0){
		exit(json_encode([
				'message'=>'该用户已经被注册'
			]));
	}

	$reg->setPassword($reg->md5Func($reg->getPassword()));

	if($reg->save()){
		echo json_encode([
			'message'=>'注册成功，请登录!'
			]);
	}

	//echo $reg->getBypro('username','lanmingming')[0]->getUsername();