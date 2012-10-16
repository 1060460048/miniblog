<?php

class LinkWidget extends Widget {

    function render($data) {
		$db=new WidgetModel();
		$rs=$db->where("name='link'")->find();
		if($rs['switch']<>1){
			return false;
		}

		$db=new LinksModel();
		$rs=$db->where("pass_flag=1")->limit(5)->select();
		//dump($rs);
		if($rs===null || $rs===false){
			return false; exit;
		}
		echo "<h2>友情链接</h2>";
		echo "<ul>";
		foreach($rs as $rs){
			echo "<li><a href='".$rs['www_url']."'>".$rs['worlds']."</a></li>";
		}
		echo "</ul>";
    }
}
?>