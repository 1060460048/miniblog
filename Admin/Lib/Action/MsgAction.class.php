<?php 
class MsgAction extends BaseAction{
	public function index(){
		import("ORG.Util.Page");
		$db=new MsgsModel();
		$Page=new Page($db->count(),15);
		$page_nav=$Page->show();
		$rs=$db->order("flag asc,time desc")->limit($Page->firstRow.','.$Page->listRows)->select();

		$this->assign('rs',$rs);
		$this->assign('page_nav',$page_nav);
		$this->display("Index:msg");
		//dump($rs);
	}
	
	public function del(){
		$db=new MsgsModel();
		//以POST方式删除
		if($_POST['id']<>''){
			foreach($_POST['id'] as $id){
				//echo $id;
				$map['id']=$id;
				$db->where($map)->delete();
			}		
		}
		//以GET方式删除
		if($_GET['id']<>''){
			$map['id']=$_GET['id'];
			$db->where($map)->delete();
		}
		$this->redirect('Msg/index');
	}
	
	public function view(){
		$map['id']=$_GET['id'];
		$db=new MsgsModel();
		$rs=$db->where($map)->find();
		if($rs['id']===null || $rs['id']===false){
			$this->error('你查看的短信不存在，或者已经删除！');
		}
		$this->assign('rs',$rs);
		$this->display('Index:viewMsg');
		$data['flag']=1;
		$db->where($map)->save($data);
	}
}
?>