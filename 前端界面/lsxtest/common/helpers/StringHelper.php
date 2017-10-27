<?php
namespace common\helpers;

use Yii;
use yii\helpers\BaseStringHelper;


/**
 * 68Shop 字符串操作工具类
 *
 *
 *
 * ============================================================================
 * 版权所有 2008-2015 秦皇岛商之翼网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.68ecshop.com
 * ----------------------------------------------------------------------------
 * 这是一个免费开源的软件；这意味着您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * ============================================================================
 *
 * @author niqingyang
 * @version 1.0
 */
class StringHelper extends BaseStringHelper
{

	/**
	 * 格式化字符串
	 *
	 * @param string $format        	
	 * @param mix $args        	
	 * @param unknown $_        	
	 */
	public static function format ($format, $args = null, $_ = null)
	{
		return sprintf($format, $args, $_);
	}

	/**
	 * 求Hash值
	 *
	 * @param unknown $string        	
	 * @return string
	 */
	public static function hash ($string)
	{
		return sprintf('%x', crc32($string . Yii::getVersion()));
	}

	/**
	 * 生成指定长度的随机字符或数字
	 *
	 * @param number $len        	
	 * @param string $format
	 *        	string-字符、number-数字、其他-字符+数字
	 */
	public static function random ($len = 8, $format = 'all')
	{
		$is_abc = $is_numer = 0;
		$string = $tmp = '';
		switch($format)
		{
			case 'string':
				$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
				break;
			case 'number':
				$chars = '0123456789';
				break;
			default:
				$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
				break;
		}
		mt_srand();
		while(strlen($string) < $len)
		{
			$tmp = substr($chars, (mt_rand() % strlen($chars)), 1);
			if(($is_numer != 1 && is_numeric($tmp) && $tmp > 0) || $format == 'string')
			{
				$is_numer = 1;
			}
			if(($is_abc != 1 && preg_match('/[a-zA-Z]/', $tmp)) || $format == 'number')
			{
				$is_abc = 1;
			}
			$string .= $tmp;
		}
		if($is_numer != 1 || $is_abc != 1 || empty($string))
		{
			$string = static::random($len, $format);
		}
		return $string;
	}

	/**
	 * 字符串长度
	 *
	 * @param string $string
	 *        	字符串
	 * @param string $encoding        	
	 */
	public static function length ($string, $encoding = "UTF-8")
	{
		return mb_strlen($string, $encoding ?: Yii::$app->charset);
	}

	/**
	 * 将classname按照大写字母进行拆分按照指定的符合进行拼接，并去掉指定的结尾单词，例如：SystemConfigController转换为system-config
	 *
	 * @param unknown $class_name
	 *        	类名
	 * @param array $ends
	 *        	需要去掉的结尾单词，默认为：model，controller
	 * @param array $needle
	 *        	拼接符号，默认为“-”
	 * @return string
	 */
	public static function explodeClassName ($class_name, $ends = ['model', 'controller'], $needle = '-')
	{
		// 用字符串/分割成数组
		$class_array = explode('\\', $class_name);
		// 获取类名
		$class_name = $class_array[count($class_array) - 1];
		// 将类名通过大写字母进行分割，然后通过“-”进行连接，并去掉首尾的“-”
		$file_name = trim(implode('-', preg_split("/(?=[A-Z])/", trim($class_name))), $needle);
		// 将类名转换成小写
		$file_name = strtolower($file_name);
		// 如果类名以controller结尾则去掉controller
		
		foreach($ends as $key => $value)
		{
			if(StringHelper::endsWith($file_name, '-' . $value))
			{
				$file_name = substr($file_name, 0, - strlen('-' . $value));
				break;
			}
		}
		
		return $file_name;
	}

	/**
	 * 构建Key
	 *
	 * @param unknown $key        	
	 * @return string|unknown
	 */
	public static function buildKey ($key, $prefix = '')
	{
		if(is_string($key))
		{
			$key = ctype_alnum($key) && StringHelper::byteLength($key) <= 32 ? $key : md5($key);
		}
		else
		{
			$key = md5(json_encode($key));
		}
		return $prefix . $key;
	}

	/**
	 * 得到hash值
	 *
	 * @param
	 *        	mixed 比对的内容
	 *        	
	 */
	public static function hashArrayToStr ($param)
	{
		$res = [];
		if(is_array($param))
		{
			foreach($param as $val)
			{
				if(is_array($val))
				{
					return self::hashArrayToStr($val);
				}
				else
				{
					$res[] = $val;
				}
			}
		}
		else if(is_string($param))
		{
			$res[] = $param;
		}
		else
		{
			return false;
		}
		return implode(',', $res);
	}

	public static function getHashCode ($param)
	{
		return hash('md5', base64_encode(self::hashArrayToStr($param)));
	}
}