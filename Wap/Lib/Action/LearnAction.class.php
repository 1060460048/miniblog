<?php
class LearnAction extends Action{
	public function index(){
		echo "<meta content='text/html'; charset=utf-8 />";	
		$db=new IpModel();
		$data['ip']=$this->getIp();
		if($db->add($data)){
			echo "( ^_^ )你好，额是机器人程序，额需要获取你的手机IP来判断你使用的手机还是电脑！，非常感谢你为我提供了一条IP地址：".$data['ip']."<p>下次你访问t-y.me的时候我会将你引导至手机版页面，不信你<a href='http://t-y.me'>点这里试试看</a>";
			//dump($db->select());
		}else{
			echo "( ^_^ ) 呵呵，额是机器人程序，我已经记住你了！下次你访问t-y.me的时候我会将你引导至手机版页面，不信你<a href='http://t-y.me'>点这里试试看</a>";
			//dump($db->select());
		}
	}	
	
	protected function getIp()	{
		$ip=$_SESSION['user_ip'];
		if($ip<>'')
		  return $ip;
		else
		//php获取ip的算法
		if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])
		{
		$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
		}
		elseif ($HTTP_SERVER_VARS["HTTP_CLIENT_IP"])
		{
		$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
		}
		elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"])
		{
		$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
		}
		elseif (getenv("HTTP_X_FORWARDED_FOR"))
		{
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		}
		elseif (getenv("HTTP_CLIENT_IP"))
		{
		$ip = getenv("HTTP_CLIENT_IP");
		}
		elseif (getenv("REMOTE_ADDR"))
		{
		$ip = getenv("REMOTE_ADDR");
		}
		else
		{
		$ip = "Unknown";
		}
		$_SESSION['user_ip']=$ip;
		return $ip ;
	}
	
}

?>