<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_upload_files_model extends CI_Model 
{
	private $table;#员工表
	function __construct()
	{
		parent::__construct();
		$this->table=$this->db->dbprefix('upload_files');
	}
	
	/**
	 *	列表
	 */
	public function select_index($start,$limit,$file_status)
	{

		$field='*';

		$this->db->select($field)
				 ->limit($limit,$start)
				 ->where('file_status',$file_status);
		//为下载文件按照上传时间升序,下载文件按照上传时间降序
		if($file_status==1){
			$this->db->order_by('upload_time ASC');
		}else{
			$this->db->order_by('upload_time DESC');
		}
				
		$data=$this->db->get($this->table);
		return $data->result_array();
	}
	/**
	 * 分页
	 */
	public function select_index_count($file_status)
	{
		$this->db->where('file_status',$file_status);
		return $this->db->count_all_results($this->table);
	}
	/**
	 * 删除文件记录
	 */
	public function delete_file($upload_id)
	{
		$this->db->where_in('upload_file_id',$upload_id)
		         ->delete($this->table);
		return $this->db->affected_rows();
	}
}