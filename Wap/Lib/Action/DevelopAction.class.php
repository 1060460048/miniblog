<?php
class DevelopAction extends BaseAction{
	public function index(){
		$db=new WorldsModel();
		$this->assign('rs',$db->field('id,text')->limit(5)->where("last_time<>''")->order('last_time desc')->select());
		$this->display('WapAdmin:develop');
		//dump($db->field('id,text')->limit(5)->where("last_time<>''")->order('last_time desc')->select());
	}
}
?>