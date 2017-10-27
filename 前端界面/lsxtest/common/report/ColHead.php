<?php
namespace common\report;

use common\helpers\ArrayHelper;

/**
 * 列头对象
 *
 * @author niqingyang<niqy@qq.com>
 * @property array[Cell] $cells
 * @property array[Cell] $cell_map
 */
class ColHead extends AbstractHead
{

	/**
	 *
	 * @param array[Cell] $cells        	
	 * @throws \Exception
	 */
	public function __construct ($cells = [])
	{
		$parent_ids = [];
		
		$cell_map = ArrayHelper::map($cells, 'id');
		
		$parent_map = ArrayHelper::map($cells, 'parent_id');
		
		// 设置单元格是否有子节点，设置总的跨行数
		foreach($cells as $cell)
		{
			if($cell->level == 0)
			{
				throw new \Exception("Cell[ID:" . $cell->id . "]的Level属性未设置！");
			}
			else if($cell->level > $this->row_span)
			{
				$this->row_span = $cell->level;
			}
			
			if(isset($parent_map[$cell->id]) && ! empty($parent_map[$cell->id]))
			{
				$cell->is_parent = 1;
			}
			else
			{
				$cell->is_parent = 0;
			}
		}
		
		// 设置单元格是否有子节点，设置总的跨行数
		foreach($cells as $i => $cell)
		{
			if(isset($parent_map[$cell->id]))
			{
				$cells[$i]->is_parent = 1;
			}
			else
			{
				$this->col_span ++;
			}
		}
		
		// 获取每个单元格的跨列数目
		foreach($cells as $cell)
		{
			$row_span = 0;
			
			$col_span = $this->getCellColSpan($cell->id, $cells, $cell_map);
			
			if($col_span == 0)
			{
				$col_span = 1;
			}
			
			// 父节点为1行
			if($cell->is_parent)
			{
				$row_span = 1;
			}
			else
			{
				$row_span = $this->row_span - $cell->level + 1;
			}
			
			$cell->col_span = $col_span;
			$cell->row_span = $row_span;
		}
		
		// 创建Tr并初始化
		for($i = 0; $i < $this->row_span; $i ++)
		{
			$row = new Row();
			$this->rows[] = $row;
		}
		
		// 分配单元格到对应的行内
		foreach($cells as $cell)
		{
			$cell->type = Report::CELL_TYPE_ColHead;
			$this->rows[$cell->level - 1]->cells[] = $cell;
		}
	}
}