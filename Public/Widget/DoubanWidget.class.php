<?php

class DoubanWidget extends Widget {

    public function render($data) {
		$db=new ConfigModel();
		$rs=$db->where("k='widget_douban'")->find();
		if($rs['v']<>1)
			return;

    	$db=new ConfigModel();
    	$rs=$db->where("k='douban_show'")->find();		
		$douban_show=$rs['v'];
		
		if($douban_show==''){
			return;
		}
    	echo "<h2>我的豆瓣</h2>";
		echo "<ul>";
		echo "<li>$douban_show</li>";
		echo "</ul>";

    }

}
?>