<?php
$fp = stream_socket_client("tcp://127.0.0.1:9502", $errno, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT);
if(!$fp){
	echo "$errstr ($errno) <br />\n";
}else{
	$header = "GET / HTTP/1.1\r\nHost:localhost\r\nAccept: */*\r\n\r\n";
	$len = strlen($header);
	fwrite($fp,$header);
	echo stream_get_contents($fp);
	fclose($fp);
}





?>