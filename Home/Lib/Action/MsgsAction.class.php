<?php 
class MsgAction extends BaseAction{
	
	public function index(){
		$this->display("Index:msg");
	}
	
	public function save(){
		$data['msgText']=$_POST['msgText'];
		$data['msgTime']=date("Y-m-d H:i:s");
		$data['fromIp']=$_SESSION['user_ip'];
		$data['flag']=0;
        $this->_save($data);		
	}
	
	protected function _save($data){
		$db=new MsgsModel();
		if($db->add($data)){
		  echo "<div class='center'><br><br><img src='Public/success.jpg' /><br><br>发送成功！</div>";
		}else
		  echo "<div class='center'><br><br><img src='Public/error.jpg' /><br><br>呃，服务器开小差了~~~稍后再试··</div>";
	 	
	}
}
?>