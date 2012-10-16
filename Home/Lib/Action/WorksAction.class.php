<?php
class WorksAction extends BaseAction{

	public function index(){
		$db=new WorksModel();
		$this->assign('work',$rs=$db->order('id')->select());
		$this->display("Index:works");
	}
}
?>