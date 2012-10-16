<?php 
class AboutAction extends BaseAction{
	
	public function index()
	{
		$db=new ConfigModel();
		$rs=$db->where("name='about'")->select();
		$this->assign('rs',$rs);
		$rs2=$db->where("name='version'")->select();
		$this->assign('rs2',$rs2);
		$this->display("WapAdmin:about");
	}	
}
?>