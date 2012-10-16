<?php
/*
 * Created on 2010-11-21
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 function isWap($value){

 	if ($value == 0){
		return '电脑';
	}elseif($value == 1){
		return '手机';
	}else{
		return '机器人';
	}
 }
?>
