<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * ----------------------------------------------------------------------------
 * @project     Initial
 * @author      Syarif YTH
 * @link        http://syarif-yth.github.io
 * ----------------------------------------------------------------------------
 */
if(!function_exists('create_nip')) {
	function create_nip()
	{
		$characters = '0123456789';
    $random = '';
    for($i=0; $i<10; $i++) {
			$random .= $characters[rand(0, strlen($characters) - 1)];
    }
		return $random;
	}
}

if(!function_exists('encrypt_pass')) {
	function encrypt_pass($nip, $pass)
	{
		$options = ['cost' => 12];
		$hashed = password_hash($nip.$pass, PASSWORD_BCRYPT, $options);
		return $hashed;
	}
}

if(!function_exists('encrypt_url')) {
	function encrypt_url($nip, $user)
	{
		$time = new DateTime();
		$now = $time->format('YmdHis');
		$mix = md5($nip).md5($user).md5($now);
		return sha1($mix);
	}
}

if(!function_exists('value_cookie')) {
	function value_cookie($nip)
	{
		$time = new DateTime();
		$now = $time->format('His');
		$mix = md5($nip).md5($now);
		return sha1($mix);
	}
}

if(!function_exists('preg_user')) {
	function preg_user($str)
	{
		// dapat terdiri dari huruf kecil dan huruf kapital
		// dapat terdiri dari karakter alfanumerik
		// dapat terdiri dari garis bawah, tanda hubung
		// tidak boleh dua garis bawah dan dua tanda hubung berturut-turut
		// tidak boleh ada garis bawah, atau tanda hubung di awal atau akhir
		$preg = preg_match('/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/', $str);
		return (bool) $preg;
	}
}

if(!function_exists('preg_pass')) {
	function preg_pass($str)
	{
		// minimal satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus
		$preg = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{0,}$/', $str);
		return (bool) $preg;
	}
}

if(!function_exists('preg_sha1')) {
	function preg_sha1($str)
	{
		$preg = preg_match('/^[0-9a-f]{40}$/i', $str);
		return (bool) $preg;
	}
}






// Minimal delapan karakter, minimal satu huruf dan satu angka:
// preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $str);

// Minimal delapan karakter, minimal satu huruf, satu angka, dan satu karakter khusus:
// preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/', $str);

// Minimal delapan karakter, minimal satu huruf besar, satu huruf kecil, dan satu angka:
// preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $str);

// Minimal delapan karakter, minimal satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus:
// preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $str);

// Minimal delapan dan maksimal 10 karakter, minimal satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus:
// preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,10}$/', $str);


