<?php
class MsgsModel extends BaseModel{

	protected $_auto=array(
		array('time','getDatetime',1,'callback'),
		array('ip','getIp',1,'callback'),
	);
		
	protected $_validate=array(
		array('text','checkTextlength','内容长度不符合要求',1,'callback')
	);
	
	public function checkTextlength(){
		if(empty($_POST['text']) or strlen($_POST['text'])>=600)
			return false;		
	}


}
?>