<?php
class WorldsAction extends BaseAction{

	public function view() {
		$db=new WorldsModel();
		$map['id']=isset($_GET['id'])?(int)$_GET['id']:null;
		if($map['id']==null){
			$this->error('非法操作'); exit;
		}
		$data=array('last_time'=>null,);
		$db->where($map)->save($data);
		
		$count['total']=$db->count();	//微薄总数
		$count['new']=$db->where("substring(time,1,10)='$now'")->count();	//竟日更新条数
		$rs=$db->where($map)->relation(true)->select();
		if($rs===null || $rs===false){
			$this->error("你查看的内容不存在或者已经被管理员删除！");
		}
		$this->assign('world',$rs);
		$this->assign('count',$count);
		$this->display("Index:viewWorld");
		//echo $db->getLastSql();
		
	}

	public function add(){
		$db=new WorldsModel();
		$db->create();
	    if($id=$db->add($data)){
	    	$this->sina_update($_POST['text']." http://t-y.me/index.php/Worlds/view/id/$id");
  			$this->redirect('Index/index');	    	
	    }else{
	    	$this->assign('jumpUrl',"__APP__/Index");
	    	$this->error('服务器开小差了，发表微博失败！');
	    }
  			
 	}

	public function link(){
		$this->display('Index:addWorldsLink');
	}

	public function del(){
		//删除微博
		$map['id']=$_POST['w_id'];
		$db=new WorldsModel();
		$db->where($map)->delete();
		
		//删除回复
		unset($map);
		$map['w_id']=$_POST['w_id'];
	  	$db=new WorldsResponsesModel();
	  	$db->where($map)->delete() ;
		
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
		$this->ajaxReturn(1,'',1);
	}


	public function addPic(){
		$_SESSION['add_worlds_pic']='step1';
		$this->display('Index:addWorldsPic');
	}

    public function upload(){
        if(!empty($_FILES))
          $this->_upload(); //如果有文件上传 上传附件
    }

    protected function _upload(){
		import("ORG.Net.UploadFile");
		$upload = new UploadFile();
        $upload->maxSize  = 1000000 ;//设置上传文件大小
        $upload->allowExts  = array('jpg','gif','png','jpeg');//设置上传文件类型
        $upload->savePath =  './Public/Upload/'; //设置附件上传目录
        $upload->thumb =  true;//设置需要生成缩略图，仅对图像文件有效
        $upload->thumbPrefix   =  'wap120_,wap160_';//设置需要生成缩略图的文件后缀
        $upload->thumbMaxWidth =  '300,300';//设置缩略图最大宽度
        $upload->thumbMaxHeight = '100,160';//设置缩略图最大高度
        $upload->saveRule = uniqid;//设置上传文件规则
        $upload->thumbRemoveOrigin = false;//删除原图
		if(!$upload->upload()){
			$error=$upload->getErrorMsg();
			$this->error("对不起，图片上传出错，错误信息：$error");
		}else{
            $photo=$upload->getUploadFileInfo();
            $db=new WorldsModel();
	  	  	$data['text']='[PIC]';
	  	  	$_SESSION['w_id']=$db->add($data);
			$this->savePic($photo,$_SESSION['w_id']);
		}
	}

    protected function savePic($photo){
		$c=$this->getConfig();
    	$db=new WorldsPicsModel();
    	foreach($photo as $p){
    		$data['name']=$p['savename'];
    		$data['w_id']=$_SESSION['w_id'];
    		//dump($data);
    		if(!$db->add($data))
    			continue;
    	}
    	$_SESSION['add_worlds_pic']='step2';
		$this->showSavePic();
		$this->sina_update("分享了图片 ".$c['domain'].'/Worlds/view/id/'.$data['w_id']);
    }

    protected function showSavePic($map){
    	$map['w_id']= $map=='' ? $_SESSION['w_id'] : $map['w_id'];
    	$db=new WorldsPicsModel();
		$rs=$db->where($map)->select();
		$this->assign('rs',$rs);
		$this->display('Index:addWorldsPic');
		//dump($rs);
    }

    public function removePic(){
    	$map['p_id']=$_GET['p_id'];
    	$map['w_id']=$_SESSION['w_id'];
    	if($this->delPic($map))
    		unset($map['p_id']);
    		$this->showSavePic($map);
    }

    public function ediWorlds(){
    	$map['id']=$_SESSION['w_id'];
		$db=new WorldsModel();
		$db->create();
	    if($db->where($map)->save($data)){
	    	$this->redirect("Index/index");
	    }else{
			$this->assign('jumpUrl','__App__/Index');
			$this->error('发表微博失败，请重试一次');
	    }
	    //$db->getLastSql()    	
    }
	
	public function ty(){
		$r=$this->getConfig();
		dump($r);
	}



}
?>