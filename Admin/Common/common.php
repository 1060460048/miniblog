<?php
import('ORG.Util.Input');
include("Public/Function/howLong.php");
include("Public/Function/isWap.php");
include("Public/Function/showIp.php");
include("Public/Function/wapUrl.php");
function deleteHtmlTags($text){
	return Input::deleteHtmlTags($text);
}

?>