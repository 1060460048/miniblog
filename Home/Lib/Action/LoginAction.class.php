<?php 
class LoginAction extends BaseAction{
	
	public function index(){
		$this->display("Index:login");		
	}
	
	public function check(){ 		
		$db=new AdminModel();
		$map['username']=$_POST['userName'];
		$map['psd']=MD5($_POST['pwd'].q13as21345fdga);
	    if($_SESSION['verify'] != md5($_POST['verify'])){
	    	$this->ajaxReturn(0,'验证码错误！',0);
		}elseif(!$db->where($map)->find()){			
			$_SESSION['username']=$_POST['userName']; 
			$_SESSION['user_login_flag']=true;
			$this->ajaxReturn(2,'登陆成功！正在跳转...',2);			
			$this->ajaxReturn(1,'用户名密码错误！',1);
		}else{
			$_SESSION['username']=$_POST['userName']; 
			$_SESSION['user_login_flag']=true;
			$this->ajaxReturn(2,'登陆成功！正在跳转...',2);			
		} 		
	}
		

	
}
?>
