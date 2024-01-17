<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('now')) {
	function now($format = null)
	{
		if(!$format) {
			return date('Y-m-d H:i:s');
		} else {
			switch($format) {
				case 'str': return strtotime('now'); 
					break;
				case 'date': return date('Y-m-d');
					break;
				case 'time': return date('H:i:s');
					break;
				case 'datetime': return date('Y-m-d H:i:s');
					break;
				default: return date($format);
					break;
			}
		}
	}
}

if(!function_exists('strtodate')) {
	function strtodate($str, $format = null) 
	{
		if(!$format) {
			return date('Y-m-d H:i:s', $str);
		} else {
			return date($format, $str);
		}
	}
}

if(!function_exists('difftime')) {
	function difftime($first, $second)
	{
		// format param "Y-m-d H:i:s"
		$origin = new DateTimeImmutable($first);
		$target = new DateTimeImmutable($second);
		$interval = $origin->diff($target);
		return $interval->format('%R%a %H:%I:%S');
	}
}

if(!function_exists('difftime_manual')) {
	function difftime_manual($first, $second)
	{
		// param format strtotime
		$diff = abs($first-$second);
		$one_i = 60;
		$one_h = 3600;
		$one_d = 86400;
		$one_w = 604800;
		$one_m = 2630000;
		$one_y = 31536000;
		
		$tahun = abs(floor($diff/$one_y));
		$thn_ex = ($tahun*$one_y);
		$dif_ex = $diff-$thn_ex;

		$bulan = abs(floor($dif_ex/$one_m));
		$minggu = abs(floor($dif_ex/$one_w));
		$hari = abs(floor($dif_ex/$one_d));
		$hari_ex = $dif_ex-($hari*$one_d);
		$jam = abs(floor($hari_ex/$one_h));
		$jam_ex = $hari_ex-($jam*$one_h);
		$menit = abs(floor($jam_ex/$one_i));
		$detik = abs(floor($jam_ex-($menit*$one_i)));

		$res['tahun'] = $tahun;
		$res['bulan'] = $bulan;
		$res['minggu'] = $minggu;
		$res['hari'] = $hari;
		$res['jam'] = $jam;
		$res['menit'] = $menit;
		$res['detik'] = $detik;

		return $res;
	}
}

if(!function_exists('tgl_indo')) {
	function tgl_indo($date = null, $with_day = true)
	{
		// output default "hari, tgl bulan_text tahun"
		$hari = array(
			1 => 'Senin','Selasa', 'Rabu','Kamis','Jumat','Sabtu','Minggu');
		$bln = array(
			1 => 'Januari','Februari','Maret','April','Mei','Juni',
			'Juli','Agustus','September','Oktober','November','Desember');

		if($date) {
			$exp = explode('-', $date);
			if(count($exp) == 1) {
				$tgl = date('Y-m-d', $date);
				$str = explode('-', $tgl);
				$num_day = date('N', $date);
				$tgl_indo = $str[2].' '.$bln[(int)$str[1]].' '.$str[0];
			} else {
				$num_day = date('N', strtotime($date));
				$tgl_indo = $exp[2].' '.$bln[(int)$exp[1]].' '.$exp[0];
			}

			if(!$with_day) {
				return $tgl_indo;
			} else {
				return $hari[$num_day].', '.$tgl_indo;
			}
		} else {
			$get = getdate();
			$num_day = $get['wday'];
			$num_month = $get['mon'];
			$default = $hari[$num_day].', '.$get['mday'].' '.$bln[$num_month].' '.$get['year'];
			return $default;
		}
	}
}

?>
