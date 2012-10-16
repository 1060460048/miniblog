<?php 
// +----------------------------------------------------------------------
// | FileName:VerifyAction.class.php
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://www.T-yu.net All rights reserved.
// +----------------------------------------------------------------------
// | Blog: http://www.T-yu.net/
// +----------------------------------------------------------------------
// | Author: T.y <Tianyu0915@gmail.com>
// +----------------------------------------------------------------------
// | Date:2010-8-10
// +----------------------------------------------------------------------
//

/**
 +------------------------------------------------------------------------------
 * 验证码模块
 +------------------------------------------------------------------------------
 * @author    T.y <Tianyu0915@gmail.com>
 * @version   
 +------------------------------------------------------------------------------
 */
class VerifyAction extends BaseAction{
	public function verify()
	{
		import("ORG.Util.Image");
		Image::buildImageVerify($length=4,$mode=2,$type='png',$width=48,$height=22,$verifyName='verify');
	}

	public function checkVerify()
	{
		if($_GET['verify']=='')
			$this->ajaxReturn("true","验证不存在",0);
		else if($_SESSION['verify']==MD5($_GET['verify']))
			$this->ajaxReturn("true","验证码正确",1);
		else
			$this->ajaxReturn("false","验证码错误",2);
	}	
}
?>