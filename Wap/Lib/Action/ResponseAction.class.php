<?php 
class ResponseAction extends BaseAction{
		
	public function addResponse()	{
		$db=new ResponseModel();
		import("ORG.Util.Input");

		$rs['w_id']=$_POST['w_id'];
		$rs['r_text']=Input::forShow($_POST['r_text']);
		$rs['r_time']=date('Y-m-d H:i:s');
		$rs['r_ip']=$_SESSION['user_ip'];
		if(empty($_SESSION['userName']))	
		  $rs['flag']=0; //0正常，1管理员回复，2已经删除
		else
		  $rs['flag']=1;
		if(strlen($rs['r_text'])>300){//判断提交的内容是否超过100个汉字
		  $s=floor((strlen($rs['r_text'])-300)/3);
		  $_SESSION['r_text']=$rs['r_text'];
		  $this->gError("你的评论超出了".$s."个汉字,","__URL__/viewWorlds?id=".$rs['w_id']);
		}elseif($db->add($rs))//判断是否添加成功
		  $this->gSuccess("你的评论“".$rs['r_text']."“发表成功！","__URL__/viewWorlds?id=".$rs['w_id']);
		else
		  $this->gError("呃，服务器开小差了~~~稍后再试,","__URL__/viewWorlds?id=".$rs['w_id']);
	}	

	public function viewWorlds()	{
		$w_id=$_GET['id'];
		if($w_id=='')
		  $this->gError("非法操作！");
		$db=new WorldsModel();
		$rs=$db->where("w_id=$w_id")->relation(true)->select();
		$this->assign('rs',$rs);
		$this->assign('w_id',$w_id);
		$this->display("WapAdmin:viewWorlds");
	}	
}
?>