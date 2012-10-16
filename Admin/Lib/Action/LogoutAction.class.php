<?php 
class LogoutAction extends BaseAction{
	
	public function index(){
		unset($_SESSION['username']);
		unset($_SESSION['user_login_flag']);
		$this->assign('jumpUrl','__ROOT__');
		$this->success('退出成功！');		
	}

		

	
}
?>