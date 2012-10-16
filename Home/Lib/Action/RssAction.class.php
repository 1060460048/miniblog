<?php
class RssAction extends BaseAction{
	public function index(){
		$db=new WorldsModel();	
        
        $rs=$db->relation(true)->order('id desc')->select();
        $$this->getConfig;;

        $this->assign('rs',$rs);
        $this->display('Index:rss');
	}
}