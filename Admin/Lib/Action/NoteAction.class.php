<?php
class NoteAction extends BaseAction{
	public function index()	{
		import("ORG.Util.Page");
		$db=new ArticlesModel();
		$page=new Page($db->count(),8);
		$page->setConfig('header','篇日记');
		$rs=$db->relation(true)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('rs',$rs);
		$this->assign('page_nav',$page->show());
		$this->display("Index:note");
		
		//dump($rs);
		//echo $db->getLastSql();
	}

	public function view(){
		$map['id']=isset($_GET['id'])?$_GET['id'] : null;
		$db=new ArticlesModel();
		$rs=$db->relation(true)->where($map)->find();
		if($rs['id']==null || $rs['id']===false || $map['id']===null){
			$this->error('你查看的日志不存在，或者已经被管理员删除！');
		}
		$this->assign('rs',$rs);
		$this->display('Index:article');
		//dump($rs);
	}
	
	public function del(){
		$map['id']=$_GET['id'];
		if(empty($map['id'])){
			$this->error('非法操作！');
		}
		$db=new ArticlesModel();
		$rs=$db->where($map)->delete();
		if($rs===null || $rs===false){
			$this->error('删除日志基本信息失败！');
		}
		$db=new ArticlesContentModel();
		$rs2=$db->where($map)->delete();
		if($rs2===null || $rs2===false){
			$this->error('删除日志内容失败！');
		}
		$this->redirect('Note/index');
		
	}
	
	public function edi(){
		$map['id']=$_GET['id'];
		if(empty($map['id'])){
			$this->error('非法操作！');
		}
		$db=new ArticlesModel();
		$rs=$db->relation(true)->where($map)->find();
		$this->assign('rs',$rs);
		$this->display('Index:ediNote');		
	}
	
	public function save(){
		//dump($_POST);exit;
		if($_POST['title']=='' || $_POST['text']==''){
			$this->error('标题或者内容不能为空！');
		}
		$map['id']=$_POST['id'];
		$db=new ArticlesModel();
		$data=array(
			'title'=>Input::safeHtml($_POST['title']),
		);
		$id=$db->where($map)->save($data);
		if($id===false || $id===null){
			$this->error('保存文章基本信息时出现错误'.$db->getError());
		}
		//存入日志内容信息
		$db=new ArticlesContentModel();
		unset($data);
		$data=array(
			'text'=>str_replace('\\','',str_replace("&quot;",'',$_POST['text'])),
		);
		$rs=$db->where($map)->save($data);
			if($rs===false || $rs===null){
			$this->error('保存文章内容时出现错误:'.$db->getError());
		}
		$this->redirect('Note/view/id/'.$map['id']);
	}
	
	public function add(){		
		if($_POST['title']=='' and $_POST['text']==''){
			$this->display('Index:addNote');
		}else{
			$this->_add();
		}
	}
	
	
	protected function _add($post){
		if($_POST['title']=='' || $_POST['text']==''){
			$this->error('标题或内容不能为空！');
		}		
		$data=array(
			'title'=>Input::getVar($_POST['title']),
			'date'=>date('Y-m-d H:i:s'),
		);		
		//存入日志基本信息
		$db=new ArticlesModel();
		//dump($data);exit;
		$id=$db->add($data);
		if($id===false || $id===null){
			$this->error('保存文章基本信息时出现错误'.$db->getError());
		}
		//存入日志内容信息
		$db=new ArticlesContentModel();
		unset($data);
		$data=array(
			'id'=>$id,
			'text'=>str_replace('\\','',str_replace("&quot;",'',$_POST['text'])),
		);
		$rs=$db->add($data);
			if($rs===false || $rs===null){
			$this->error('保存文章内容时出现错误'.$db->getError());
		}
		$c=$this->getConfig();
		$msg='发表文章《'.Input::getVar($_POST['title']).'》 详细:'.$c['domain'].'/index.php/Note/view/id/'.$data['id'];
		//同步到本站微博
		$db=new WorldsModel();
		$data=array(
			'text'=>Input::makeLink($msg),
			'time'=>date('Y-m-d H:i:s'),
		);
		$db->add($data);
		//同步到新浪微博
		$this->sina_update($msg);
		$this->redirect('Note/view/id/'.$id);
	}
	
}

?>