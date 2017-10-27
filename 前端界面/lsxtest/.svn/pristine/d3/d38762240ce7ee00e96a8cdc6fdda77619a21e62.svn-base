<?php
namespace common\report;

use common\helpers\ArrayHelper;
use yii\base\Object;

/**
 * 报表基类
 * 
 * @author niqingyang<niqy@qq.com>
 *        
 */
class AbstractReport extends Object
{

	/**
	 * 标题
	 */
	protected $title;

	/**
	 * 单元格默认值
	 */
	protected $cell_default_value = '';

	/**
	 * 表格的总列数
	 */
	protected $col_span;

	/**
	 * 表格的总行数
	 */
	protected $row_span;

	/**
	 * 列头
	 *
	 * @var ColHead
	 */
	protected $col_head;

	/**
	 * 行头
	 *
	 * @var RowHead
	 */
	protected $row_head;

	/**
	 * 行列表
	 *
	 * @var array[Row]
	 */
	protected $rows = [];

	/**
	 * 数据单元格集合
	 *
	 * @var array[Cell]
	 */
	protected $data_cells = [];

	public function getColSpan ()
	{
		return $this->col_span;
	}

	public function getRowSpan ()
	{
		return $this->row_span;
	}

	/**
	 *
	 * @return \common\report\Row[]
	 */
	public function getRows ()
	{
		return $this->rows;
	}

	/**
	 * 预处理单元格列表，将数组转换为Cell对象
	 *
	 * @param array $cells        	
	 * @param array $mapping        	
	 * @return \common\report\Cell
	 */
	public function pretreat ($cells = [], $mapping = [])
	{
		$id_key = ! empty($mapping[Report::ID_KEY]) ? $mapping[Report::ID_KEY] : Report::ID_KEY;
		$name_key = ! empty($mapping[Report::NAME_KEY]) ? $mapping[Report::NAME_KEY] : Report::NAME_KEY;
		$parent_id_key = ! empty($mapping[Report::PARENT_ID_KEY]) ? $mapping[Report::PARENT_ID_KEY] : Report::PARENT_ID_KEY;
		
		foreach($cells as $i => $item)
		{
			if($item instanceof Cell)
			{
				continue;
			}
			$cells[$i] = new Cell($item[$id_key], $item[$name_key], $item[$parent_id_key]);
		}
		
		return $cells;
	}

	/**
	 * 根据单元格的父节点自动排序，并自动自己算单元格的Level属性
	 *
	 * @param array[Cell] $cells        	
	 */
	public function sort ($cells)
	{
		$cell_map = ArrayHelper::group($cells, 'parent_id');
		$cell_ids = ArrayHelper::getColumn($cells, 'id');
		
		$first_level_cells = [];
		
		foreach($cells as $cell)
		{
			if(! in_array($cell->parent_id, $cell_ids, true))
			{
				$first_level_cells[] = $cell;
			}
		}
		
		return $this->iteration($cell_map, $first_level_cells);
	}

	/**
	 * 递归
	 *
	 * @param array[Cell] $cell_map        	
	 * @param array[Cell] $cells        	
	 * @param integer $level        	
	 */
	private function iteration ($cell_map, $cells, $level = 1)
	{
		$list = [];
		
		if(empty($cells))
		{
			return $list;
		}
		
		foreach($cells as &$cell)
		{
			$id = $cell->id;
			$parent_id = $cell->parent_id;
			
			$cell->level = $level;
			
			$list[] = $cell;
			
			if(isset($cell_map[$id]))
			{
				$list = ArrayHelper::merge($list, $this->iteration($cell_map, $cell_map[$id], $level + 1));
			}
		}
		
		return $list;
	}

	/**
	 * 设置报表的标题，用于导出生成文件的名称
	 *
	 * @param string $title        	
	 */
	public function setTitle ($title)
	{
		$this->title = $title;
	}

	/**
	 * 设置报表数据单元格默认值
	 *
	 * @param string $value        	
	 */
	public function setCellDefaultValue ($value)
	{
		$this->cell_default_value = $value;
	}

	/**
	 * 获取数据单元格的ID
	 *
	 * @param string $row_id        	
	 * @param string $col_id        	
	 * @return string
	 */
	public function getDataCellId ($row_head_id, $col_head_id)
	{
		return $row_head_id . Report::ID_Separator . $col_head_id;
	}

	/**
	 * 获取数据单元格
	 *
	 * @param string|array $cell_id
	 *        	支持字符串和数组两种格式，如果是数组：[row_head_id, col_head_id]
	 * @return \common\report\Cell
	 */
	public function getDataCell ($cell_id)
	{
		$cell_ids = static::parseCellId($cell_id, true);
		
		$cell_id = $this->getDataCellId($cell_ids[0], $cell_ids[1]);
		
		return $this->data_cells[$cell_id];
	}

	/**
	 * 解析单元格编号
	 *
	 * @param string|array $cell_id        	
	 */
	public static function parseCellId ($cell_id, $throw_exception = false)
	{
		if(is_array($cell_id))
		{
			return [
				$cell_id[0], 
				$cell_id[1]
			];
		}
		else
		{
			if(strpos($cell_id, Report::ID_Separator) === false)
			{
				if($throw_exception)
				{
					throw new \InvalidArgumentException("无效的单元格ID#" . $cell_id);
				}
				return false;
			}
			
			$row_head_id = substr($cell_id, 0, strpos($cell_id, Report::ID_Separator));
			$col_head_id = substr($cell_id, strpos($cell_id, Report::ID_Separator) + 1);
			
			return [
				$row_head_id, 
				$col_head_id
			];
		}
	}

	/**
	 * 设置数据单元格
	 *
	 * @param string|array $cell_id
	 *        	支持字符串和数组两种格式，如果是数组：[row_head_id, col_head_id]
	 * @param Cell $cell        	
	 */
	protected function setDataCell ($cell_id, $cell)
	{
		$this->data_cells[$cell_id] = $cell;
	}

	/**
	 * 为单元格设置值
	 *
	 * @param string|array $cell_id
	 *        	支持字符串和数组两种格式，如果是数组：[row_head_id, col_head_id]
	 * @param mixed $value        	
	 */
	public function setCellValue ($cell_id, $value)
	{
		$cell = $this->getDataCell($cell_id);
		if(! empty($cell))
		{
			$cell->value = $value;
		}
	}

	/**
	 * 获取数据单元格的数据
	 *
	 * @param string $cell_id        	
	 * @param string $name        	
	 * @return boolean|mixed false-单元格不存在
	 */
	public function getData ($cell_id, $name = null)
	{
		$cell = $this->getDataCell($cell_id);
		
		if(empty($cell))
		{
			return false;
		}
		
		if(is_null($name))
		{
			return $cell->data;
		}
		
		return $cell->data[$name];
	}

	/**
	 * 为数据单元格设置数据
	 *
	 * @param string $cell_id        	
	 * @param array $data        	
	 * @param boolean $merge
	 *        	是否合并：true-合并数据 false-覆盖数据
	 * @return boolean
	 */
	public function setData ($cell_id, $data, $merge = true)
	{
		$cell = $this->getDataCell($cell_id);
		
		if(empty($cell))
		{
			return false;
		}
		
		if($merge)
		{
			$cell->data = ArrayHelper::merge($cell->data, $data);
		}
		else
		{
			$cell->data = $data;
		}
		
		return true;
	}

	/**
	 * 合并单元格
	 *
	 * @param string $row_head_id1        	
	 * @param string $col_head_id1        	
	 * @param string $row_head_id2        	
	 * @param string $col_head_id2        	
	 */
	public function mergeCells ($cell_id1, $cell_id2)
	{
		$cell1 = $this->getDataCell($cell_id1);
		
		if($cell1 == null)
		{
			throw new \Exception(format("数据单元格[{0}]不存在！", $cell_id1));
		}
		
		$cell2 = $this->getDataCell($cell_id2);
		
		if($cell2 == null)
		{
			throw new \Exception(format("数据单元格[{0}]不存在！", $cell_id2));
		}
		
		// 计算行列起始、结束位置
		$row_start = $cell1->row_index;
		$row_end = $cell2->row_index + $cell2->row_span - 1;
		
		if($row_start > $row_end)
		{
			$temp = $row_start;
			$row_start = $row_end;
			$row_end = $temp;
		}
		
		$col_start = $cell1->col_index;
		$col_end = $cell2->col_index + $cell2->col_span - 1;
		
		if($col_start > $col_end)
		{
			$temp = $col_start;
			$col_start = $col_end;
			$col_end = $temp;
		}
		
		// 移除单元格，找到第一个单元格修改跨行、跨列值
		$is_first = true;
		
		foreach($this->rows as $i => &$row)
		{
			foreach($row->cells as $j => &$cell)
			{
				if($cell->row_index >= $row_start && $cell->row_index <= $row_end)
				{
					if($cell->col_index >= $col_start && $cell->col_index <= $col_end)
					{
						if($is_first)
						{
							$cell->row_span = abs($cell2->row_index - $cell1->row_index) + 1;
							$cell->col_span = abs($cell2->col_index - $cell1->col_index) + 1;
							$is_first = false;
						}
						else
						{
							unset($this->rows[$i]->cells[$j]);
						}
					}
				}
			}
		}
		
		return true;
	}

	/**
	 * 导出成Excel文件
	 *
	 * @param boolean $is_download
	 *        	是否下载文件：true-下载 false-返回文件的内容方便调用者写入文件
	 * @param ReportFormat|array $format        	
	 * @return string
	 */
	public function toExcel ($is_download = true, $format = [])
	{
        $excel = new \PHPExcel();
		
		$sheet = $excel->getActiveSheet();
		
		if(empty($format))
		{
			$format = new DefaultReportFormat();
		}
		else if(is_array($format))
		{
			$format = new DefaultReportFormat($format);
		}
		else if(! $format instanceof ReportFormat)
		{
			throw new \Exception('参数“format”类型错误');
		}
		
		$format->before($sheet, $this);
		
		// 行偏移量
		$row_offset = $format->getRowOffset();
		// 列偏移量
		$col_offset = $format->getColOffset();
		
		foreach($this->rows as $row)
		{
			foreach($row->cells as $cell)
			{
				$col_span = $cell->col_span - 1;
				$row_span = $cell->row_span - 1;
				$col_index = intval($cell->col_index - 1 + $col_offset);
				$row_index = intval($cell->row_index + $row_offset);
				
				$sheet->mergeCellsByColumnAndRow($col_index, $row_index, $col_index + $col_span, $row_index + $row_span);
				
				$excel_cell = $sheet->setCellValueByColumnAndRow($col_index, $row_index, $cell->value, true);
				
				$format->cellCallback($cell, $excel_cell);
			}
		}
		
		$format->after($sheet, $this);
		
		$writer = new \PHPExcel_Writer_Excel5($excel);
		
		if($is_download)
		{
			$filename = $this->title . '-' . date('YmdHis', time()) . '.xls';
			ob_end_clean();
			header('Content-Type : application/vnd.ms-excel');
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header('Content-Disposition:inline;filename="' . $filename . '"');
			header("Content-Transfer-Encoding: binary");
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: no-cache");
			$writer->save("php://output");
//			exit();
		}
		else
		{
			ob_flush();
			ob_start();
			
			$writer->save("php://output");
			
			$data = ob_get_contents();
			
			ob_end_clean();
			
			return $data;
		}
	}

	public function readExcel ($data)
	{
		$excel = new \PHPExcel();
		
		$sheet = $excel->getActiveSheet();
		
		if(empty($format))
		{
			$format = new DefaultReportFormat();
		}
		else if(is_array($format))
		{
			$format = new DefaultReportFormat($format);
		}
		else if(! $format instanceof ReportFormat)
		{
			throw new \Exception('参数“format”类型错误');
		}
		
		$format->before($sheet, $this);
		
		// 行偏移量
		$row_offset = $format->getRowOffset();
		// 列偏移量
		$col_offset = $format->getColOffset();
		
		foreach($this->rows as $row)
		{
			foreach($row->cells as $cell)
			{
				$col_span = $cell->col_span - 1;
				$row_span = $cell->row_span - 1;
				$col_index = intval($cell->col_index - 1 + $col_offset);
				$row_index = intval($cell->row_index + $row_offset);
				
				$sheet->mergeCellsByColumnAndRow($col_index, $row_index, $col_index + $col_span, $row_index + $row_span);
				
				$excel_cell = $sheet->setCellValueByColumnAndRow($col_index, $row_index, $cell->value, true);
				
				$format->cellCallback($cell, $excel_cell);
			}
		}
		
		$format->after($sheet, $this);
		
		$writer = new \PHPExcel_Writer_Excel5($excel);
		
		if($is_download)
		{
			$filename = $this->title . '-' . local_date('YmdHis', gmtime()) . '.xls';
			header('Content-Type : application/vnd.ms-excel');
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header('Content-Disposition:inline;filename="' . $filename . '"');
			header("Content-Transfer-Encoding: binary");
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: no-cache");
			$writer->save("php://output");
		}
		else
		{
			ob_flush();
			ob_start();
			
			$writer->save("php://output");
			
			$data = ob_get_contents();
			
			ob_end_clean();
			
			return $data;
		}
	}
}