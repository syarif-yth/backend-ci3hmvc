<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * ----------------------------------------------------------------------------
 * @project     Initial
 * @author      Syarif YTH
 * @link        http://syarif-yth.github.io
 * ----------------------------------------------------------------------------
 */
if(!function_exists('array_remove')) {
	// removing array by key without delete like array_unset
	function array_remove($array, $remove = null)
	{
		if($array && $remove) {
			return array_diff_key($array, array_flip((array) $remove));
		} else {
			return $array;
		}
	}
}
