<?php
namespace common\report;

use yii\base\Object;

/**
 * 单元格对象
 *
 * @author niqingyang<niqy@qq.com>
 *        
 */
class Cell extends Object
{

	public $id;

	public $name;

	public $parent_id;

	public $level = 0;

	public $sort;

	public $row_span = 1;

	public $col_span = 1;

	public $is_parent = 0;

	/**
	 * 列索引，从1开始
	 */
	public $col_index;

	/**
	 * 行索引，从1开始
	 */
	public $row_index;

	public $type = Report::CELL_TYPE_Data;

	/**
	 * 数据单元格值
	 */
	public $value;

	/**
	 * 单元格存储的数据
	 */
	public $data = [];

	public function __construct ($id, $value, $parent_id = 0)
	{
		if(empty($parent_id))
		{
			$parent_id = 0;
		}
		
		parent::__construct([
			'id' => strval($id), 
			'value' => strval($value), 
			'parent_id' => strval($parent_id)
		]);
	}

	public static function create ($id, $value, $parent_id = 0)
	{
		return new Cell($id, $value, $parent_id);
	}

	/**
	 * 获取单元格编号
	 *
	 * @param string $row_head_id        	
	 * @param string $col_head_id        	
	 * @return string
	 */
	public static function toId ($row_head_id, $col_head_id)
	{
		return $row_head_id . Report::ID_Separator . $col_head_id;
	}
}