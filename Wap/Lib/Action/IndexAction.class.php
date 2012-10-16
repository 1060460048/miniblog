<?php
class IndexAction extends Action{
	function _initialize(){
		$this->getConfig();
		//$this->checkWap(); //检查是否是手机访问
	}
	
 	protected  function getConfig(){
		$db=new ConfigModel();
		$configList=$db->findAll();
		$config=$this->toSingle($configList);
		
		$this->c=$config;
		$this->assign('c',$config);
	}	

	protected  function toSingle($list){
		$count=count($list);
		$r=array();
		for($i=0;$i<$count;$i++){
			$k=$list[$i]['k'];
			$v=$list[$i]['v'];
			$r[$k]=$v;
		}
		return $r;
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

	public function index()	{
		import("ORG.Util.Page");
		$now=date("Y-m-d");
		$db=new WorldsModel();
		$count['total']=$db->count(); //总条数			
		$count['new']=$db->where("substring(time,1,10)='$now'")->count();//今日更新条数

		$page=new Page($db->count(),5);
        $rs=$db->relation(true)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('count',$count);
        $this->assign('rs',$rs);
        $this->assign('page_nav',$page->show());
		$this->display();
	}

	public function viewWorlds(){
		$map['id']=$_GET['id'];
		$db=new WorldsModel();
		$this->assign('rs',$db->where($map)->relation(true)->find());
		$this->display();
		//dump($db->where($map)->relation(true)->find());
	}

	public function vieworldsPic()	{
		$this->assign('name',$_GET['id']);
		$this->display();
	}

	public function link()	{
		$db=new LinksModel();
		$rs=$db->where("pass_flag=1 ")->select();
		$this->assign('rs',$rs);
		$this->display("Index:link");
		//dump($rs);
	}

	public function about()	{
		$this->display("Index:about");
	}

	public function msg(){
		$this->display("Index:msg");		
	}
	
	public function sendMsg(){
		$db=new MsgsModel();
		$db->create();
		if(!$db->add()){
			$this->gError('发送短信时出现错误  '.$db->getError(),'index');
		}else{
			$this->gSuccess('发送成功！','index');
		}
	}

	public function login()	{
		$this->display("Index:login");
	}

	public function check(){
		$db=new AdminModel();
		$map['username']=$_POST['userName'];
		$map['psd']=MD5($_POST['psd'].q13as21345fdga);
		if(!$db->where($map)->find()){			
			$this->assign('msg','用户名或者密码错误！');
			$this->display("Index:login");
		}else{
			//echo "yes" ;exit;
			$_SESSION['user_login_flag']=true;
			$_SESSION['username']=$map['username'];
			$this->redirect('WapAdmin/index');
		}				
	}

	public function addResponse(){
		import('ORG.Util.Input');
		$db=new WorldsResponsesModel();
		$data['text']=Input::deleteHtmlTags($_POST['text']);
		$data['w_id']=$_POST['w_id'];
		$data['ip']=$_SESSION['user_ip'];		
		if($db->add($data)){
		  unset($data);
		  $db=new WorldsModel();
		  $data['last_time']=date("Y-m-d H:i:s");
		  $map['id']=$_POST['w_id'];
		  $db->where($map)->save($data);		
		  $this->gSuccess("你的评论“".$_POST['text']."“发表成功！","viewWorlds?id=".$_POST['w_id']);
		}else{
		  $this->gError("呃,".$db->getError(),"viewWorlds?id=".$_POST['w_id']);
		}
	}
	
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
	

}
?>