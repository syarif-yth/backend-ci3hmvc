<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// THIS HELPER REGISTED ON AUTOLOAD CONFIG

if(!function_exists('set_column')) {
	// keys = array with key / array value only
	function set_column($array = null, $keys = false)
	{
		$value = '';
		if(is_null($array)) {
			$value = '* ';
		} else {
			$i = 1;
			$last = count($array);
			foreach($array as $key => $val) {
				if($keys) {
					$value .= ($i==$last) ? $key : $key.", ";
				} else {
					$value .= (((int)$key+1)==$last) ? $val : $val.", ";
				}
				$i++;
			}
		}
		return $value;
	}
}

if(!function_exists('set_insert')) {
	// keys = return value/key of data
	function set_insert($data, $keys = false)
	{
		$i = 1;
		$last = count($data);
		$value = (!$keys) ? "('" : "(";
		foreach($data as $key => $val) {
			if(!$keys) {
				$value .= ($i==$last) ? $val."')" : $val."', '";
			} else {
				$value .= ($i==$last) ? $key.")" : $key.", ";
			}
			$i++;
		}
		return $value;
	}
}

if(!function_exists('set_edit')) {
	// remove = removing by array key of data
	function set_edit($data, $remove = []) 
	{
		$dt_edit = '';
		if(count($remove) != 0) {
			$dt_edit = array_diff_key($data, array_flip((array) $remove));
		} else {
			$dt_edit = $data;
		}

		$i = 1;
		$last = count($dt_edit);
		$value = '';
		foreach($dt_edit as $key => $val) {
			if(is_null($val)) {
				$value .= ($i==$last) ? $key." = NULL" : $key." = NULL, ";
			} else {
				if($i != $last) {
					$value .= $key." = '".$val."', ";
				} else {
					$value .= $key." = '".$val."'";
				}
			}
			$i++;
		}
		return $value;
	}
}

if(!function_exists('set_where')) {
	// setting query where operator default AND 
	function set_where($data)
	{
		$i = 1;
		$last = count($data);
		$value = 'AND ';
		foreach($data as $key => $val) {
			if(is_null($val)) {
				$value .= ($i==$last) ? $key." = NULL" : $key." = NULL AND ";
			} else {
				if($i != $last) {
					$value .= $key." = '".$val."' AND ";
				} else {
					$value .= $key." = '".$val."'";
				}
			}
			$i++;
		}
		return $value;
	}
}

if(!function_exists('res_data')) {
	// convert "user.email" to "email"
	function res_data($data)
	{
		$res = array();
		foreach($data as $key => $val) {
			$exp = explode('.', $key);
			$last = count($exp)-1;
			if(count($exp) > 1) {
				$res[$exp[$last]] = $val;
			} else {
				$res[$key] = $val;
			}
		}
		return $res;
	}
}

if(!function_exists('db_error')) {
	// setting db error return message only
	function db_error($err)
	{
		$res['code'] = 500;
		$res['message'] = $err['message'];
		return $res;
	}
}

?>

