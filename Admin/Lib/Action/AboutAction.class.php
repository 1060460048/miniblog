<?php 
class AboutAction extends BaseAction{
	
	public function index(){
		$rs=$this->getConfig('about')+$this->getConfig('about_text');
		$this->assign('rs',$rs);	
		$this->display("Index:about");
	}
	
	public function edit(){
		$rs=$this->getConfig('about')+$this->getConfig('about_text');
		$this->assign('rs',$rs);
		$this->display('Index:ediAbout');
	}
	
	public function save(){
	//dump($_POST);exit;
		if($_POST['about']=='' and $_POST['about_text']==''){
			$this->error('签名或者内容不能为空！');
		}		
		$db=new ConfigModel();
		import('ORG.Util.Input');
		if(!$db->autoCheckToken($_POST)){
			$this->error('非法提交！');
		}
		unset($_POST['Submit']);unset($_POST['__hash__']);
		foreach($_POST as $k=>$v){
			$map['k']=$k;
			$data['v']=str_replace('\\','',str_replace("&quot;",'',$v));
			$db->where($map)->save($data);
			unset($map);unset($data);
		}
		$this->redirect('About/index');
	}
}
?>