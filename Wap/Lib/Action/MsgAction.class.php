<?php 
class MsgAction extends BaseAction{

	public function index()	{		
		import("ORG.Util.Page");
		$db=new MsgsModel();
		$count=$db->count();
		$Page=new Page($count,5);
		$page_nav=$Page->show();
		$rs=$db->order("flag desc,time desc")->limit($Page->firstRow.','.$Page->listRows)->select();

		$this->assign('count',$count);
		$this->assign('rs',$rs);
		$this->assign('page_nav',$page_nav);
		$this->display("WapAdmin:msg");
	}

	public function viewMsg()	{
		$map['id']=$_GET['id'];
		$db=new MsgsModel();
		$rs=$db->where($map)->find();
		$this->assign('rs',$rs);
		$date['flag']=1;//标记为已读;
		if($rs['flag']==0)
		  $db->where($map)->save($date);
		$this->display("WapAdmin:viewMsg");
	}	
}
?>