<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends MX_Controller
{
	function __construct()
  {
    parent::__construct();
    $this->load->library('migration');
		$this->load->helper('url');
  }

	public function index()
	{
		$version = $this->uri->segment(2);
		$msg = array();
		for($v=1; $v<=$version; $v++)
		{
			if(!$this->migration->version($v))
			{
				$error = show_error($this->migration->error_string());
				$status = 'error';
				$msg[] = 'Migration table '.$v.' ERROR.<br>'.$error;
			}
			else
			{
				$status = 'success';
				$msg[] = 'Migration table '.$v.' SUCCESS.';
			}
		}

		$res['status'] = $status;
		$res['message'] = $msg;
		var_dump($res);
	}
}
