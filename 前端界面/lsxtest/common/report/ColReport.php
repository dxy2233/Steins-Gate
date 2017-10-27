<?php
namespace common\report;

use common\helpers\ArrayHelper;

/**
 * 列头报表
 *
 * @author niqingyang<niqy@qq.com>
 *        
 */
class ColReport extends AbstractReport implements Report
{

	/**
	 * 构造函数
	 *
	 * @param array $col_cells
	 *        	行头单元格
	 * @param array $row_cells
	 *        	列头单元格
	 * @param array $mapping
	 *        	映射
	 */
	public function __construct ($col_cells = [], $mapping = null)
	{
		// 预处理
		$col_cells = $this->pretreat($col_cells, $mapping);
		
		// 排序
		$col_cells = $this->sort($col_cells);
		
		// 构造行头列头
		$this->col_head = new ColHead($col_cells);
		
		$this->col_span = $this->col_head->col_span;
		$this->row_span = $this->col_head->row_span;
		
		// 获取列头的最后一行单元格
		$col_head_last_cells = $this->col_head->getLastCells();
		
		$row_head_col_span = 1;
		
		foreach($this->col_head->rows as $i => &$row)
		{
			foreach($row->cells as $j => $cell)
			{
				$cell->row_index = $i + 1;
				
				if($i == 0 && $j == 0)
				{
					$cell->col_index = 1;
					continue;
				}
				
				if($j > 0)
				{
					$before_cell = $row->cells[$j - 1];
					$cell->col_index = $before_cell->col_index + $before_cell->col_span;
				}
				else if($j == 0)
				{
					$parent_cell = $this->col_head->getCell($cell->parent_id);
					if($parent_cell != null)
					{
						$cell->col_index = $parent_cell->col_index;
					}
					else
					{
						$cell->col_index = $row_head_col_span + 1;
					}
				}
			}
		}
		
		$this->rows = ArrayHelper::merge($this->rows, $this->col_head->rows);
	}

	/**
	 * 添加行
	 *
	 * @param unknown $row_number
	 *        	行数
	 */
	public function addRow ($row_number)
	{
		if($row_number >= $this->row_span - $this->col_head->row_span)
		{
			$cell_head_last_cells = $this->col_head->getLastCells();
			
			// 数据行从1开始
			for($i = ($this->row_span - $this->col_head->row_span + 1); $i <= $row_number; $i ++)
			{
				$row = new Row();
				
				for($j = 0; $j < count($cell_head_last_cells); $j ++)
				{
					$item = $cell_head_last_cells[$j];
					
					$cell_id = $this->getDataCellId($i, $item->id);
					
					$cell = new Cell($cell_id, '', $item->id);
					
					$cell->col_index = $j + $cell_head_last_cells[0]->col_span;
					$cell->row_index = $i + $item->row_span;
					
					$cell->type = Report::CELL_TYPE_Data;
					
					$row->cells[] = $cell;
					$this->data_cells[$cell_id] = $cell;
				}
				
				$this->rows[] = $row;
			}
			
			// 累计
			$this->row_span = $row_number + $this->col_head->row_span;
		}
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \common\report\AbstractReport::setCellValue()
	 */
	public function setCellValue ($cell_id, $value)
	{
		$cell_ids = static::parseCellId($cell_id, true);
		
		$this->addRow($cell_ids[0]);
		
		$cell = $this->getDataCell($cell_id);
		if(! empty($cell))
		{
			$cell->value = $value;
		}
		return false;
	}
}
