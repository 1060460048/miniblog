<?php 
class LinkAction extends BaseAction{
	
	public function index() {
		$db=new LinksModel();		
		//绑定所取得的数据
		$this->assign('rs',$rs=$db->where('pass_flag=1')->order('sort asc,date asc')->select());
		$this->display("Index:link");
		//dump($rs);
	}
	
	public function add(){
		$this->display("Index:addLink");
	}
	
	public function save(){
		//引入input类，过滤用户输入
		import("ORG.Util.Input");
		$db=new LinksModel();
		//接收处理传递到的数据
		$data=array(
			'worlds'=>str_replace('\\','',str_replace("&quot;",'',$_POST['linkWorlds'])),
			'www_url'=>$_POST['wwwUrl'],
			'wap_url'=>$_POST['wapUrl'],
			'email'=>$_POST['email'],
			'date'=>date("Y-m-d H:i:s"),
			'sort'=>1+$db->max('sort'),
		);
		 
		//错误判读
		if($data['worlds']=='' or $data['www_url']=='' or $data['email']=='') {
			$this->ajaxReturn(0,'请将表单填写完整后提交，如果你禁用了javascript,请开启！',0);        
		}elseif(!$db->add($data)){
	    	$this->ajaxReturn(0,'(⊙o⊙)…服务器开小差了。',0);
	    }else{
	    	$this->ajaxReturn(1,'添加成功！审核通过后会将此链接显示在首页.',1);
	    }
	}
	
	
	
}
?>