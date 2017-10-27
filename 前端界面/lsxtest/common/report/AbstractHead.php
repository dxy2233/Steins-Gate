<?php
namespace common\report;

use yii\base\Object;

/**
 * 行头、列头基类
 * 
 * @author niqingyang<niqy@qq.com>
 *        
 */
class AbstractHead extends Object
{
	
	// 跨行
	public $row_span = 0;
	// 跨列
	public $col_span = 0;

	/**
	 * 列头所包含的行列表
	 *
	 * @var array[Row]
	 */
	public $rows = [];

	/**
	 * 根据所有的节点获取单元格的跨列数
	 *
	 * @param string $cell_id        	
	 * @param array[Cell] $cells        	
	 * @param array[Cell] $cell_map        	
	 * @return int
	 */
	public function getCellColSpan ($cell_id, $cells, $cell_map)
	{
		$count = 0;
		
		foreach($cells as $cell)
		{
			if(! $cell instanceof Cell)
			{
				continue;
			}
			
			if($cell->parent_id === $cell_id)
			{
				if($cell_map[$cell->id]->is_parent)
				{
					$count += $this->getCellColSpan($cell->id, $cells, $cell_map);
				}
				else
				{
					$count ++;
				}
			}
		}
		
		return $count;
	}

	/**
	 * 获取所有没有子节点的节点 遍历每一列，再遍历每一行，从中找到最后一个单元格，即没有子节点的节点
	 *
	 * @return array[Cell]
	 *
	 */
	public function getLastCells ()
	{
		$cells = [];
		
		foreach($this->rows as $row)
		{
			foreach($row->cells as $cell)
			{
				if($cell->is_parent == 0 && $cell->type != Report::CELL_TYPE_Data)
				{
					$cells[] = $cell;
				}
			}
		}
		
		return $cells;
	}

	/**
	 * 获取单元格
	 *
	 * @param string $id        	
	 * @return \common\report\Cell|NULL
	 */
	public function getCell ($id)
	{
		foreach($this->rows as $row)
		{
			
			foreach($row->cells as $cell)
			{
				if($cell->id == $id)
				{
					return $cell;
				}
			}
		}
		
		return null;
	}
}