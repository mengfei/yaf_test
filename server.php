<?php
$serv = new swoole_server("127.0.0.1", 9502);
$serv->set(array('worker_num' => 4));
$serv->on('timer', function($serv, $interval) {
    echo "onTimer: $interval\n";
});
$serv->on('workerStart', function($serv, $worker_id) {
    //if($worker_id == 0) $serv->addtimer(600);
});
$serv->on('connect', function ($serv, $fd){

    //echo "[#".posix_getpid()."]\tClient:Connect.\n";
});
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
	$start_fd = 0;
	$stime = time();
	/*$data = json_decode($data,true);
	switch($data['cmd']){
		case "login":
			$serv->send($fd, "welcome !");
			break;
	}*/
	while(true)
	{
	    $conn_list = $serv->connection_list($start_fd, 30);
	    if($conn_list===false)
	    {
	        //echo "finish\n";
	        break;
	    }
	    //var_dump($conn_list);
	    $start_fd = end($conn_list);
	    //var_dump($conn_list);
	    foreach($conn_list as $fdv)
	    {
	    	if($fdv == $fd){
	    		continue;
	    	}
	    	var_dump($fdv);
	        $serv->send($fdv, "broadcast");
	    }
	}
    //echo "[#".posix_getpid()."]\tClient[$fd]: $data\n";
    //$serv->send($fd, "swoole: $data");
    $etime = time();
    echo $etime - $stime;
    //$serv->close($fd);
});
$serv->on('close', function ($serv, $fd) {
    //echo "[#".posix_getpid()."]\tClient: Close.\n";
});

$serv->start();
?>