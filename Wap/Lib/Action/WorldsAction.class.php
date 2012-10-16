<?php
class WorldsAction extends BaseAction{

	public function addWorlds()	{
		$db=new WorldsModel();
		$db->create();
	    if($db->add($data)){
	    	$this->sina_update($_POST['text'].' http://t-y.me');
  			$this->redirect('WapAdmin/index');
	    }else{
  			$this->gError("呃，".$db->getError(),"index");
	    }
 	}

	public function ediWorlds()	{				
	    $db=new WorldsModel();
		$map['id']=$_GET['id'];
		$this->assign('rs',$db->where($map)->find());
		$this->display("WapAdmin:ediWorlds");		
	}
	
	public function save(){
		$db=new WorldsModel();
		$db->create();
	    if($db->where($map)->save($data))
	    	$this->gSuccess("发表成功!","__APP__/WapAdmin/");
	    else
	    	$this->gError("呃，服务器开小差了~~~稍后再试","__APP__/Worlds/ediWorlds?id=".$_POST['id']);
		//$db->getLastSql()
	}				

	public function delWorlds()	{
		$db=new WorldsModel();
		if($_POST['action']=='del')	{
	      $map['id']=$_POST['w_id'];
		  if (!$db->autoCheckToken($_POST))
  	  	    $this->gError("非法操作！","index");
		  else{
		  	//删除微博
		    $step1=$db->where($map)->delete();
		    //echo $db->getLastSql();
		    
		  	//删除回复
		    unset($map);
		  	$map['w_id']=$_POST['w_id'];
		  	$db=new WorldsResponsesModel();
		  	$step2 = $db->where($map)->find() ? $db->where($map)->delete() : true;
		  	
		  	//删除图片
		  	$db=new WorldsPicsModel();
			$rs=$db->where($map)->select();
			foreach($rs as $rs){
				$file1='./Public/Upload/'.$rs['name'];
				$file2='./Public/Upload/wap120_'.$rs['name'];
				$file3='./Public/Upload/wap160_'.$rs['name'];
				unlink($file1);
				unlink($file2);
				unlink($file3);
			}
			$db->where($map)->delete(); 
		  }		  
		  if($step1 and $step2)
		    $this->gSuccess("删除成功！","__APP__/WapAdmin/index");
		  else
		    $this->gError("呃，服务器开小差了~~~稍后再试,","__APP__/WapAdmin/index");
		}

		$w_id=$_GET['id'];
        $rs=$db->where("id=$w_id")->relation(false)->find();
		$this->assign('rs',$rs);
		$this->assign('w_id',$_GET['id']);
		$this->display("WapAdmin:delWorlds");
		//dump($rs);
	}

	public function viewWorlds(){
		$map['id']=$_GET['id'];
		if(empty($map))
		  $this->gError("非法操作！","index");		  		
		$db=new WorldsModel();
		$rs=$db->where($map)->relation(true)->find();
		$this->assign('rs',$rs);
		
		$data=array('last_time'=>'');
		$db->where($map)->save($rs);
		$this->display("WapAdmin:viewWorlds");
	}

}
?>