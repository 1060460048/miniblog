<?php

class LinkWidget extends Widget {

    function render($data) {
		$db=new ConfigModel();
		$rs=$db->where("k='widget_link'")->find();
		if($rs['v']<>'1')
			return false;

		$db=new LinksModel();
		$all=$db->where("pass_flag=1")->select();
		//dump($all);
		if($all===null || $all===false)
			return false;
		if(count($all)<5){
			echo "<h2>友情链接</h2>";
			echo "<ul>";		
			foreach($all as $all){
				echo "<li><a href='".$all['www_url']."' target='_blank'>".$all['worlds']."</a></li>";
			}
			echo "</ul>";
			return ;
		}
		//随即抽取5条记录
		$array=array_rand($all,5);
		//dump($array);
		echo "<h2>友情链接</h2>";
		echo "<ul>";
		foreach($array as $id){
			echo "<li><a href='".$all[$id]['www_url']."' target='_blank'>".$all[$id]['worlds']."</a></li>";
		}
		echo "</ul>";
    }
}
?>