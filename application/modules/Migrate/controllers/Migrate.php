<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends MX_Controller
{
	function __construct()
  {
    parent::__construct();
    $this->load->library('migration');
		$this->load->helper('tree_helper');
  }

	private function check_db()
	{
		$this->load->database();
		$this->load->dbutil();
		$db_name = $this->db->database;
		if(!$this->dbutil->database_exists($db_name)) {
			$res['status'] = false;
			$res['message'] = 'Not connected database, or database not exists';
		} else {
			$res['status'] = true;
			$res['message'] = 'Connected to '.$db_name;
		}
		return $res;
	}

	public function index()
	{
		$this->load->database();
		$db_name = $this->db->database;
		$view = array('dbName' => $db_name);
		$this->load->view('migrate', $view);
	}

	public function process()
	{		
		$migrate = $this->migration();
		$view = array('response' => $migrate);
		$this->load->view('response', $view);
	}

	private function migration()
	{
		$version = 3;
		$migrate = array();
		for($v=0; $v<=$version; $v++) {
			if(!$this->migration->version($v)) {
				$error = show_error($this->migration->error_string());
				$migrate[] = array(
					'status' => false,
					'message' => 'Migration table '.$v.' ERROR.<br>'.$error);
			} else {
				$migrate[] = array(
					'status' => true,
					'message' => 'Migration table '.$v.' SUCCESS.');
			}
		}
		return $migrate;
	}
}
