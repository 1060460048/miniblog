<?php
include_once('Public/Oauth/sinaWeiboOauth.php');
class SinaAction extends BaseAction{
	public function aurl(){	
		$c=$this->getConfig();	
		$o=new WeiboOauth($c['WB_AKEY'],$c['WB_SKEY']);	
		$keys=$o->getRequestToken();
		$aurl=$o->getAuthorizeURL($keys['oauth_token'],false,$c['domain']."/index.php/Sina/callback");
		$_SESSION['keys']=$keys;
		header("Location:$aurl");
		//echo "<a href=$aurl>点击这里登陆你的新浪微博</a>";
		
	}
	
	public function callback(){
		$c=$this->getConfig();
		$o = new WeiboOAuth($c['WB_AKEY'] , 
							$c['WB_SKEY'] , 
							$_SESSION['keys']['oauth_token'], 
							$_SESSION['keys']['oauth_token_secret']);
		$last_key=$o->getAccessToken($_REQUEST['oauth_verifier'] );
		//dump($last_key);
		if(isset($last_key['user_id'])){
			$_SESSION['last_key']=$last_key; 			//将用户的OAUTH TOKEN 存入SESSION备用		
			$user=new WeiboClient($c['WB_AKEY'],
						  	   	  $c['WB_SKEY'],
						       	  $_SESSION['last_key']['oauth_token'] , 
								  $_SESSION['last_key']['oauth_token_secret']);					
			$user->follow($_SESSION['sina_me']['id']);  //在新浪微博中关注博主
			$this->redirect('Index/index');
		}else{
			//dump($last_key);exit;
			$this->assign('jumpUrl',"__APP__");
			$this->error('验证失败，请检查用户名或者密码是否正确。并返回重新验证！');
		}					
	}
	
	public function  logout(){
		unset($_SESSION['last_key']);
		unset($_SESSION['sina']);
		unset($_SESSION['ty_notice']);
		unset($_SESSION['sina_unfollow_count']);
		$this->redirect('Index/index');
	}
	
	public function clearn(){	
		//判断是否登录
		if($_SESSION['last_key']===false || $_SESSION['last_key']===null){
			$this->display('Index:sinafriendslogin');	
			exit;		
		}
		if($_SESSION['ty_notice']<>true){		
			$_SESSION['sina_unfollow_count']=0;
			$url="http://t-y.me/index.php/Sina/clearn";
			$msg=$this->update("新浪微博好友批量清理工具： $url ".date("H:i:s"));	
			$_SESSION['ty_notice']=$msg===true?true:false;
		}		
		//如果登录，判断是否有提交操作
		if($_POST['id']==''){
			//dump($this->friends());exit;
			$this->assign('friends',$this->friends());
			$this->display('Index:sinafriendslist');
		//处理提交请求
		}else{
			$this->_clearn();
		}			
	}
	
	protected function _clearn(){
		foreach($_POST['id'] as $item){	
			$this->unfollow($item);		
		}
		//dump($this->sina->friends());
		$this->success('取消关注好友操作完成！');
	}	
	
	
	
	protected function update($content){
		$c=$this->getConfig();	
		$o=new WeiboClient($c['WB_AKEY'],
						   $c['WB_SKEY'],
						   $_SESSION['last_key']['oauth_token'] , 
						   $_SESSION['last_key']['oauth_token_secret']);		
		$msg=$o->update($content);
		//dump($msg);exit;
		return isset($msg['id'])?true:false;	
	}
	
	protected function friends(){
		$c=$this->getConfig();	
		$o=new WeiboClient($c['WB_AKEY'],
						   $c['WB_SKEY'],
						   $_SESSION['last_key']['oauth_token'] , 
						   $_SESSION['last_key']['oauth_token_secret']);		
		$r=$o->friends();
		//dump($r);exit;
		return $r;
	}
	
	protected function unfollow($id_name){
		$c=$this->getConfig();	
		$o=new WeiboClient($c['WB_AKEY'],
						   $c['WB_SKEY'],
						   $_SESSION['last_key']['oauth_token'] , 
						   $_SESSION['last_key']['oauth_token_secret']);		
		$msg=$o->unfollow($id_name);
		if($msg===null || $msg===false){
			$this->error('取消关注失败，请尝试重新登录');
		}
		if(isset($msg['error_code']) && isset($msg['error'])){
			$this->error('取消关注好友失败，错误号：'.$msg['error_code'].'提示：'.$msg['error']);
		}
		if(isset($msg['id'])){
			$_SESSION['sina_unfollow_count']++;
			return true;
		}
	}
	
	public function ty(){
	
		$c=$this->getConfig();	
		$o=new WeiboClient($c['WB_AKEY'],
						   $c['WB_SKEY'],
						   $_SESSION['last_key']['oauth_token'] , 
						   $_SESSION['last_key']['oauth_token_secret']);		
		$msg=$o->unfollow(1872980130);	
		dump($msg);
	}


}

?>