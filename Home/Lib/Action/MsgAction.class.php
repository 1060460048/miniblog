<?php 
class MsgAction extends BaseAction{
	
	public function index(){
		$this->display("Index:msg");
	}
	
	public function save(){	
		$db=new MsgsModel();
		import("ORG.Util.Input");
		$data['text']=Input::deleteHtmlTags($_POST['text']);
		$data['time']=date("Y-m-d H:i:s");
		$data['ip']=$this->getIp();
		//
		if($db->add($data)){
		  echo "<div id='sendmsg' class='center'>发送成功！</div>";
			//dump($data);	
		}else
		  echo "<div id='sendmsg' class='center red'>呃，服务器开小差了~~~稍后再试··</div>";
        	
	}
	


}
?>