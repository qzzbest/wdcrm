<?php
/**
 * Manage Site Url
 *
 * Create a local URL based on your basepath. Segments can be passed via the
 * first parameter either as a string or an array.
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('site_aurl'))
{
	function site_aurl($key=0,$uri = '')
	{
		$CI =& get_instance();
		$module_folder = $CI->config->item('module_folder');
		return $CI->config->site_url($module_folder[$key].'/'.$uri);
	}
}

?>
