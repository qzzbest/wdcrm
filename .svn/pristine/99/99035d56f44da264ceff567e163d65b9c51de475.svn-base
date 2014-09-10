<?php
/**
 * CRM 时间函数
 * ============================================================================
 */

/** 
 * $date= 要处理的日期  
 * $step  0= 本月   ,正负表示得到本月前后的月份日期  
 * $date= 要处理的月份  
 * Enter description here ...  
 */  
function AssignTabMonth($date,$step){  
    $date= date("Y-m-d",strtotime($step." months",strtotime($date)));//得到处理后的日期（得到前后月份的日期）    
    $u_date = strtotime($date);  
    $days=date("t",$u_date);// 得到结果月份的天数  
      
    //月份第一天的日期  
    $first_date=date("Y-m",$u_date).'-01';  
    for($i=0;$i<$days;$i++){  
        $for_day=date("Y-m-d",strtotime($first_date)+($i*3600*24));  
    }  
    $date = array(
        'first_date' => $first_date,
        'last_date' => $for_day
    );
    return $date;  

}

/**
 * 获得当前格林威治时间的时间戳
 *
 * @return  integer
 */
function gmtime()
{
    return (time() - date('Z'));
}

/**
 * 获得服务器的时区
 *
 * @return  integer
 */
function server_timezone()
{
    if (function_exists('date_default_timezone_get'))
    {
        return date_default_timezone_get();
    }
    else
    {
        return date('Z') / 3600;
    }
}


/**
 *  生成一个用户自定义时区日期的GMT时间戳
 *
 * @access  public
 * @param   int     $hour
 * @param   int     $minute
 * @param   int     $second
 * @param   int     $month
 * @param   int     $day
 * @param   int     $year
 *
 * @return void
 */
function local_mktime($hour = NULL , $minute= NULL, $second = NULL,  $month = NULL,  $day = NULL,  $year = NULL)
{
    $timezone = isset($_SESSION['timezone']) ? $_SESSION['timezone'] : $GLOBALS['_CFG']['timezone'];

    /**
    * $time = mktime($hour, $minute, $second, $month, $day, $year) - date('Z') + (date('Z') - $timezone * 3600)
    * 先用mktime生成时间戳，再减去date('Z')转换为GMT时间，然后修正为用户自定义时间。以下是化简后结果
    **/
    $time = mktime($hour, $minute, $second, $month, $day, $year) - $timezone * 3600;

    return $time;
}


/**
 * 将GMT时间戳格式化为用户自定义时区日期
 *
 * @param  string       $format
 * @param  integer      $time       该参数必须是一个GMT的时间戳
 *
 * @return  string
 */

function local_date($format, $time = NULL)
{
    $timezone = isset($_SESSION['timezone']) ? $_SESSION['timezone'] : $GLOBALS['_CFG']['timezone'];

    if ($time === NULL)
    {
        $time = gmtime();
    }
    elseif ($time <= 0)
    {
        return '';
    }

    $time += ($timezone * 3600);

    return date($format, $time);
}


/**
 * 转换字符串形式的时间表达式为GMT时间戳
 *
 * @param   string  $str
 *
 * @return  integer
 */
function gmstr2time($str)
{
    $time = strtotime($str);

    if ($time > 0)
    {
        $time -= date('Z');
    }

    return $time;
}

/**
 *  将一个用户自定义时区的日期转为GMT时间戳
 *
 * @access  public
 * @param   string      $str
 *
 * @return  integer
 */
function local_strtotime($str)
{
    $timezone = isset($_SESSION['timezone']) ? $_SESSION['timezone'] : $GLOBALS['_CFG']['timezone'];

    /**
    * $time = mktime($hour, $minute, $second, $month, $day, $year) - date('Z') + (date('Z') - $timezone * 3600)
    * 先用mktime生成时间戳，再减去date('Z')转换为GMT时间，然后修正为用户自定义时间。以下是化简后结果
    **/
    $time = strtotime($str) - $timezone * 3600;

    return $time;

}

/**
 * 获得用户所在时区指定的时间戳
 *
 * @param   $timestamp  integer     该时间戳必须是一个服务器本地的时间戳
 *
 * @return  array
 */
function local_gettime($timestamp = NULL)
{
    $tmp = local_getdate($timestamp);
    return $tmp[0];
}

/**
 * 获得用户所在时区指定的日期和时间信息
 *
 * @param   $timestamp  integer     该时间戳必须是一个服务器本地的时间戳
 *
 * @return  array
 */
function local_getdate($timestamp = NULL)
{
    $timezone = isset($_SESSION['timezone']) ? $_SESSION['timezone'] : $GLOBALS['_CFG']['timezone'];

    /* 如果时间戳为空，则获得服务器的当前时间 */
    if ($timestamp === NULL)
    {
        $timestamp = time();
    }

    $gmt        = $timestamp - date('Z');       // 得到该时间的格林威治时间
    $local_time = $gmt + ($timezone * 3600);    // 转换为用户所在时区的时间戳

    return getdate($local_time);
}

//时间格式化
function sgmdate($dateformat, $timestamp='', $format=0) {
	global $_SCONFIG, $_GLOBALVAR;
	if(empty($timestamp)) {
		$timestamp = $_GLOBALVAR['timestamp'];
	}
	$result = '';
	if($format) {
		$time = $_GLOBALVAR['timestamp'] - $timestamp;
		if($time > 24*3600) {
			$result = gmdate($dateformat, $timestamp + $_SCONFIG['timeoffset'] * 3600);
		} elseif ($time > 3600) {
			$result = intval($time/3600).'小时前';
		} elseif ($time > 60) {
			$result = intval($time/60).'分钟前';
		} elseif ($time > 0) {
			$result = $time.'秒前';
		} else {
			$result = '现在';
		}
	} else {
		$result = gmdate($dateformat, $timestamp + $_SCONFIG['timeoffset'] * 3600);
	}
	return $result;
}

//字符串时间化
function sstrtotime($string) {
	global $_GLOBALVAR, $_SCONFIG;
	$time = '';
	if($string) {
		$time = strtotime($string);
		if(sgmdate('H:i') != date('H:i')) {
			$time = $time - $_SCONFIG['timeoffset'] * 3600;
		}
	}
	return $time;
}

//检验时间格式
function dateck($ymd, $sep='-') {
	if(!empty($ymd)) {
		list($year, $month, $day) = explode($sep, $ymd);
		return checkdate($month, $day, $year);
	} else {
		return FALSE;
	}
}

//时间间隔计算
/*
*    $start   开始时间，支持时钟格式如：8：00
*    $end     结束时间
*    $space   间隔时间
*/
function dateecho($start, $end, $space=1)
{

	$geshu = ceil((strtotime($end)-strtotime($start))/60/$space);
	$arr=array();
	for($i=1;$i<=$geshu;$i++)
	{
	$arr[] =date('H:i',strtotime($start)+($i-1)*$space*60) .'-'. (strtotime($start)+$i*$space*60>strtotime($end) ? $end : date('H:i',strtotime($start)+$i*$space*60));
	}
/*	foreach($arr as $key=> $v){
		$arr[$key] = explode('-',$v);
	}*/
	return $arr;
}

?>