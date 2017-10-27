<?php
namespace common\report;

use common\report\Report;

/**
 * 报表格式接口
 * @author niqingyang<niqy@qq.com>
 *
 */
interface ReportFormat
{

	/**
	 * 在创建工作空间之后，填充单元格之前触发
	 *
	 * @param PHPExcel_Worksheet $sheet        	
	 * @param Report $report        	
	 */
	public function before ($sheet, $report);

	/**
	 * 在填充单元格之后触发
	 *
	 * @param PHPExcel_Worksheet $sheet        	
	 * @param Report $report        	
	 */
	public function after ($sheet, $report);

	/**
	 * 每填充完一个单元格都会触发
	 *
	 * @param Cell $cell        	
	 * @param \PHPExcel_Cell $excel_cell        	
	 */
	public function cellCallback ($cell, $excel_cell);

	/**
	 * 获取行偏移量
	 *
	 * @return int
	 */
	public function getRowOffset ();

	/**
	 * 获取列偏移量
	 *
	 * @return int
	 */
	public function getColOffset ();
}