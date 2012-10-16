<?php
/*
 * Created on 2010-11-21
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 function showIp($ip){
 	$ip=explode('.',$ip);
 	return "*.*.".$ip['2'].'.'.$ip['3'];
 }
?>
