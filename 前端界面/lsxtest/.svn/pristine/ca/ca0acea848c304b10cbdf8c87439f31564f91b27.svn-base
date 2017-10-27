<?php
namespace common\helpers;

use yii\helpers\BaseArrayHelper;

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
class ArrayHelper extends BaseArrayHelper
{

	/**
	 * 序列化数组前处理，unset掉所有Closure类型的数据
	 *
	 * @param unknown $target        	
	 */
	public static function doBeforeSerialize (&$target)
	{
		foreach($target as $key => $value)
		{
			if(is_array($value))
			{
				static::doBeforeSerialize($value);
			}
			else if($value instanceof \Closure)
			{
				unset($target[$key]);
			}
		}
	}

	/**
	 * 从某个数组中排除指定的元素或者数组
	 *
	 * @param mix $needle
	 *        	如果为数组则会遍历$array然后排除掉$needle中所有元素获取到一个新的数组
	 * @param array $array
	 *        	目标数组
	 * @param
	 *        	新数组
	 */
	public static function exceptInArray ($needle, $array)
	{
		$result = [];
		if(is_array($needle))
		{
			foreach($array as $key => $value)
			{
				if(in_array($value, $needle))
				{
					continue;
				}
				$result[] = $value;
			}
		}
		else
		{
			foreach($array as $key => $value)
			{
				if($needle == $value)
				{
					continue;
				}
				$result[] = $value;
			}
		}
		return $result;
	}

	/**
	 * app重写toArray方法
	 *
	 * @param unknown $object        	
	 * @param unknown $properties        	
	 * @param string $recursive        	
	 */
	public static function toAppArray ($object, $properties = [], $recursive = true)
	{
		if(is_array($object))
		{
			if(empty($object))
			{
				return null;
			}
			if($recursive)
			{
				foreach($object as $key => $value)
				{
					if(is_array($value) || is_object($value))
					{
						$object[$key] = static::toAppArray($value, $properties, true);
					}
				}
			}
			return $object;
		}
		elseif(is_object($object))
		{
			if(! empty($properties))
			{
				$className = get_class($object);
				if(! empty($properties[$className]))
				{
					$result = [];
					foreach($properties[$className] as $key => $name)
					{
						if(is_int($key))
						{
							$result[$name] = $object->$name;
						}
						else
						{
							$result[$key] = static::getValue($object, $name);
						}
					}
					
					return $recursive ? static::toAppArray($result, $properties) : $result;
				}
			}
			if($object instanceof Arrayable)
			{
				$result = $object->toAppArray();
			}
			else
			{
				$result = [];
				foreach($object as $key => $value)
				{
					$result[$key] = $value;
				}
			}
			
			return $recursive ? static::toAppArray($result) : $result;
		}
		else
		{
			return [
				$object
			];
		}
	}

	/**
	 * 二维数组合并为一维数组，相同key值时相加，针对数值类型数据
	 *
	 * @param array $array        	
	 * @return unknown[]
	 */
	public static function sumArray ($array = [])
	{
		if(empty($array) || ! is_array($array))
		{
			return [];
		}
		
		$array_keys = array_keys($array[0]);
		$new_array = [];
		
		foreach($array as $info)
		{
			foreach($array_keys as $key)
			{
				$new_array[$key] += $info[$key];
			}
		}
		
		return $new_array;
	}

	/**
	 * 分组
	 *
	 * @param array $array        	
	 * @param string|array $key        	
	 */
	public static function group ($array, $key, $to = null)
	{
		$result = [];
		foreach($array as $element)
		{
			if(empty($to))
			{
				$value = $element;
			}
			else
			{
				$value = static::getValue($element, $to);
			}
			
			$index = static::getValue($element, $key);
			
			$result[$index][] = $value;
		}
		
		return $result;
	}

	/**
	 * 数组重新排序，把数组中某一个值提到数组第一元素位置
	 *
	 * @param array $array        	
	 * @param string $val        	
	 * @param string $key        	
	 */
	public static function oneShiftArray ($array = [], $val = '', $key = '')
	{
		if(! empty($key))
		{
			$val = $array[$key];
		}
		
		foreach($array as $array_key => $info)
		{
			if($array_key == $key)
			{
				$default[$array_key] = $info;
			}
			else
			{
				$other[$array_key] = $info;
			}
		}
		
		$result = array_merge($default, $other);
		
		return $result;
	}

	/**
	 * 数组去除重复元素值，继承PHP的array_unique()
	 *
	 * @param array $array        	
	 */
	public static function arrayUnique ($array = [])
	{
		return array_unique($array);
	}

	/**
	 * XML转化成数组
	 *
	 * @param
	 *        	$xml
	 */
	public static function xmlToArray ($xml)
	{
		// 将XML转为array
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	/**
	 * 数组转化成XML
	 *
	 * @param array $arr        	
	 * @return xml
	 */
	public static function arrayToXml ($arr)
	{
		$xml = "<xml>";
		foreach($arr as $key => $val)
		{
			if(is_numeric($val))
			{
				$xml .= "<" . $key . ">" . $val . "</" . $key . ">";
			}
			else
				$xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
		}
		$xml .= "</xml>";
		return $xml;
	}

	public static function deleteKey ($array = [], $level = 1, $type = "all")
	{
		if(empty($array))
		{
			return [];
		}
		
		if($level == "all")
		{
			$this_level = "all";
		}
		else
		{
			$this_level = $level - 1;
		}
		
		$result = [];
		foreach($array as $key => $info)
		{
			if(is_array($info) && ($this_level > 0 || $this_level == "all"))
			{
				$info = static::deleteKey($info, $this_level, $type);
			}
			
			if(! is_numeric($key) && $type == "numeric")
			{
				$result[$key] = $info;
			}
			else
			{
				$result[] = $info;
			}
		}
		
		return $result;
	}

	/**
	 * Builds a map (key-value pairs) from a multidimensional array or an array of objects.
	 * The `$from` and `$to` parameters specify the key names or property names to set up the map.
	 * Optionally, one can further group the map according to a grouping field `$group`.
	 *
	 * For example,
	 *
	 * ~~~
	 * $array = [
	 * ['id' => '123', 'name' => 'aaa', 'class' => 'x'],
	 * ['id' => '124', 'name' => 'bbb', 'class' => 'x'],
	 * ['id' => '345', 'name' => 'ccc', 'class' => 'y'],
	 * ];
	 *
	 * $result = ArrayHelper::map($array, 'id', 'name');
	 * // the result is:
	 * // [
	 * // '123' => 'aaa',
	 * // '124' => 'bbb',
	 * // '345' => 'ccc',
	 * // ]
	 *
	 * $result = ArrayHelper::map($array, 'id', 'name', 'class');
	 * // the result is:
	 * // [
	 * // 'x' => [
	 * // '123' => 'aaa',
	 * // '124' => 'bbb',
	 * // ],
	 * // 'y' => [
	 * // '345' => 'ccc',
	 * // ],
	 * // ]
	 * ~~~
	 *
	 * @param array $array        	
	 * @param string|\Closure $from        	
	 * @param string|\Closure $to        	
	 * @param string|\Closure $group        	
	 * @return array
	 */
	public static function map ($array, $from, $to = null, $group = null)
	{
		$result = [];
		foreach($array as $element)
		{
			$key = static::getValue($element, $from);
			
			if($to == null)
			{
				$value = $element;
			}
			else
			{
				$value = static::getValue($element, $to);
			}
			
			if($group !== null)
			{
				$result[static::getValue($element, $group)][$key] = $value;
			}
			else
			{
				$result[$key] = $value;
			}
		}
		
		return $result;
	}

	/**
	 * 二维数组根据某个字段排序
	 *
	 * @param array $array        	
	 * @param string $field        	
	 * @param string $sort        	
	 */
	public static function arrSort (&$array, $field, $sort = 'SORT_ASC')
	{
		if(empty($array))
		{
			return;
		}
		$sort = array(
			'direction' => $sort, 
			'field' => $field
		);
		$arr_sort = array();
		foreach($array as $uniqid => $row)
		{
			foreach($row as $key => $value)
			{
				$arr_sort[$key][$uniqid] = $value;
			}
		}
		if($sort['direction'])
		{
			array_multisort($arr_sort[$sort['field']], constant($sort['direction']), $array);
		}
	}

	/**
	 * 计算一个数组按指定长度进行拆分能够分成几份的数量
	 *
	 * @param array $list        	
	 * @param integer $number
	 *        	如果number为0返回1
	 * @return int
	 */
	public static function getSplitCount ($array, $number)
	{
		if(empty($array))
		{
			return 0;
		}
		
		// 必须为整数
		$number = intval($number);
		
		if($number == 0)
		{
			return 1;
		}
		
		// 数组的总长度
		$count = count($array);
		
		return intval($count / $number) + $count % $number == 0 ? 0 : 1;
	}

	/**
	 *
	 * 把数组按指定的个数分隔
	 *
	 * @param array $array
	 *        	要分割的数组
	 * @param int $group_num
	 *        	分的组数
	 */
	public static function splitArray ($array, $group_num)
	{
		if(empty($array))
		{
			return [];
		}
		
		// 数组的总长度
		$all_length = count($array);
		
		// 个数
		$group_num = intval($group_num);
		
		// 开始位置
		$start = 0;
		
		// 分成的数组中元素的个数
		$enum = (int)($all_length / $group_num);
		
		// 结果集
		$list = [];
		
		if($enum > 0)
		{
			// 被分数组中 能整除 分成数组中元素个数 的部分
			$first_length = $enum * $group_num;
			$first_array = array();
			for($i = 0; $i < $first_length; $i ++)
			{
				array_push($first_array, $array[$i]);
				unset($array[$i]);
			}
			for($i = 0; $i < $group_num; $i ++)
			{
				
				// 从原数组中的指定开始位置和长度 截取元素放到新的数组中
				$list[] = array_slice($first_array, $start, $enum);
				
				// 开始位置加上累加元素的个数
				$start += $enum;
			}
			// 数组剩余部分分别加到结果集的前几项中
			$second_length = $all_length - $first_length;
			for($i = 0; $i < $second_length; $i ++)
			{
				array_push($list[$i], $array[$i + $first_length]);
			}
		}
		else
		{
			for($i = 0; $i < $all_length; $i ++)
			{
				$list[] = array_slice($array, $i, 1);
			}
		}
		return $list;
	}

	/**
	 * 求所有数组的笛卡尔积
	 *
	 * @param unknown_type $data        	
	 */
	public static function toDkezj ($data)
	{
		if(empty($data))
		{
			return [];
		}
		
		$result = [];
		
		foreach($data[0] as $item)
		{
			$result[] = [
				$item
			];
		}
		
		for($i = 1; $i < count($data); $i ++)
		{
			$temp_result = [];
			foreach($result as $item1)
			{
				foreach($data[$i] as $item2)
				{
					$temp = $item1;
					$temp[] = $item2;
					$temp_result[] = $temp;
				}
			}
			$result = $temp_result;
		}
		
		return $result;
	}
    public static function user_order_keyid($list){
        foreach($list as $key=>$val){
            $list[$val['record_id']] = $val;
        }
        return $list;
    }
    public static function back_order_keyid($list){
         foreach($list as $key=>$val){
            $list[$val['return_id']] = $val;
        }
        return $list;
    }
}