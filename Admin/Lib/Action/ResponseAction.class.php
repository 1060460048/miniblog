<?php
class ResponseAction extends BaseAction{
	public function add(){	
		import("ORG.Util.Input");
		$db=new WorldsResponsesModel();	
		$data['text']=Input::deleteHtmlTags($_POST['text']);
		$data['w_id']=$_POST['w_id'];
		$data['ip']=$_SESSION['user_ip'];
		$data['name']=$_SESSION['sina_me']['name'];
		$data['url']='http://t.sina.com/'.$_SESSION['sina_me']['domain'];
		
		//将回复同步到新浪微博
		$myname=$_SESSION['sina_me']['name'];
		$the_id=$data['w_id'];
		$sql="SELECT * FROM `ty_worlds_responses` WHERE ( `w_id` = '$the_id' ) AND ( `name` != '' )  AND(`name`<>'$myname') 
			  group by name";
		$result=$db->query($sql);
		foreach($result as $item){
			$name .= ' @'.$item['name'].' ';
		}
		if($id=$db->add($data)){			
			$url = "http://t-y.me/index.php/Worlds/view/id/".$data['w_id'];
			if($name<>''){			
				$msg=$this->sina_update($name.' :TY在t-y.me回复了你！点击查看'.$url.'   '.date("Y-m-d H:i:s"));				
			}
			echo $data['text']." -<a href='".$data['url']."'>".$data['name']."</a>".'('.$name.$msg.')';			
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

	public function del(){
		$map['r_id']=$_POST['r_id'];
		$db=new WorldsResponsesModel();
		if($db->where($map)->delete()){
			$this->ajaxReturn(1,'',1);
		}
	}
	
	public function ty(){
		$db=new WorldsResponsesModel();			
		$map['w_id']=array('eq',260);
		$map['name']=array('neq','');
		$result=$db->where($map)->select();
		$name=join(' @',$result['name']);
		dump($result);	
		echo $db->getLastSql();
	}
}

?>