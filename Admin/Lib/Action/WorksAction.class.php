<?php
class WorksAction extends BaseAction{

	public function index(){
		$db=new WorksModel();
		$this->assign('work',$rs=$db->order('id')->select());
		$this->assign('count',$db->count());
		$this->display("Index:works");
		//dump($rs);
	}
}
?>