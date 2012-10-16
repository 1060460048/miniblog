<?php 
class LinkAction extends BaseAction{

	public function index()
	{
		$db=new LinksModel();
		$rs=$db->where("pass_flag=1 and wapUrl<>''")->select();
		$this->assign('rs',$rs);
		$this->display("WapAdmin:link");
	}
}
?>