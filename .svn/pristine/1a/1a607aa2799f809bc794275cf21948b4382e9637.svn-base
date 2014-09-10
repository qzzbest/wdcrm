<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 基础model,提供了基本的单个查询,查询所有,复杂查询,修改,插入,删除数据
 *
 */
 class Main_data_model extends CI_Model
 {
	
	protected $table;
	public function __construct()
	{
  		parent::__construct();
	}
	
	public function setTable($table)
	{
		$this->table = $table;
		return $this;
	}
	/**
	 * 插入数据
	 * @param  $data  array  关联数组的数据
	 * @param  $table string 表名
	 * @return 返回插入数据后的自增id
	 */
	public function insert($data,$table='')
	{
		$table = $table==''?$this->table:$table;
		if($data){
			$this->db->insert($table,$data);
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	/**
	 * 插入多条数据
	 * @param  $data  array  关联数组的数据（二维数组）
	 * @param  $table string 表名
	 * @return 返回插入数据后的自增id
	 */
	public function insert_batch($data,$table='')
	{
		$table = $table==''?$this->table:$table;
		if($data){
			$this->db->insert_batch($table,$data);
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	/**
	 * 编辑数据	
	 * @param  $where  mixed  编辑数据的条件
	 * @param  $data   array  关联数组的数据
	 * @param  $table  string 新的表名
	 * @return 返回修改后收影响的行数
	 */
 	public function update($where,$data,$table='')
 	{
		$table = $table==''?$this->table:$table;
		if(!empty($where)){
			$this->db->where($where);
		}
		$this->db->update($table,$data);
		return $this->db->affected_rows();
	}
	/**
	 * 删除数据
	 * @param $where mixed 删除条件 (第一种是当$num==1 where的,第二种是$num!=1,where_in的 where_in 采用array('id',array(2,12,23))) 这样的方式删除
	 * @param $num int  选取删除的条件
	 * @param  $table  string 新的表名
	 * @return 返回删除受影响的行数
	 */
	public function delete($where,$num=1,$table='')
	{
		$table = $table==''?$this->table:$table;
		if($num===1){
			$this->db->where($where);
		}else{
			$this->db->where_in($where[0],$where[1]);
		}
		$this->db->delete($table);
		return $this->db->affected_rows();
	}
	/**
	 *  根据条件查询表的行数
	 */
	public function count($where='',$table='')
	{
		$table = $table==''?$this->table:$table;
		if(!($where==='')){
			$this->db->where($where);
		}	
		return $this->db->count_all_results($table);
	}
	/**
	 * 查询表的所有数据
	 */
	public function getAll($field='*',$table='')
	{
		$table = $table==''?$this->table:$table;

		if ($field!=='*') {
			$this->db->select($field);
		}

		$data= $this->db->get($table);

		return $data->result_array();
	}

	/**
	 * 带条件的查询表的所有数据
	 */
	public function getOtherAll($field='*',$where='',$table='')
	{
		$table = $table==''?$this->table:$table;

		if ($field!=='*') {
			$this->db->select($field);
		}

		if($where!=''){
			$this->db->where($where);
		}
		$data= $this->db->get($table);

		return $data->result_array();
	}


	/**
	 * 单个数据查询
	 * @param string/array 查询数据的条件
	 * @param string 	   指定查询的字段 为空就是查询所有
	 * @param string 	   指定查询的表名
	 */
	public function getOne($where,$select='',$table='')
	{
		$table = $table==''?$this->table:$table;
		
		if ($select!='') {
			$this->db->select($select);
		}

		$this->db->where($where);
		$data= $this->db->get($table);
		
		return $data->row_array();
	}
	/**
	 * 	复杂的连表查询
	 *	@param  $filed  string 查询的字段
	 *  @param  $where   查询的条件
	 *  @param  $orders int	排序
	 *  @param  $start 	int 从哪里开始 
	 *  @param  $limit  分页数
	 *  @param  $join
	 */
	public function select($field,$where=0,$orders=0,$start=0,$limit=0,$join=0,$table='')
	{
		
		$table = $table==''?$this->table:$table;
		
        #如果连表了,那么给主表的字段添加表前缀
        if ($join!==0){
          $this->db->select($this->fieldAdd($field,$table));
        }else{
           $this->db->select($field); 
        }
        
        if ($where!==0){
          $this->db->where($where);
        }

        #排序
        if($orders!==0){
            $this->db->order_by($orders);    
        }

        #分页
        if($limit != '' &&$limit!==0){
        	$this->db->limit($limit,$start);
        }
        

        #连表查询
        if ($join!==0) {
           if (is_array($join[0])) {
                foreach ($join as $item) {
                    #给连接表的字段添加表前缀
                    $this->db->select($this->fieldAdd($item[0],$item[1]));
                    $this->db->join($item[1], $item[2],$item[3]);
                }
           }else{
                $this->db->select($this->fieldAdd($join[0],$join[1]));
				
                $this->db->join($join[1],$join[2],$join[3]);
           }
        }
        
        $data=$this->db->get($table);
        
        return $data->result_array();
    }

    /**
     *	灵活查询
     */
    public function query($field,$table='',$paywhere,$type='one',$order='')
    {

    	$table = $table==''?$this->table:$table;

    	$sql = "SELECT $field FROM ".$this->db->dbprefix($table);

    	if($paywhere !== ''){
    		$sql .= " WHERE $paywhere ";
    	}

    	if($order !== ''){
    		$sql .= $order;
    	}

    	$query = $this->db->query($sql);

    	if($type == 'one'){
    		return $query->row_array();
    	}else if($type == 'all'){
    		return $query->result_array();
    	}else if($type == 'sum'){
    		$res = $query->row_array();
    		return $res['c'];
    	}  
    	
    }

    /**
     * 字段添加表名
     */
    protected function fieldAdd($field,$table)
    {
        $field_arr=explode(',',$field);
        if (array_walk($field_arr,array(__CLASS__,'_fieldAdd'),$table)){
            $field=implode(',',$field_arr);
        }else{
            die($field.'error');
        }
        return $field;
    }
    /**
     * 回调函数
     */
    protected function _fieldAdd(&$v,$k,$add)
    {
        $v=$add.'.'.$v;
    }
 
 }
 
// END  class

/* End of file data_model.php */
/* Location: ./application/models/data_model.php */

