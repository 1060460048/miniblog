<?php
// +----------------------------------------------------------------------
// | FileName:BaseAction.class.php
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://t-y.me All rights reserved.
// +----------------------------------------------------------------------
// | Blog: http://t-y.me/
// +----------------------------------------------------------------------
// | Author: TY <tianyu0915@gmail.com>
// +----------------------------------------------------------------------
// | Date:2010-12-17
// +----------------------------------------------------------------------
//


class WorldsResponsesModel extends BaseModel{
	
	/**
	 *自动完成定义
	 */
	protected $_auto=array(
		array('time','getDatetime',1,'callback'),
		array('ip','getIp',1,'callback'),
	);
	
	/**
	 *自动验证定义
	 */
	protected $_validate=array(
		array('text','checkTextlength','回复内容长度不符合要求',1,'callback')
	);

	
	public function checkTextlength(){
		if(empty($_POST['text']) or strlen($_POST['text'])>=600)
			return false;		
	}

}
?>