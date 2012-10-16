<?php
class LinkAction extends BaseAction{

	public function index() {
		$db=new LinksModel();
		//绑定所取得的数据
		$this->assign('rs',$db->where('pass_flag=1')->order('sort asc,date asc')->select());
		$this->assign('rs2',$db->where('pass_flag=0')->select());
		$this->assign('count',$count);
		$this->display("Index:link");
		//dump($rs);
	}

	public function add(){
		$this->display("Index:addLink");
	}

	public function save(){
		//引入input类，过滤用户输入
		import("ORG.Util.Input");
		$db=new LinksModel();
		//接收处理传递到的数据
		$data=array(
			'worlds'=>str_replace('\\','',str_replace("&quot;",'',Input::forShow($_POST['linkWorlds']))),
			'www_url'=>$_POST['wwwUrl'],
			'wap_url'=>$_POST['wapUrl'],
			'email'=>$_POST['email'],
			'date'=>date("Y-m-d H:i:s"),
			'sort'=>1+$db->max('sort'),
			'pass_flag'=>1,
		);		

		//错误判读
		if($data['worlds']=='' or $data['www_url']=='' or $data['email']=='') {
			$this->ajaxReturn(0,'请将表单填写完整后提交，如果你禁用了javascript,请开启！',0);        
		}elseif(!$db->add($data)){
	    	$this->ajaxReturn(0,'(⊙o⊙)…服务器开小差了。',0);
	    }else{
	    	$this->ajaxReturn(1,'添加成功！审核通过后会将此链接显示在首页.',1);
	    }
	}

	public function formAction(){
		$db=new LinksModel();
		if(!$db->autoCheckToken($_POST)){
			$this->error('非法提交');
		}
		$id=$_POST['id'];
		switch($_POST['button']){
			case '同意所选':
				$this->pass();
				break;
			case '忽略所选':
				$this->ignore();
				break;
			default:
				$this->error('非法提交！');
		}
		//dump($_POST);
	}

	public function pass(){
		$db=new LinksModel();
		$data['pass_flag']=1;
		$id=$_POST['id'];
		foreach($id as $n=>$k){
			$map['id']=$k;
			if(!$db->where($map)->save($data))
				continue;
		}
		$this->index();
	}

	public function ignore(){
		$db=new LinksModel();
		$id=$_POST['id'];
		foreach($id as $n=>$k){
			$map['id']=$k;
			if(!$db->where($map)->delete());
			continue;
		}
		$this->index();
	}
	
	public function del(){
		$map['id']=$_GET['id'];
		$db=new LinksModel();
		$db->where($map)->delete();
		$this->redirect('Link/index');
	}
	
	public function edi(){
		$map['id']=$_GET['id'];
		$db=new LinksModel();
		$this->assign('rs',$db->where($map)->find());
		
		if($_POST['id']<>''){
			$this->_edi();
		}else{
			$this->display('Index:ediLink');
		}
	}
	
	protected function  _edi(){
		//dump($_POST);
		import('ORG.Util.Input');
		$map['id']=$_POST['id'];
		$data=array(
			'worlds'=>str_replace('\\','',str_replace("&quot;",'',$_POST['worlds'])),
			'www_url'=>$_POST['www_url'],
			'wap_url'=>$_POST['wap_url'],
			'email'=>$_POST['email'],
			'sort'=>$_POST['sort'],
		);
		$db=new LinksModel();
		if(!$db->autoCheckToken($_POST)){
			$this->error('非法提交！');
		}
		$db->where($map)->save($data);
		$this->redirect('Link/index');
		
	}

}
?>