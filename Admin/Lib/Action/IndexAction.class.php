<?php
class IndexAction extends BaseAction{
	public function index()	{
		import("ORG.Util.Page");
		$now=date("Y-m-d");
		$db=new WorldsModel();
		$count['total']=$db->count(); //总条数		
		$count['new']=$db->where("substring(time,1,10)='$now'")->count();//今日更新条数
		$page=new page($count['total'],10);
        $page->setConfig('header','条微博');
        $world=$db->relation(true)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('count',$count);
        $this->assign('world',$world);
        $this->assign('page_nav',$page->show());
		$this->display();
		//dump($);
	}

	public function help(){
		$this->display("Index:help");
	}

	public function wap(){
		$this->display("Index:wap");
	}

	public function copyRight(){
		$this->display("Index:copyRight");
	}





}
?>