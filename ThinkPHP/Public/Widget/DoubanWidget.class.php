<?php

class DoubanWidget extends Widget {

    public function render($data) {
		$db=new WidgetModel();
		$rs=$db->where("name='douban'")->find();
		if($rs['switch']<>1){
			return false; exit;
		}

    	$db=new ConfigModel();
    	$rs=$db->where("k='douban_fm'")->find();
		if($rs===null || $rs===false){
			return false; exit;
		}
		$douban_fm=$rs['v'];
		$rs=$db->where("k='douban_show'")->find();
		if($rs===null || $rs===false){
			return false; exit;
		}
		$douban_show=$rs['v'];
    	echo "<h2>我的豆瓣</h2>";
		echo "<ul>";
		echo $douban_fm=='' ? '':"<li>$douban_fm</li>";
		echo "</ul>";

    }

}
?>