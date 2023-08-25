<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('create_nip')) {
	function create_nip()
	{
		$time = new DateTime();
		$nip = $time->format('YmdHis');
		return $nip;
	}
}

if(!function_exists('encrypt_pass')) {
	function encrypt_pass($nip, $pass)
	{
		$mix = md5($nip).md5($pass);
		$pass = sha1($mix);
		return $pass;
	}
}
