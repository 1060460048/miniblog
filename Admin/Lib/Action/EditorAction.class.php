<?php 
class EditorAction extends BaseAction{

	public function upload(){
        if(!empty($_FILES))
          $this->_upload(); //如果有文件上传 上传附件
    }

    protected function _upload(){
		import("ORG.Net.UploadFile");
		import('ORG.Net.Json');
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
			//上传失败
			$error=$upload->getErrorMsg();
			$this->alert($error);
		}else{
			//上传成功
            $photo=$upload->getUploadFileInfo();
            $url=$photo['savepath'].$photo['savename'];
            header('Content-type: text/html; charset=UTF-8');
			$json = new Services_JSON();
			echo $json->encode(array('error' => 0, 'url' => $file_url));
			exit;
		}
	}
	
	function alert($msg) {
		header('Content-type: text/html; charset=UTF-8');
		import('ORG.Net.Json');
		$json = new Services_JSON();
		echo $json->encode(array('error' => 1, 'message' => $msg));
		exit;
	}	
}
?>