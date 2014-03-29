<?php
class HookPlugin extends Yaf_Plugin_Abstract
{
	//'class'=>array('action'),
	private $filter = array(
			'index'=>array('index'=>false),
			'welcome'=>array('index'=>false),
			'chat'=>array('index'=>true),
	);

	function setRouteLock(Yaf_Request_Abstract $request)
	{
		$Mid = "111111";
		$controller = strtolower($request->getControllerName());
		$action = strtolower($request->getActionName());
		if(isset($this->filter[$controller])){
			if(isset($this->filter[$controller][$action]) && $this->filter[$controller][$action]){
				return true;
			}
		}

		$config = new Yaf_Config_Ini(APP_PATH.'/conf/redis_config.ini', 'redis');
		$redisobj = new RedisIo($config->redis->get("server1"));
		$key = $Mid."|".$controller."|".$action;
		$request_flag = $redisobj->checkRouteLock($key);
		if($request_flag){
			return true;
		}
		return false;
	}

}
?>