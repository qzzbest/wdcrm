<?php
/**
 * CRM 后台主要的公共函数库
 * ============================================================================
 */

$CI =& get_instance();	
/**
 * 判断当前用户登录状态
 */
function check_login()
{
	global $CI;
	if(getcookie_crm('islogin') == false){
		redirect('login/index');
	}
}
/**
* 后台检查表单验证
* @param array $data传入个数组,$val[0]是表单域名字,$val[1]错误提示信息,$val[2]是验证规则
*/
function check_form($data = array())
{
	global $CI;
	foreach ($data as $val)
	{
		if(!empty($val[2])){
			$check=$CI->form_validation->set_rules($val[0],$val[1],$val[2]);
		}else{
			$check=$CI->form_validation->set_rules($val[0],$val[1],'required');
		}
    }
    return $check;
}

/**
 * 设置cookie
 */
function setcookie_crm($name,$val='')
{
	if(is_array($name)){
		foreach($name as $k=>$v){

			setcookie($k,authcode($v,'ENCODE'));
		}
	}else{
		setcookie($name,authcode($val,'ENCODE'));
	}
	
}
/**
 * 获取cookie
 */
function getcookie_crm($name)
{	
	

	if(isset($_COOKIE[$name])){
		return authcode($_COOKIE[$name],'DECODE');
	}else{
		return '';
	}
	
}
/**
 * 删除cookie
 */
function delcookie_crm($name)
{
	setcookie($name);	
}

/**
* 显示提示信息
* @param string $msg 提示信息
* @param mixed(string/array) $url_forward 执行成功后跳转地址
* @param int $ms 跳转等待时间
*/
function show_message($msg="", $url_forward="",$ms=1250)
{
	$data=array(
		'msg'=>$msg,
		'url_forward'=>$url_forward,
		'ms'=>$ms
		);
	global $CI;
	$CI->load->view('showmessage',$data);
}
/**
* 显示提示信息
* @param string $msg 提示信息
* @param mixed(string/array) $url_forward 执行成功后跳转地址
*/
function gorecord($msg="", $uid="",$type=0)
{
	$data=array(
		'msg'=>$msg,
		'uid'=>$uid,
		'type'=>$type,
		);
	global $CI;
	$CI->load->view('showrecord',$data);
}
/**
* 选择提示信息
* @param string $msg 提示信息
* @param mixed(string/array) $url_forward 执行成功后跳转地址
* @param string $id 指定模态框（避免同个页面多个模态框的调用冲突）
*/
function show_select($msg="", $url_forward, $id="myModal")
{
$str=<<<HTML
<div class="modal fade" id="$id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">提示信息</h4>
			</div>
			<div class="modal-body">$msg</div>
			<div class="modal-footer">
				<button id="del_this" class="btn btn-danger" data-dismiss="modal">删除</button>
				<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
			</div>
			<script type="text/javascript">
				var url = "$url_forward";
				document.getElementById('del_this').onclick=function(){
					location.href = url;
				}
			</script>
		</div>
	</div>
</div>
HTML;
return $str;
}

/**
* 获取模块目录
* @param int $key 下标（1：超级管理员模块目录；2：咨询部模块目录；3：就业部模块目录；4：教务部模块目录; 5：公共模块目录；6:市场部模块目录）
* @param string module+模块各个目录名称
*/
function module_folder($key)
{

	global $CI;
	$module_folder = $CI->config->item('module_folder');
	return 'module/'.$module_folder[$key-1];
}

/**
 * 获取当前管理员信息
 * @param 
 */
function admin_info()
{
	//查询数据库获取管理员信息
}

function array_multi2single($array)    //把多维数组转化为一维数组
{ 
    static $result_array=array(); 
    foreach($array as $value) 
    {
        if(is_array($value)) 
        { 
            array_multi2single($value); 
        } 
        else  
            $result_array[]=$value; 
    } 
    return $result_array; 
} 
?>