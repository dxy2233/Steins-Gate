<?php
namespace common\report;

/**
 * 报表接口
 * 
 * @author niqingyang<niqy@qq.com>
 *        
 */
interface Report
{

	const CELL_TYPE_ColHead = "colHead";

	const CELL_TYPE_RowHead = "rowHead";

	const CELL_TYPE_Data = "data";

	const ID_Separator = "_";

	const ID_KEY = 'id';

	const NAME_KEY = 'name';

	const PARENT_ID_KEY = 'parent_id';

	/**
	 * 获取报表的跨列数
	 *
	 * @return int
	 */
	public function getColSpan ();

	/**
	 * 获取报表的跨行数
	 *
	 * @return int
	 */
	public function getRowSpan ();

	/**
	 * 获取行列表
	 *
	 * @return array[Row] 行列表
	 */
	public function getRows ();

	/**
	 * 获取数据单元格对象
	 *
	 * @param string $cell_id        	
	 * @return Cell|null
	 */
	public function getDataCell ($cell_id);
}