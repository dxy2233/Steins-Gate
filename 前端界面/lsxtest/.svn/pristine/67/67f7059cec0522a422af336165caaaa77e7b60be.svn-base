<?php
namespace common;

class AppParams
{

	/**
	 * 判断是否存在
	 *
	 * @param unknown $name        	
	 */
	public static function exists ($name)
	{
		return isset(\Yii::$app->params[$name]);
	}

	/**
	 * 获取值
	 *
	 * @param string $name
	 *        	支持通过“.”操作符获取值
	 * @param mixed $default_value        	
	 * @return mixed
	 */
	public static function get ($name = null, $default_value = null)
	{
		$params = \Yii::$app->params;
		
		if(is_null($name))
		{
			return $params;
		}
		
		$names = explode('.', $name);
		
		foreach($names as $name)
		{
			if(isset($params[$name]))
			{
				$params = $params[$name];
			}
			else
			{
				return $default_value;
			}
		}
		
		if($params instanceof \Closure)
		{
			return call_user_func($params);
		}
		
		return $params;
	}

	/**
	 * 设置值
	 *
	 * @param string $name        	
	 * @param mixed $value        	
	 */
	public static function set ($name, $value)
	{
		\Yii::$app->params[$name] = $value;
	}
}