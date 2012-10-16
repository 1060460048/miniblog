<?php

class DevelopWidget extends Widget {

    public function render($data) {
		import("ORG.Util.Input");
    	$db=new WidgetModel();
		$rs=$db->where("name='develop'")->find();
		if($rs['switch']<>1){
			return false;exit;
		}

		$db=new WorldsModel();
		$rs=$db->field('id,text')->limit(5)->where("last_time<>''")->order('last_time desc')->select();
		//dump($rs);
		if($rs===null || $rs===false){
			return false;exit;
		}
		
		echo "<h2>最新动态</h2>";
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