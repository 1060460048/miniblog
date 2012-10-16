<?php
class WapAdminAction extends BaseAction
{
	public function index()	{
		import("ORG.Util.Page");
		$now=date("Y-m-d");
		$db=new WorldsModel();
		$count['new']=$db->where("substring(time,1,10)='$now'")->count();//今日更新条数

		$page=new Page($db->count(),5);
        $rs=$db->relation(true)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();

        $this->assign('count',$count);
        $this->assign('rs',$rs);
        $this->assign('page_nav',$page->show());
		$this->display();
	}

	public function logout(){
		unset($_SESSION['username']);
		unset($_SESSION['user_login_flag']);
		$this->gSuccess('已经安全退出！',"__APP__/Index");
	}

}