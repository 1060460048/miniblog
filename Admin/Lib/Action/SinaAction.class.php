<?php
class SinaAction extends BaseAction{
	public function aurl(){
		$c=$this->getConfig();
		include_once('Public/Oauth/sinaWeiboOauth.php');
		$o=new WeiboOauth($c['WB_AKEY'],$c['WB_SKEY']);	
		$keys=$o->getRequestToken();
		$aurl=$o->getAuthorizeURL($keys['oauth_token'],false,$c['domain']."/admin.php/Sina/callback");
		$_SESSION['keys']=$keys;
		echo "<a href=$aurl>点击这里登陆你的新浪微博</a>";
	}
	
	public function callback(){
		$c=$this->getConfig();
		include_once('Public/Oauth/sinaWeiboOauth.php');
		$o = new WeiboOAuth($c['WB_AKEY'] , 
							$c['WB_SKEY'] , 
							$_SESSION['keys']['oauth_token'] , 
							$_SESSION['keys']['oauth_token_secret']);
		$last_key=$o->getAccessToken($_REQUEST['oauth_verifier'] );
		//dump($last_key);
		$db=new ConfigModel();
		$data['k']='sina_oauth_token';
		$data['v']=$last_key['oauth_token'];
		$db->where("k='sina_oauth_token'")->save($data);
		unset($data);
		$data['k']='sina_oauth_secret';
		$data['v']=$last_key['oauth_token_secret'];
		$db->where("k='sina_oauth_secret'")->save($data);
		
		if(!empty($last_key['user_id'])){
			$this->assign('jumpUrl',"__APP__");
			$this->success('恭喜你，验证通过！');
		}else{
			$this->assign('jumpUrl',"__APP__");
			$this->error('验证失败，请检查用户名或者密码是否正确。并返回重新验证！');
		}					
	}
	
	public function clearn(){
		$friends=$this->sina->friends();
		
		//dump($friends);exit;
		foreach($friends as $item){
			$this->sina->unfollow($item['id']);
			echo '取消关注:'.$item['name'].' 成功！';	
			echo "<br>";			
		}
		$me=$this->sina->verify_credentials();
		echo '还有关注人数：'.$me['friends_count'];
		echo "<br>";
		echo '如果你还想继续取消关注其他好友，新本页即可！';
		echo "<br>";
		echo '每天最多取消关注：80人，如果无法继续取消关注，请明天再来。'	;	
	}
	
	public function limit(){
		$result=$this->sina->oauth->get("http://api.t.sina.com.cn/account/rate_limit_status.json");
		dump($result);
	}


}

?>