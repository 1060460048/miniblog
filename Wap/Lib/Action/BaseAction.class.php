<?php
// +----------------------------------------------------------------------
// | FileName:BaseAction.class.php
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://www.T-yu.net All rights reserved.
// +----------------------------------------------------------------------
// | Blog: http://www.T-yu.net/
// +----------------------------------------------------------------------
// | Author: T.y <Tianyu0915@gmail.com>
// +----------------------------------------------------------------------
// | Date:2010-8-10
// +----------------------------------------------------------------------
//


/**
 +------------------------------------------------------------------------------
 * 控制器基类 初始化操作
 +------------------------------------------------------------------------------
 * @author    T.y <Tianyu0915@gmail.com>
 * @version
 +------------------------------------------------------------------------------
 */
class BaseAction extends Action{
	
	public $sina;

	/**
	 *加载初始化函数
	 */
	function  _initialize(){
		$this->getConfig();
		$this->checkLogin();
		$this->msgCount();
		$this->sinaWeibo();
	}

	function _empty(){
		$this->error("你请求的页面不存在");
	}

	protected function checkLogin() {
		if(null===$_SESSION['user_login_flag'] || false===$_SESSION['user_login_flag']){
			$this->assign('msg',"请先登录！");
			$this->display('Index:login');
			exit;
		}
	}

	protected function sendEmail($smtpemailto,$mailsubject,$text)
	{
		$User=new MsgsModel();
	    import("ORG.Util.Smtp");
		$smtpserver = "smtp.126.com";//SMTP服务器
		$smtpserverport =25;//SMTP服务器端口
		$smtpusermail = "tianyu0915@126.com";//SMTP服务器的用户邮箱
		//$smtpemailto = "tianyu0915@gmail.com";//发送给谁
		$smtpuser = "tianyu0915";//SMTP服务器的用户帐号
		$smtppass = "122126382";//SMTP服务器的用户密码
		//$mailsubject = "[Ty]";//邮件主题
		$mailbody = $text;//邮件内容
		$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
		$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
		$smtp->debug = FALSE;//是否显示发送的调试信息
		$result=$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
		return $result;
		}

	/**
	 *得到访问者的IP地址，存入$_SESSION['user_ip'];
	 */
	protected function getIp()	{
		$ip=$_SESSION['user_ip'];
		if($ip<>'')
		  return $ip;
		else
		//php获取ip的算法
		if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])
		{
		$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
		}
		elseif ($HTTP_SERVER_VARS["HTTP_CLIENT_IP"])
		{
		$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
		}
		elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"])
		{
		$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
		}
		elseif (getenv("HTTP_X_FORWARDED_FOR"))
		{
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		}
		elseif (getenv("HTTP_CLIENT_IP"))
		{
		$ip = getenv("HTTP_CLIENT_IP");
		}
		elseif (getenv("REMOTE_ADDR"))
		{
		$ip = getenv("REMOTE_ADDR");
		}
		else
		{
		$ip = "Unknown";
		}
		$_SESSION['user_ip']=$ip;
		return $ip ;
	}

 	protected	function getConfig(){
		$db=new ConfigModel();
		$configList=$db->findAll();
		//dump($configList);exit;
		$config=$this->toSingle($configList);
		$this->assign('c',$config);
		return $config;
	}


	/**
	 *将二维数组转换为一维数组
	 */
	protected	function toSingle($list){
		$count=count($list);
		$r=array();
		for($i=0;$i<$count;$i++){
			$k=$list[$i]['k'];
			$v=$list[$i]['v'];
			$r[$k]=$v;
		}
		return $r;
	}

	protected function msgCount(){
		$db=new MsgsModel();
		$count=$db->where('flag=0')->count();
		if($count!=0){
	    	$count="<span class='red'>(".$count.")</span>";
		}else{
			unset($count);
		}
	    	$this->assign('msg_count',$count);
	}
	
	protected function gError($msg,$url)	{
		$this->assign('titleE',"出错啦！");
		$this->assign('msg',$msg);
		if($url=='')
		  $url='index';
		$this->assign('url',$url);
		$this->display("Public:gMsg");
		exit;
	}

    protected function gSuccess($msg,$url)	{
		$this->assign('titleS',"操作成功！");
		$this->assign('msg',$msg);
		if($url=='')
		  $url='index';
		$this->assign('url',$url);
		$this->display("Public:gMsg");
		exit;
	}
	
	protected function checkWap(){
		if($_SESSION['is_wap']===null || $_SESSION['is_wap']===false){
			header("Location:index.php");
		}
	}
	
	protected function sinaWeibo(){
		if(isset($_SESSION['sina_me']['id'])){
			return true; exit;
		}
		$c=$this->getConfig();
		include_once('Public/Oauth/sinaWeiboOauth.php');
		$this->sina=new WeiboClient($c['WB_AKEY'],
						   $c['WB_SKEY'],
						   $c['sina_oauth_token'],
						   $c['sina_oauth_secret']);
		//获取新浪微博的个人信息				       							  
		$me=$this->sina->verify_credentials();
		//dump($me);
		if(isset($me['id'])){
			$_SESSION['sina_me']=$me;
		}else{
			unset($_SESSION['sina_me']);
		}		
	}
	
	protected function sina_update($text){
		$c=$this->getConfig();
		include_once('Public/Oauth/sinaWeiboOauth.php');
		$this->sina=new WeiboClient($c['WB_AKEY'],
						   $c['WB_SKEY'],
						   $c['sina_oauth_token'],
						   $c['sina_oauth_secret']);	
		$c=$this->getConfig();
		if($c['update_to_sina']<>1){
			return '同步新浪微博未开启'; exit;
		}		
		$msg=$this->sina->update($text);
		if($msg===null || $msg===false){
			return '同步到新浪微博失败，可能是你没有通过授权';
		}
		if(isset($msg['error_code']) && isset($msg['error'])){
			return '同步到新浪微博失败，错误号：'.$msg['error_code'].'提示：'.$msg['error'];
		}
	}	

}
?>