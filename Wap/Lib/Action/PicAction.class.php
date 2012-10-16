<?php
class PicAction extends BaseAction{
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
	  	  	$data['time']=date("Y-m-d H:i:s");
	  	  	$data['iswap']==1;
	  	  	$_SESSION['w_id']=$db->add($data);
			$this->savePic($photo,$_SESSION['w_id']);
		}
	}

    protected function savePic($photo){
    	$db=new WorldsPicsModel();
    	foreach($photo as $p){
    		$data['name']=$p['savename'];
    		$data['w_id']=$_SESSION['w_id'];
    		//dump($data);
    		if(!$db->add($data))
    			continue;
    	}		
		//显示已经上传的图片
    	$db=new WorldsPicsModel();
    	unset($map);
    	$map['w_id']=$_SESSION['w_id'];
		$rs=$db->where($map)->select();
		$this->assign('rs',$rs);
		$this->display("WapAdmin:addPic");		
    }

 	public function addPic() 	{
 		$db=new WorldsModel();
 		$rs=$db->order("w_id DESC")->find();             //找到最大的w_id
 		$_SESSION['w_id']=$rs['w_id']+1;                  //计算出本次操作的w_id
 		$this->display("WapAdmin:addPic");
 	}


	public function vieworldsPic(){
		$this->assign('name',$_GET['id']);
		$this->display("WapAdmin:viewPic");
	}
}
?>