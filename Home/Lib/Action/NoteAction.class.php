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
			$this->error('你请求的页面不存在！');
		}
		$this->assign('rs',$rs);
		$this->display('Index:article');
		//dump($rs);
	}
}

?>