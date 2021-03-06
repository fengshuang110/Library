<?php
namespace  Library\Cache\Adapter;
use  Library\Cache\CacheAbstract;
use  Library\Cache\CacheInterface;
/**
 * 
 * @author fengshuang
 * 2015/6/1
 * UTF-8
 */
class StringRedisAdapter extends CacheAbstract implements CacheInterface {
	private $redis = null;
	
	function __construct($cache_config) {
		$this->redis = new \Redis();
		$this->redis->connect($cache_config['host'], $cache_config['port']);
	}
	
	public function set($key, $value, $expire=600) {
		$obj = '';
		if (is_array ( $value )) {
			$obj = json_encode ( $value );
		} else if (is_string ( $obj )) {
			$obj = $value;
		} else {
			throw new Exception ( 'Value must be a string or array.' );
		}
		return $this->redis->setex($key,$expire,$obj);
	}
	
	
	public function get($key) {
		$result = $this->redis->get($key);
		$res = json_decode($result,true);
		if(empty($result)||empty($res)){
			return $result;
		}
		
		return $res;
	}

	public function delete($key){
		$result = $this->redis->delete($key);
		return $result;
	}
}