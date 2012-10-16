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
		$this->assign('c',$this->getConfig());
		$this->checkLogin();
		$this->msgCount();
		//$this->checkWap();
		$this->sinaWeibo();
		$this->msgCount();
	}

	function _empty(){
		$this->error("你请求的页面不存在");
	}

	protected function checkLogin() {
		if(null===$_SESSION['user_login_flag'] || false===$_SESSION['user_login_flag']){
			$this->assign('jumpUrl',"__ROOT__/index.php/Login");
			$this->error('你还没有登陆，请先登陆！');
			exit;
		}
	}

	protected function sendEmail($smtpemailto,$mailsubject,$text)	{
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
		if(isset($ip)){
		  return $ip; exit;
		}
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


 	protected	function getConfig($condition){
		$db=new ConfigModel();	
		if($condition==''){          
			$configList=$db->where("r=1")->select();		
		}elseif($condition=='all'){
			$configList=$db->findAll();		
		}else{
			$configList=$db->where("k='$condition'")->select();
		}	
		foreach($configList as $item){
			$config[$item['k']]=$item['v'];
		}
		return $config;	
	}		

	public function msgCount(){
		$db=new MsgsModel();
		$count=$db->where('flag=0')->count();
		if($count!=0){
	    	$count="<span class='red'>(".$count.")</span>";
		}else{
			unset($count);
		}
	    	$this->assign('msg_count',$count);
	}
	
	protected function checkWap(){
		if($_SESSION['is_wap']===false){
			return false; exit;
		}		
		$db=new IpModel();
		$ip=explode('.',$this->getIp());
		$map['ip']=array('like',$ip['0'].'.'.$ip['1'].'.'.$ip['2'].'%');
		$rs=$db->where($map)->count();
		//电脑访问
		if($rs==0){	
			$_SESSION['is_wap']=false;			
		}else{
			//手机访问
			$_SESSION['is_wap']=true;	
			header("Location:wap.php");exit;
			echo "<meta content='text/html'; charset=utf-8 />";	
			echo '正在跳转...或者'."<a href='".__APP__."/wap.php'>点击进入</a>";			
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
			$this->assign('sina_me',$me);
		}		
	}
	
	protected function sina_update($text){
		$c=$this->getConfig();
		include_once('Public/Oauth/sinaWeiboOauth.php');
		$this->sina=new WeiboClient($c['WB_AKEY'],
						   $c['WB_SKEY'],
						   $c['sina_oauth_token'],
						   $c['sina_oauth_secret']);	
		if($c['update_to_sina']<>1){
			return '同步新浪微博未开启'; exit;
		}	
		$text = substr($text,0,390);	
		$msg=$this->sina->update($text);
		if($msg===null || $msg===false){
			return '同步到新浪微博失败，可能是你没有通过授权';
		}
		if(isset($msg['error_code']) && isset($msg['error'])){
			return '同步到新浪微博失败，错误号：'.$msg['error_code'].'提示：'.$msg['error'];
		}
		//dump($msg);exit;
	}
	


}
?>