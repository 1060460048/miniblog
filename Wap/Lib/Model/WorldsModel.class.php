<?php
class WorldsModel extends RelationModel
{	
	//关联模型定义
	protected $_link=array(
		'response'=>array(
			'mapping_type'=>HAS_MANY,
			'class_name'=>'worlds_responses',
			'foreign_key'=>'w_id',
			'mapping_order'=>'r_id'
		),
		'pic'=>array(
			'mapping_type'=>HAS_MANY,
			'class_name'=>'worlds_pics',
			'foreign_key'=>'w_id',
			'mapping_order'=>'p_id desc'
		)
	);
	
	//自动完成定义
	protected $_auto=array(
		array('time','getDatetime',1,'callback')
	);
	
	//自动验证定义
	protected $_validate=array(
		array('text','checkTextlength','微博内容得长度不符合要求',1,'callback')
	);
	
	public function getDatetime(){
		return date("Y-m-d H:i:s");
	}
	
	public function checkTextlength(){
		if(empty($_POST['text']) or strlen($_POST['text'])>=1600)
			return false;
		
	}


}
?>