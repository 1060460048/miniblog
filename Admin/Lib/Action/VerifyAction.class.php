<?php 
class VerifyAction extends BaseAction{
	
	public function verify(){
		import("ORG.Util.Image");
		Image::buildImageVerify();
		
	}
}
?>