<?php
namespace common\report;

use yii\base\Object;

/**
 * 行对象
 *
 * @author niqingyang<niqy@qq.com>
 *        
 */
class Row extends Object
{

	/**
	 * 单元格列表
	 * 
	 * @var array[Cell]
	 */
	public $cells = [];

	public $cell_map = [];

	public function __construct ($config = [])
	{
		parent::__construct($config);
	}
}