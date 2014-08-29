<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 咨询者表模型
 */
class Market_market_record_model extends CI_Model 
{
	private $t;#表名
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('market_record');
	}

	/**
	 *	查询列表
	 */
	public function select_index($start,$limit,$market_id)
	{	

		$this->db->select('*')
				 ->where('market_id',$market_id)
				 ->limit($limit,$start)
				 ->order_by('market_record_time DESC');

		$data=$this->db->get($this->t);

		return $data->result_array();
		
	}	
	/**
	 *	查找总数
	 */
	public function select_index_count($market_id)
	{	

		$this->db->where('market_id',$market_id);

		return $this->db->count_all_results($this->t);
		
	}	
	/**
	 *	查找某个咨询记录
	 */
	public function select_one($record_id)
	{	

		$this->db->select('*')
				 ->where('market_record_id',$record_id);

		$data=$this->db->get($this->t);

		return $data->row_array();
		
	}	
	
	/**
	 * 删除多条记录
	 */
	public function delete_record($market_id,$ids)
	{

		$this->db->where('market_id',$market_id);
		$this->db->where_in('market_record_id',$ids);
		$this->db->delete($this->t);

		return $this->db->affected_rows();
	}
}