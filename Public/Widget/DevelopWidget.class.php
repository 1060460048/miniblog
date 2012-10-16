<?php

class DevelopWidget extends Widget {

    public function render($data) {
		import("ORG.Util.Input");
    	$db=new ConfigModel();
		$rs=$db->where("k='widget_develop'")->find();
		if($rs['v']<>'1')
			return false;
		$limit=$_SESSION['user_login_flag']===true ? 100 : 5;

		$db=new WorldsModel();
		$rs=$db->field('id,text')->limit($limit)->where("last_time<>''")->order('last_time desc')->select();
		if($rs===null || $rs===false)
			return false;
		echo "<h2>站内动态</h2>";
		echo "<ul>";
		foreach($rs as $rs){
			$content=Input::truncate($rs['text'],20);
			$link.="[微博]:“";
			$link.="<a href='";
			$link.=__APP__;
			$link.="/Worlds/view/id/";
			$link.=$rs['id'];
			$link.="'>";
			$link.=$content;
			$link.="</a>";
			echo "<li>".$link."”有新回复</li>";
			unset($link);
		}
		echo "</ul>";
    }
}
?>