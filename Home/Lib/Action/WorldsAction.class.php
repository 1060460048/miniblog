<?php
class WorldsAction extends BaseAction{

	public function view() {
		$db=new WorldsModel();
		$map['id']=$_GET['id'];
		$count['total']=$db->count();	//微薄总数
		$count['new']=$db->where("substring(time,1,10)='$now'")->count();	//竟日更新条数
		$rs=$db->where($map)->relation(true)->select();
		if($map=='' or $rs=='')
		  $this->error("非法操作1！");
		$this->assign('world',$rs);
		$this->assign('count',$count);
		$this->display("Index:viewWorld");
	}

	public function addResponse(){
		import("ORG.Util.Input");
		$db=new WorldsResponsesModel();	
		$data['text']=Input::deleteHtmlTags($_POST['text']);
		$data['w_id']=$_POST['w_id'];
		$data['ip']=$_SESSION['user_ip'];
		$data['name']=$_SESSION['sina']['name'];
		$data['url']='http://t.sina.com/'.$_SESSION['sina']['id'];
		if($id=$db->add($data)){
			//echo $db->getLastSql();exit;
			$str1=$data['text']."[IP:".$_SESSION['user_ip']."]";
			$str2=$data['text']." -<a href='".$data['url']."'>".$data['name']."</a>";
			echo $_SESSION['sina']['id']<>'' ? $str2 : $str1; 	
		}else{
			echo "<span style='color:red;'>Error</span>";
			echo '(⊙o⊙)…杯具，服务器出现错误！';			
		}
		
		unset($data);
		$db=new WorldsModel();
		$data['last_time']=date("Y-m-d H:i:s");
		$map['id']=$_POST['w_id'];
		$db->where($map)->save($data);
	}
	


}
?>