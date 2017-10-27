<?php
namespace common\report;

use yii\base\Object;

/**
 * 默认报表格式
 *
 * @author niqingyang<niqy@qq.com>
 *        
 */
class DefaultReportFormat extends Object implements ReportFormat
{

	/**
	 * 单元格边框样式：false-无边框
	 */
	public $border = \PHPExcel_Style_Border::BORDER_THIN;

	/**
	 * 文字水平方向默认居中：false-不设置
	 */
	public $align_horizontal = \PHPExcel_Style_Alignment::HORIZONTAL_CENTER;

	/**
	 * 文字垂直方向默认居中：false-不设置
	 */
	public $align_vertical = \PHPExcel_Style_Alignment::VERTICAL_CENTER;

	/**
	 * 行高
	 */
	public $row_height = 20;

	/**
	 * 列偏移量
	 */
	public $col_offset = 0;

	/**
	 * 行偏移量
	 */
	public $row_offset = 0;

	/**
	 * 在创建工作空间之后，填充单元格之前触发
	 *
	 * @param PHPExcel_Worksheet $sheet        	
	 * @param Report $report        	
	 */
	public function before ($sheet, $report)
	{
	}

	/**
	 * 在填充单元格之后触发
	 *
	 * @param PHPExcel_Worksheet $sheet        	
	 * @param Report $report        	
	 */
	public function after ($sheet, $report)
	{
		$sheet->getDefaultRowDimension()->setRowHeight($this->row_height);
		
		// 默认单元格边框
		if($this->border != false)
		{
			// 计算单元格边界
			$col_index = $this->getColOffset();
			$row_index = $this->getRowOffset() + 1;
			$col_span = $report->getColSpan() - 1;
			$row_span = $report->getRowSpan() - 1;
			
			// 默认样式
			$style = $sheet->getStyleByColumnAndRow($col_index, $row_index, $col_index + $col_span, $row_index + $row_span);
			
			$style->getBorders()->getAllBorders()->setBorderStyle($this->border);
		}
	}

	/**
	 * 每填充完一个单元格都会触发
	 *
	 * @param Cell $cell        	
	 * @param \PHPExcel_Cell $excel_cell        	
	 */
	public function cellCallback ($cell, $excel_cell)
	{
		// 文字水平方向
		if($this->align_horizontal != false)
		{
			$excel_cell->getStyle()->getAlignment()->setHorizontal($this->align_horizontal);
		}
		// 文字垂直方向
		if($this->align_horizontal != false)
		{
			$excel_cell->getStyle()->getAlignment()->setVertical($this->align_vertical);
		}
	}

	/**
	 * 获取行偏移量
	 *
	 * @return int
	 */
	public function getRowOffset ()
	{
		return $this->row_offset;
	}

	/**
	 * 获取列偏移量
	 *
	 * @return int
	 */
	public function getColOffset ()
	{
		return $this->col_offset;
	}
}