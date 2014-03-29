<?php
class ChatController extends Yaf_Controller_Abstract
{
	public function indexAction()
	{

		$msg = $_GET['msg'];
		$fp = stream_socket_client("tcp://127.0.0.1:9501", $errno, $errstr, 30);
		if (!$fp) {
		    exit("$errstr ($errno)<br />\n");
		}
		fwrite($fp, "HELLO world");

		swoole_event_add($fp, function($fp){
			echo fgets($fp, 1024);
			swoole_event_del($fp);
		    fclose($fp);
		});

		echo "start\n";
	}
}

?>