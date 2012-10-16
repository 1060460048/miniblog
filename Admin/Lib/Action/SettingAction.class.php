<?php
class SettingAction extends BaseAction{
	public function index(){
		$db=new ConfigModel();
		if ($db->autoCheckToken($_POST)){
			$this->save();
		}		
		$this->assign('rs',$this->getConfig('all'));
		$this->display('Index:setting');	
	}
	
	public function sync(){
		$db=new ConfigModel();
		if ($db->autoCheckToken($_POST)){
			$this->save();
		}		
		$this->assign('rs',$this->getConfig('all'));
		$this->display('Index:sync');	
	}
	
	public function cache(){
		if(isset($_POST['Submit']))
			$this->_cache();
		//计算前台缓存文件数
		$i=0;
		$d=dir('Home/Runtime/Cache/');
		while($file=$d->read()){
			if($file<>'.' and $file<>'..')
				$i++;
		}
		$rs['home']=$i;
		
		//计算后台缓存文件数
		$i=0;
		$d=dir('Admin/Runtime/Cache/');
			while($file=$d->read()){
			if($file<>'.' and $file<>'..')
				$i++;
		}
		$rs['admin']=$i;
		//计算手机版缓存文件数
		$i=0;
		$d=dir('Wap/Runtime/Cache/');
		while($file=$d->read()){
		if($file<>'.' and $file<>'..')
			$i++;
		}
		$rs['wap']=$i;
		$this->assign('rs',$rs);
		$this->display('Index:cache');
		
	}
	
	protected function _cache(){
		if($_POST['home']=='1'){
			$this->clearnCache('Home');
		}
		if($_POST['admin']=='1'){
			$this->clearnCache('Admin');
		}
		if($_POST['wap']=='1'){
			$this->clearnCache('Wap');
		}
	}
	
	public function information(){
		$db=new ConfigModel();
		if ($db->autoCheckToken($_POST)){
			$this->save();
		}		
		$this->assign('rs',$this->getConfig('all'));
		$this->display('Index:information');			
	}
	
	public function clearnCache($name){
		$path="$name/Runtime/Cache/";
		$d=dir($path);
		while($file=$d->read()){
			unlink($path.$file);
		}
	}
	
	protected function save(){
		//dump($_POST);exit;
		$db=new ConfigModel();
		if (!$db->autoCheckToken($_POST)){
			$this->error('非法提交！');
		}
		unset($_POST['Submit']);
		unset($_POST['__hash__']);
		foreach($_POST as $k=>$v){
			$map['k']=$k;
			$data['v']=str_replace('\\','',str_replace("&quot;",'',$v));
			$db->where($map)->save($data);
			unset($map);unset($data);
		}
		//$this->redirect('Setting/index');

	}
}
?>