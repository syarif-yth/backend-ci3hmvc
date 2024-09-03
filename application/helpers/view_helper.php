<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * ----------------------------------------------------------------------------
 * @project     Initial
 * @author      Syarif YTH
 * @link        http://syarif-yth.github.io
 * ----------------------------------------------------------------------------
 */
if(!function_exists('nav_active')) {
	function nav_active($active_page)
	{
		$nav = array('nav_dashboard','nav_users',
			'nav_surat','nav_pemeriksaan','nav_tanggapan',
			'nav_lhp','nav_tindaklanjut','nav_param');
		foreach($nav as $key => $val) {
			if($val == $active_page) {
				$return[$val] = 'active';
			} else {
				$return[$val] = '';
			}
		}
		return $return;
	}
}

if(!function_exists('alert_js')) {
	function alert_js($msg, $redirect)
	{
		?>
        <script>
            alert('<?=$msg?>');
			setTimeout(function() {
				window.location.href = '<?=$redirect?>';
			}, 500);
        </script>
        <?
	}
}

if(!function_exists('overflow')) {
	function overflow($text, $long) 
	{
		// $out = strlen($text) > $long ? substr($text,0,$long)." .... " : $text;
		// return $out;

		$num_words = $long+1;
		$words = array();
		$words = explode(" ", $text, $num_words);

		if(count($words) == ($long+1)){
			$words[$long] = " ... ";
		}
		
		$shown_string = "";
		$shown_string = implode(" ", $words);
		return $shown_string;
	}
}

?>
