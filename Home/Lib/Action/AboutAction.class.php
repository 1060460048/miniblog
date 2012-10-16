<?php 
class AboutAction extends BaseAction{
	
	public function index(){
		$rs=$this->getConfig('about')+$this->getConfig('about_text');
		$this->assign('rs',$rs);
		$this->display("Index:about");
	}
}

?>