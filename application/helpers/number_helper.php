<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * ----------------------------------------------------------------------------
 * @project     Initial
 * @author      Syarif YTH
 * @link        http://syarif-yth.github.io
 * ----------------------------------------------------------------------------
 */
if(!function_exists('romawi')) {
	function romawi($number)
	{
		$rule = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
		
		$romawi = '';
		$number = str_replace(".", "", $number);
		while($number > 0) {
			foreach($rule as $roman => $int) {
				if($number >= $int) {
					$number -= $int;
					$romawi .= $roman;
					break;
				}
			}
		}
		return $romawi;
	} 
}

if(!function_exists('terbilang')) {
	// format param "1000"/"1.000"
	function terbilang($nilai) 
	{
		$nilai = str_replace(".", "", $nilai);
		if($nilai < 0) {
			return "Minus ".trim(numb_to_currency_text($nilai));
		} else {
			return trim(numb_to_currency_text($nilai));
		} 
	}
}

if(!function_exists('numb_to_currency_text')) {
	function numb_to_currency_text($nilai) 
	{
		$nilai = abs($nilai);
		$text = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");

		$temp = "";
		if($nilai < 12) {
			$temp = " ".$text[$nilai];
		} else if($nilai < 20) {
			$temp = numb_to_currency_text($nilai - 10)." Belas";
		} else if($nilai < 100) {
			$temp = numb_to_currency_text($nilai/10)." Puluh".numb_to_currency_text($nilai % 10);
		} else if($nilai < 200) {
			$temp = " Seratus".numb_to_currency_text($nilai - 100);
		} else if($nilai < 1000) {
			$temp = numb_to_currency_text($nilai/100)." Ratus".numb_to_currency_text($nilai % 100);
		} else if($nilai < 2000) {
			$temp = " Seribu".numb_to_currency_text($nilai - 1000);
		} else if($nilai < 1000000) {
			$temp = numb_to_currency_text($nilai/1000)." Ribu".numb_to_currency_text($nilai % 1000);
		} else if($nilai < 1000000000) {
			$temp = numb_to_currency_text($nilai/1000000)." Tuta".numb_to_currency_text($nilai % 1000000);
		} else if($nilai < 1000000000000) {
			$temp = numb_to_currency_text($nilai/1000000000)." Miliar".numb_to_currency_text(fmod($nilai,1000000000));
		} else if($nilai < 1000000000000000) {
			$temp = numb_to_currency_text($nilai/1000000000000)." Triliun".numb_to_currency_text(fmod($nilai,1000000000000));
		}
		return $temp;
	}
}

?>
