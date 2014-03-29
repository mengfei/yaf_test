<?php
class RedisIO extends Redis
{
	const TIMEOUT = 0;

	const EXCEPTION_KEY_FORMAT_ERROR = 'the format of the redis key is error.';

	const EXCEPTION_KEY_CONF_NOT_FOUND = 'the config of the redis key is not found.';

	const EXCEPTION_SERV_CONF_NOT_FOUND = 'the config of the redis server is not found.';

	private $redis;

	function __construct($args)
	{
		$this->connect($args);
	}

	function set($key,$value,$time=0){
		$this->redis->set($key,$value);
		return true;
	}

	function checkRouteLock($key,$time = 1000)
	{
		$value = $this->redis->get($key);
		if($value !== false){
			return false;
		}
		$this->redis->setex($key,$time,1);
		return true;
	}


	function connect($args)
	{
		$redis = new redis();
		$result = $redis->connect($args['host'], $args['port'],self::TIMEOUT);
		$redis->select($args['db']);
		$this->redis = $redis;
		return true;
	}

	function __destruct()
	{
		//$this->close();
	}

}

?>