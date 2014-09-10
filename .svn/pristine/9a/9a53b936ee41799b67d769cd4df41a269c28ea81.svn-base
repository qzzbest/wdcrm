<?php
function tiaoshi($arr)
{
	header('content-Type:text/html;charset=utf-8');
	echo '<pre>';
	var_dump($arr);
	exit;
}
/**
 * CRM 全局公共函数库
 * ============================================================================
 */

/**
 * 创建像这样的查询: "IN('a','b')";
 *
 * @access   public
 * @param    mix      $item_list      列表数组或字符串
 * @param    string   $field_name     字段名称
 *
 * @return   void
 */
function db_create_in($item_list, $field_name = '')
{
    if (empty($item_list))
    {
        return $field_name . " IN ('') ";
    }
    else
    {
        if (!is_array($item_list))
        {
            $item_list = explode(',', $item_list);
        }
        $item_list = array_unique($item_list);
        $item_list_tmp = '';
        foreach ($item_list AS $item)
        {
            if ($item !== '')
            {
                $item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
            }
        }
        if (empty($item_list_tmp))
        {
            return $field_name . " IN ('') ";
        }
        else
        {
            return $field_name . ' IN (' . $item_list_tmp . ') ';
        }
    }
}

/**
 * 验证输入的邮件地址是否合法
 *
 * @access  public
 * @param   string      $email      需要验证的邮件地址
 *
 * @return bool
 */
function is_email($user_email)
{
    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false)
    {
        if (preg_match($chars, $user_email))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

/**
 * 检查是否为一个合法的时间格式
 *
 * @access  public
 * @param   string  $time
 * @return  void
 */
function is_time($time)
{
    $pattern = '/[\d]{4}-[\d]{1,2}-[\d]{1,2}\s[\d]{1,2}:[\d]{1,2}:[\d]{1,2}/';

    return preg_match($pattern, $time);
}


/**
 * 页面上调用的js文件(后台页面基本相同--不需要)
 *
 * @access  public
 * @param   array   $args  二维数组  格式：array(‘files’=>array('file1','file2','file3'))
 * @return  void
 */
function insert_scripts($args)
{
    static $scripts = array();

    $arr = explode(',', str_replace(' ','',$args['files']));

    $str = '';
    foreach ($arr AS $val)
    {
        if (in_array($val, $scripts) == false)
        {
            $scripts[] = $val;
            if ($val{0} == '.')
            {
                $str .= '<script type="text/javascript" src="' . base_url('assets/js'.$val) . '"></script>';
            }
            else
            {
                $str .= '<script type="text/javascript" src="js/' . base_url('assets/js'.$val) . '"></script>';
            }
        }
    }

    return $str;
}


/**
 * 调用array_combine函数(可查手册)
 * 函数通过合并两个数组来创建一个新数组，其中的一个数组是键名，另一个数组的值为键值。
 * 如果其中一个数组为空，或者两个数组的元素个数不同，则该函数返回 false。
 *
 * @param   array  $keys
 * @param   array  $values
 *
 * @return  $combined
 */
if (!function_exists('array_combine')) {
    function array_combine($keys, $values)
    {
        if (!is_array($keys)) {
            user_error('array_combine() expects parameter 1 to be array, ' .
                gettype($keys) . ' given', E_USER_WARNING);
            return;
        }

        if (!is_array($values)) {
            user_error('array_combine() expects parameter 2 to be array, ' .
                gettype($values) . ' given', E_USER_WARNING);
            return;
        }

        $key_count = count($keys);
        $value_count = count($values);
        if ($key_count !== $value_count) {
            user_error('array_combine() Both parameters should have equal number of elements', E_USER_WARNING);
            return false;
        }

        if ($key_count === 0 || $value_count === 0) {
            user_error('array_combine() Both parameters should have number of elements at least 0', E_USER_WARNING);
            return false;
        }

        $keys    = array_values($keys);
        $values  = array_values($values);

        $combined = array();
        for ($i = 0; $i < $key_count; $i++) {
            $combined[$keys[$i]] = $values[$i];
        }

        return $combined;
    }
}

//SQL 添加slassh 在指定的预定义字符前添加反斜杠(进行转义)
function saddslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = saddslashes($val);
		}
	} else {
		$string = addslashes($string);
	}
	return $string;
}

//SQL 去掉slassh  在指定的预定义字符前去掉反斜杠
function sstripslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = sstripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}

//取消HTML代码
function shtmlspecialchars($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = shtmlspecialchars($val);
		}
	} else {
		$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
			str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
	}
	return $string;
}

//字符串解密加密
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

	$ckey_length = 4;	// 随机密钥长度 取值 0-32;
				// 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
				// 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
				// 当此值为 0 时，则不产生随机密钥

	$key = md5($key ? $key : 'drerdljsdreoud');
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

//清空session/cookie

//设置session/cookie

//获取在线IP
function getonlineip($format=0) {
	global $_GLOBALVAR;

	if(empty($_GLOBALVAR['onlineip'])) {
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
		$_GLOBALVAR['onlineip'] = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
	}
	if($format) {
		$ips = explode('.', $_GLOBALVAR['onlineip']);
		for($i=0;$i<3;$i++) {
			$ips[$i] = intval($ips[$i]);
		}
		return sprintf('%03d%03d%03d', $ips[0], $ips[1], $ips[2]);
	} else {
		return $_GLOBALVAR['onlineip'];
	}
}

//写运行日志
function runlog($file, $log, $halt=0) {
	global $_GLOBALVAR, $_SERVER;
	
	$nowurl = $_SERVER['REQUEST_URI']?$_SERVER['REQUEST_URI']:($_SERVER['PHP_SELF']?$_SERVER['PHP_SELF']:$_SERVER['SCRIPT_NAME']);
	$log = sgmdate('Y-m-d H:i:s', $_GLOBALVAR['timestamp'])."\t$type\t".getonlineip()."\t$_GLOBALVAR[uid]\t{$nowurl}\t".str_replace(array("\r", "\n"), array(' ', ' '), trim($log))."\n";
	$yearmonth = sgmdate('Ym', $_GLOBALVAR['timestamp']);
	$logdir = './data/log/';
	if(!is_dir($logdir)) mkdir($logdir, 0777);
	$logfile = $logdir.$yearmonth.'_'.$file.'.php';
	if(@filesize($logfile) > 2048000) {
		$dir = opendir($logdir);
		$length = strlen($file);
		$maxid = $id = 0;
		while($entry = readdir($dir)) {
			if(strexists($entry, $yearmonth.'_'.$file)) {
				$id = intval(substr($entry, $length + 8, -4));
				$id > $maxid && $maxid = $id;
			}
		}
		closedir($dir);
		$logfilebak = $logdir.$yearmonth.'_'.$file.'_'.($maxid + 1).'.php';
		@rename($logfile, $logfilebak);
	}
	if($fp = @fopen($logfile, 'a')) {
		@flock($fp, 2);
		fwrite($fp, "<?PHP exit;?>\t".str_replace(array('<?', '?>', "\r", "\n"), '', $log)."\n");
		fclose($fp);
	}
	if($halt) exit();
}

//清除日志字符串
function clearlogstring($str) {
	if(!empty($str)) {
		if(!is_array($str)) {
			$str = shtmlspecialchars(trim($str));
			$str = str_replace(array("\t", "\r\n", "\n", "   ", "  "), ' ', $str);
		} else {
			foreach ($str as $key => $val) {
				$str[$key] = clearlogstring($val);
			}
		}
	}
	return $str;
}

// 请注意服务器是否开通fopen配置
function  log_result($word) {
    $fp = fopen("log.txt","a");
    flock($fp, LOCK_EX) ;
    fwrite($fp,"执行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}

/**
 * URL过滤
 * @param   string  $url  参数字符串，一个urld地址,对url地址进行校正
 * @return  返回校正过的url;
 */
function sanitize_url($url , $check = 'http://')
{
    if (strpos( $url, $check ) === false)
    {
        $url = $check . $url;
    }
    return $url;
}

//处理搜索关键字
function stripsearchkey($string) {
	$string = trim($string);
	$string = str_replace('*', '%', addcslashes($string, '%_'));
	$string = str_replace('_', '\_', $string);
	return $string;
}

//连接字符
function simplode($ids) {
	return "'".implode("','", $ids)."'";
}

//格式化大小函数
function formatsize($size) {
	$prec=3;
	$size = round(abs($size));
	$units = array(0=>" B ", 1=>" KB", 2=>" MB", 3=>" GB", 4=>" TB");
	if ($size==0) return str_repeat(" ", $prec)."0$units[0]";
	$unit = min(4, floor(log($size)/log(2)/10));
	$size = $size * pow(2, -10*$unit);
	$digi = $prec - 1 - floor(log($size)/log(10));
	$size = round($size * pow(10, $digi)) * pow(10, -$digi);
	return $size.$units[$unit];
}

//获取文件内容
function sreadfile($filename) {
	$content = '';
	if(function_exists('file_get_contents')) {
		@$content = file_get_contents($filename);
	} else {
		if(@$fp = fopen($filename, 'r')) {
			@$content = fread($fp, filesize($filename));
			@fclose($fp);
		}
	}
	return $content;
}

//写入文件
function swritefile($filename, $writetext, $openmod='w') {
	if(@$fp = fopen($filename, $openmod)) {
		flock($fp, 2);
		fwrite($fp, $writetext);
		fclose($fp);
		return true;
	} else {
		runlog('error', "File: $filename write error.");
		return false;
	}
}

//产生随机字符
function random($length, $numeric = 0) {
	PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
	$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed[mt_rand(0, $max)];
	}
	return $hash;
}

//判断字符串是否存在
function strexists($haystack, $needle) {
	return !(strpos($haystack, $needle) === FALSE);
}

//获取文件名后缀
function fileext($filename) {
	return strtolower(trim(substr(strrchr($filename, '.'), 1)));
}

//编码转换
function siconv($str, $out_charset, $in_charset='') {
	global $_SC;

	$in_charset = empty($in_charset)?strtoupper($_SC['charset']):strtoupper($in_charset);
	$out_charset = strtoupper($out_charset);
	if($in_charset != $out_charset) {
		if (function_exists('iconv') && (@$outstr = iconv("$in_charset//IGNORE", "$out_charset//IGNORE", $str))) {
			return $outstr;
		} elseif (function_exists('mb_convert_encoding') && (@$outstr = mb_convert_encoding($str, $out_charset, $in_charset))) {
			return $outstr;
		}
	}
	return $str;//转换失败
}

//处理网络图片链接
function getpicurl($picurl, $maxlenth='200') {
	$picurl = shtmlspecialchars(trim($picurl));
	if($picurl) {
		if(preg_match("/^http\:\/\/.{5,$maxlenth}\.(jpg|gif|png)$/i", $picurl)) return $picurl;
	}
	return '';
}


//处理分页


//重新组建数组
function renum($array) {
	$newnums = $nums = array();
	foreach ($array as $id => $num) {
		$newnums[$num][] = $id;
		$nums[$num] = $num;
	}
	return array($nums, $newnums);
}

//ip访问允许
function ipaccess($ipaccess) {
	return empty($ipaccess)?true:preg_match("/^(".str_replace(array("\r\n", ' '), array('|', ''), preg_quote($ipaccess, '/')).")/", getonlineip());
}

//ip访问禁止
function ipbanned($ipbanned) {
	return empty($ipbanned)?false:preg_match("/^(".str_replace(array("\r\n", ' '), array('|', ''), preg_quote($ipbanned, '/')).")/", getonlineip());
}

//语言替换
function lang_replace($text, $vars) {
	if($vars) {
		foreach ($vars as $k => $v) {
			$rk = $k + 1;
			$text = str_replace('\\'.$rk, $v, $text);
		}
	}
	return $text;
}

//截取链接
function sub_url($url, $length) {
	if(strlen($url) > $length) {
		$url = str_replace(array('%3A', '%2F'), array(':', '/'), rawurlencode($url));
		$url = substr($url, 0, intval($length * 0.5)).' ... '.substr($url, - intval($length * 0.3));
	}
	return $url;
}

//取数组中的随机个
function sarray_rand($arr, $num) {
	$r_values = array();
	if($arr && count($arr) > $num) {
		if($num > 1) {
			$r_keys = array_rand($arr, $num);
			foreach ($r_keys as $key) {
				$r_values[$key] = $arr[$key];
			}
		} else {
			$r_key = array_rand($arr, 1);
			$r_values[$r_key] = $arr[$r_key];
		}
	} else {
		$r_values = $arr;
	}
	return $r_values;
}

//产生form防伪码
function formhash() {
	global $_GLOBALVAR, $_SCONFIG;
	
	if(empty($_GLOBALVAR['formhash'])) {
		$hashadd = defined('IN_ADMINCP') ? 'Only For AdminCP' : '';
		$_GLOBALVAR['formhash'] = substr(md5(substr($_GLOBALVAR['timestamp'], 0, -7).'|'.$_GLOBALVAR['uid'].'|'.md5($_SCONFIG['sitekey']).'|'.$hashadd), 8, 8);
	}
	return $_GLOBALVAR['formhash'];
}

//安全问答
function quescrypt($questionid, $answer) {
	return $questionid > 0 && $answer != '' ? substr(md5($answer.md5($questionid)), 16, 8) : '';
}

//把数组元素组合为一个字符串
function implodearray($array, $skip = array()) {
	$return = '';
	if(is_array($array) && !empty($array)) {
		foreach ($array as $key => $value) {
			if(empty($skip) || !in_array($key, $skip)) {
				if(is_array($value)) {
					$return .= "$key={".implodearray($value, $skip)."}; ";
				} else {
					$return .= "$key=$value; ";
				}
			}
		}
	}
	return $return;
}

//。。。。。
function HtmlTag2($tagset)
{
	if (!isset($tagset['name']))
    {
        $tagset['name'] = "";
    }
    if (!isset( $tagset['size']))
    {
        $tagset['size'] = 30;
    }
    if (!isset( $tagset['maxlength']))
    {
        $tagset['maxlength'] = "";
    }
    if (!isset( $tagset['value']))
    {
        $tagset['value'] = "";
    }
    if (!isset( $tagset['values']))
    {
        $tagset['values'] = array();
    }
    if (!isset( $tagset['options']))
    {
        $tagset['options'] = array();
    }
	if(!isset($tagset['other']))
	{
		$tagset['other'] = '';
	}
	if(!isset($tagset['rows']))
	{
		$tagset['rows'] = '5';
	}
    switch ($tagset['type'])
    {
        case "text" :
            $tagstr = "<input name=\"".$tagset['name']."\" type=\"text\" id=\"".$tagset['name']."\" size=\"".$tagset['size']."\" value=\"".$tagset['value']."\"".$tagset['other']." />";
            break;
        case "password" :
            $tagstr = "<input name=\"".$tagset['name']."\" type=\"password\" id=\"".$tagset['name']."\" size=\"".$tagset['size']."\" value=\"".$tagset['value']."\"".$tagset['other']." />";
            break;
        case "text2" :
            if (!isset( $tagset['value'][0]))
            {
                $tagset['value'][0] = "";
            }
            if (!( isset( $tagset['value'][1])))
            {
                $tagset['value'][1] = "";
            }
            $tagstr = "<input name=\"".$tagset['name']."[]\" type=\"text\" id=\"".$tagset['name']."0\" size=\"".$tagset['size']."\" value=\"".$tagset['value'][0]."\"".$tagset['other']." />";
            $tagstr .= " ~ ";
            $tagstr .= "<input name=\"".$tagset['name']."[]\" type=\"text\" id=\"".$tagset['name']."1\" size=\"".$tagset['size']."\" value=\"".$tagset['value'][1]."\"".$tagset['other']." />";
            break;
        case "textarea" :
            $tagstr = "<textarea name=\"".$tagset['name']."\" style=\"width:98%;\" rows=\"".$tagset['rows']."\"".$tagset['other'].">".$tagset['value']."</textarea>";
            break;
        case "select" :
            $tagstr = "<select name=\"".$tagset['name']."\" id=\"".$tagset['name']."\"".$tagset['other'].">"."\n";
            foreach ( $tagset['options'] as $tmpkey => $tmpvalue )
            {
                if ( $tmpkey == $tagset['value'] )
                {
                    $tmpselected = " selected";
                }
                else
                {
                    $tmpselected = "";
                }
                $tagstr .= "<option value=\"".$tmpkey."\"".$tmpselected.">".htmlspecialchars( $tmpvalue )."</option>"."\n";
            }
            $tagstr .= "</select>"."\n";
            break;
		case "radio" :
            $tagstr = "";
            foreach ( $tagset['options'] as $tmpkey => $tmpvalue )
            {
                if ( $tmpkey == $tagset['value'] )
                {
                    $tmpchecked = " checked";
                }
                else
                {
                    $tmpchecked = "";
                }
                $tagstr .= "<input name=\"".$tagset['name']."\" type=\"radio\" value=\"".$tmpkey."\"".$tmpchecked.$tagset['other']." />".$tmpvalue."&nbsp;&nbsp;";
            }
            break;
        case "checkbox" :
            $tagstr = "";
            $i = 0;
            $tagstr = "<table class=\"freetable\"><tr>";
            foreach ( $tagset['options'] as $tmpkey => $tmpvalue )
            {
                $tagstr .= "<td><input name=\"".$tagset['name']."[]\" type=\"checkbox\" value=\"".$tmpkey."\"".$tagset['other']." />".$tmpvalue."</td>";
                if ( $i % 5 == 4 )
                {
                    $tagstr .= "</tr><tr>";
                }
                ++$i;
            }
            $tagstr .= "</tr></table>";
            if (!isset( $tagset['value']))
                break;
            if ( is_array( $tagset['value'] ) )
            {
                $showvaluearr = $tagset['value'];
            }
            else
            {
                $showvaluearr = explode( ",", $tagset['value'] );
            }
            foreach ( $showvaluearr as $showvalue )
            {
                $tagset['name'] = $tmpvalue;
                isset( $tagset['value'] );
                $showvalue = trim( $showvalue );
                $tagstr = str_replace( "value=\"".$showvalue."\"", "value=\"".$showvalue."\" checked", $tagstr );
            }
            break;
		case "file":
			$tagstr = "";
            $tagstr = "<input name=\"".$tagset['name']."\" type=\"file\" id=\"".$tagset['name']."\" size=\"".$tagset['size']."\" value=\"".$tagset['value']."\"".$tagset['other']." />";
			break;
	}
	return $tagstr;
}

//获取文件夹路径
function getfiledir()
{
	$timestamp = time();
	$filedirarr = $dirstr = array();
	$filedirarr[] = date("Y",$timestamp);
	$filedirarr[] = date("m",$timestamp);
	$dirstr[0] = SITE_ROOT;
	$dirstr[1] = './uploads/';
	$dirstr[2] = "";
	foreach($filedirarr as $v)
	{
		$dirstr[2] .= "/".$v;
		if(!mkfolderdir($dirstr[0].$dirstr[1].$dirstr[2]))
			return $_SYSCONFIG['attachset']['dir'];
	}
	return $dirstr;
}

//创建文件夹（权限0777）
function mkfolderdir($dirname,$ifmkindex = 1)
{
	$mkdir = false;
	if(!is_dir($dirname))
	{
		if(@mkdir( @$dirname))
        {
			@chmod(@$dirname,0777);
            if($ifmkindex)
            {
                @fclose(@fopen(@@$dirname."/index.htm", "w" ));
				@chmod(@@$dirname."/index.htm",0777);
            }
            $mkdir = true;
        }
        else
        {
			$mkdir = false;
        }
	}
	else
	{
		$mkdir = true;
	}
	return $mkdir;
}

//将IP转成十进制
function hexip($ipstr) {
	$ip_arr = explode(".",$ipstr); 
	$ip = 0; 
	foreach($ip_arr as $i=>$s){ 
		$ip += $s*pow(256,3-$i); 
	} 
	return $ip;
}

/**
* php获取字符串长度
*
* @param string $string 父字符串
* @param int $length 子字符串长度
* @param string $dot 截取操作发生时，在被截取字符串最后边增加的字符串
* @param string $charset 父字符串编码
* @return string
*/
function strLength($str,$charset='utf-8'){
    if($charset=='utf-8') $str = iconv('utf-8','gb2312',$str);
    $num = strlen($str);
    $cnNum = 0;
    for($i=0;$i<$num;$i++){
        if(ord(substr($str,$i+1,1))>127){
            $cnNum++;
            $i++;
        }
    }
    $enNum = $num-($cnNum*2);
    $number = ($enNum/2)+$cnNum;
    return ceil($number);
}

/**
* 截断字符串，退一位单字节截取模式，主要是针对中文的截取，防止乱码
*
* @param string $string 父字符串
* @param int $length 子字符串长度
* @param string $dot 截取操作发生时，在被截取字符串最后边增加的字符串
* @param string $charset 父字符串编码
* @return string
*/
function sub_str($string, $length, $dot = '...', $charset = 'utf-8')
{
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('＆', '＂', '《', '》'), $string);
	$strcut = '';
	if(strtolower($charset) == 'utf-8')
	{
		$n = $tn = $noc = 0;
		while($n < strlen($string))
		{
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126))
			{
				$tn = 1; $n++; $noc++;
			}elseif(194 <= $t && $t <= 223)
			{
				$tn = 2; $n += 2; $noc += 2;
			}elseif(224 <= $t && $t < 239)
			{
				$tn = 3; $n += 3; $noc += 2;
			}elseif(240 <= $t && $t <= 247)
			{
				$tn = 4; $n += 4; $noc += 2;
			}elseif(248 <= $t && $t <= 251)
			{
				$tn = 5; $n += 5; $noc += 2;
			}elseif($t == 252 || $t == 253)
			{
				$tn = 6; $n += 6; $noc += 2;
			}else
			{
				$n++;
			}
	
			if($noc >= $length){break;}
		}
		if($noc > $length){$n -= $tn;}
		$strcut = substr($string, 0, $n);
	}else 
	{
		for($i=0; $i<$length; $i++)
		{
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}
	$strcut = str_replace(array('＆', '＂', '《', '》'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	return $strcut .  ( strlen($string) > strlen($strcut) ? $dot : '');
}

/**
* 将字符串转换为数组
*
* @param	string	$data	字符串
* @return	array	返回数组格式，如果，data为空，则返回空数组
*/
function string2array($data) {
	if($data == '') return array();
	@eval("\$array = $data;");
	return $array;
}

/**
* 将数组转换为字符串
*
* @param	array	$data		数组
* @param	bool	$isformdata	如果为0，则不使用new_stripslashes处理，可选参数，默认为1
* @return	string	返回字符串，如果，data为空，则返回空
*/
function array2string($data, $isformdata = 1) {
	if($data == '') return '';
	if($isformdata) $data = new_stripslashes($data);
	return addslashes(var_export($data, TRUE));
}

/**
 * 返回经stripslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_stripslashes($string) {
	if(!is_array($string)) return stripslashes($string);
	foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
	return $string;
}
/**
 * 让字符串十进制加1
 * @param $text 需要处理的字符串
 * @param $addend 需要加1还是加2
 * @return 数值
 */
function addManiac($text,$addend){
	preg_match('/^(?<a>[a-zA-Z]*)(?<d>\d*)$/',$text,$m);
	if(($len_d=strlen($m['d']))>0){
		$num=intval($m['d'])+$addend;
		return $m['a'].sprintf('%0'.$len_d.'d',$num);
	}else{
		$num='';
		for($i=strlen($m['a'])-1; $addend>0; $i--){
			$d=$i<0? 0: ord( strtolower($m['a'][$i]) )-ord('a');
			//              ^---这个值改成 -1 即变成z+1=aa畸形进位
			$a=$addend%26;
			$d=$d+$a;
			$addend=intval($addend/26+$d/26);
			$num=chr($d%26+ord('a')).$num;
		}
		if($i>=0)	$num=substr($m['a'],0,$i+1).$num;		
		return $num;
	}
}
/**
 * 每个月的日期天
 * @param $year 需要处理的年份
 * @param $month 需要处理的月份
 * @return 这年这月的所有天数
 */
function getdaysinmonth($year, $month){
	$data=array();
    if($month==1 || $month==3 || $month==5 || $month==7 || $month==8 || $month==10 || $month==12){
		$total = 31;

    }elseif($month==4 || $month==6 || $month==9 || $month==11){
        $total = 30;

    }else{
        if($year%4==0 && $year%100!=0 || $year%400==0){
        	$total = 29;
        }else{
        	$total = 28;
        }
    }
	for($day=1;$day<=$total;$day++){
		$data[]=$year.'-'.$month.'-'.$day;
	}
	return $data;
}
/**
 * 自动编号
 * @param $year 需要处理的年份
 * @return 返回年份
 */
function getYearNum($num){
	//截取年份
	$str_year = substr($num,2,2);
	//获得当前年份
	$year = date('y');

	if($year == $str_year){
		$new_num = addManiac($num,1);
	}else{
		$new_num = 'wd'.$year.'001';
	}
	return $new_num;
}
/**
 * 文件上传（只能上传单个文件）
 * @param string $path 上传文件的存放路径（为空表示存到当前工作目录下）
 * @param int $type 上传文件的类型限制（1 图片   2 flash  3 视频   4 多媒体   5 文本   6 可执行文件   7 混合类型 8 不限制）
 * @param string $old_file 旧文件的路径加名字（如果有新文件上传，这个旧文件将被删除）
 * @return string 文件名（有新文件就是新文件的路径加名字，否则有旧文件还是旧文件的路径加名字，否则就是空）
 */
function uploadFile($path, $type = 1,  $old_file = '')
{
	$path = $path ? $path : './';
	
	//如果路径没有以 / 结束，自动加上 /
	$path = rtrim($path, '/') . '/';
	
	//如果路径不存在
	if(!is_dir($path))
	{
		mkdir($path, 0777, true);
	}

	//允许上传的文件类型
	$fileType = array(
	 	1 => array('gif','png','jpg','jpeg','bmp'),
		2 => array('swf','flv'),
		3 => array('rm','rmvb','avi','wmv','mpg','asf','mp3','wma','wmv','mid'),
		5 => array('txt','doc','xls','ppt','pdf','xml','rar','zip','gzip','cab','iso','sql'),
		6 => array('exe','com','scr','bat'),
		7 => array('txt','html','doc','docx','xls','xlsx','rar','zip','gzip','cab','iso')
	);
	$fileType[4] = array_merge($fileType[2], $fileType[3]);

	//获得$_FILES数组的所有key
	$arr_key = array_keys($_FILES);
	//获得要上传的文件的数组
	$file = $_FILES[$arr_key[0]];
	
	//没有文件上传
	if($file['size']<=0){return str_replace(array('../', './'), '', $old_file);}

	//获得此文件的扩展名
	$exten = strtolower( pathinfo($file['name'], PATHINFO_EXTENSION) );

	if($type < 8 && ! in_array($exten, $fileType[$type]))
	{
		die('<script>alert("'.$file['name'].'的文件类型不符合要求!"); window.history.go(-1);</script>');
	}

	//开始上传文件，保留文件的原来名字
	//move_uploaded_file($file['tmp_name'], $path.$file['name']);

	//为避免覆盖，重命名该文件，用当前时间戳加上一个随机数做为文件名
	$newname = $path. $_SERVER['REQUEST_TIME'] . mt_rand(1000, 9999) . '.' . $exten;
	//上传文件
	move_uploaded_file($file['tmp_name'], $newname);
	
	//改变文件权限（主要针对linux，windows系统此句没啥作用）
	chmod($newname, 0777);

	//删除旧文件
	is_file($old_file) && unlink($old_file);
	
	return str_replace(array('../', './'), '', $newname);
}

?>