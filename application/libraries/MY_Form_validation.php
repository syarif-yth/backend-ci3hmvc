<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ----------------------------------------------------------------------------
 * @project     StarterKIT
 * @author      Syarif YTH
 * @link        http://syarif-yth.github.io
 * ----------------------------------------------------------------------------
 */

/**
 * Class MY_Form_validation
 *
 * place into ./application/libraries
 * 
 * use like this
 * if ($this->form_validation->run($this) == FALSE)
 * {
 *
 * }
 * else
 * {
 *
 * }
 */
class MY_Form_validation extends CI_Form_validation
{

  /**
   * Class properties - public, private, protected and static.
   * ------------------------------------------------------------------------
   */


  // ------------------------------------------------------------------------

  /**
   * run ()
   * ---------------------------------------------------------------------------
   *
   * @param   string $module
   * @param   string $group
   * @return  bool
   */

  public function run($module = '', $group = '')
  {
    (is_object($module)) AND $this->CI = &$module;
    return parent::run($group);
  }

	

	/*
	custom validate, name "{controller}_{field}"
	extra validate, name "valid_{field}"
	database validate, name "db_{field}_{model function name} 
	special validate, 
	*/

	private function loader()
	{
		$ci =& get_instance();
		$ci->load->helper('input');
		// $ci->load->model('validation');
		$ci->mess_unique = 'Bidang {field} harus berisi nilai unik';
		return $ci;
	}

	public function query_is_unique($table, $where)
	{
		$ci = $this->loader();
		$ci->load->database();
		$ci->load->helper('database');
		$ci->db->where($where);
		$kueri = $ci->db->get($table);
		if(!$kueri) {
			$err = $ci->db->error();
			return db_error($err);
		} else {
			if($kueri->num_rows() == 0) {
				$res['code'] = 200;
			} else {
				$res['code'] = 400;
			}
			return $res;
		}
	}

	public function query_is_exist($table, $where)
	{
		$ci = $this->loader();
		$ci->load->database();
		$ci->load->helper('database');
		$ci->db->where($where);
		$kueri = $ci->db->get($table);
		if(!$kueri) {
			$err = $ci->db->error();
			return db_error($err);
		} else {
			if($kueri->num_rows() == 1) {
				$res['code'] = 200;
			} else {
				$res['code'] = 400;
			}
			return $res;
		}
	}

	public function no_space($str)
	{
		$ci = $this->loader();
		$regex = preg_match('/\s/', $str);
		if($regex == true) {
			$ci->form_validation->set_message('no_space', '{field} tidak boleh berisi spasi');
			return false;
		} else { return true; }
	}

	public function valid_username($str)
	{
		$ci = $this->loader();
		$preg = preg_user($str);
		if(!$preg) {
			$ci->form_validation->set_message('valid_username', '{field} hanya boleh berisi karakter alfanumerik, garis bawah, dan tanda hubung');
			return false;
		} else { return true; }
	}

	public function valid_password($str)
	{
		$ci = $this->loader();
		$preg = preg_pass($str);
		if(!$preg) {
			$ci->form_validation->set_message('valid_password', '{field} harus berisi huruf besar, huruf kecil, angka, dan karakter khusus');
			return false;
		} else { return true; }
	}

	public function db_email_is_unique($str)
	{
		$ci = $this->loader();
		$where = array('email' => $str);
		$is_unique = $this->query_is_unique('users', $where);
		if($is_unique['code'] != 200) {
			if($is_unique['code'] == 400) {
				$ci->form_validation->set_message('db_email_is_unique', $ci->mess_unique);
			} else {
				$ci->form_validation->set_message('db_email_is_unique', $is_unique['message']);
			}
			return false;
		} else { return true; }
	}

	public function db_username_is_unique($str)
	{
		$ci = $this->loader();
		$where = array('username' => $str);
		$is_unique = $this->query_is_unique('users', $where);
		if($is_unique['code'] != 200) {
			if($is_unique['code'] == 400) {
				$ci->form_validation->set_message('db_username_is_unique', $ci->mess_unique);
			} else {
				$ci->form_validation->set_message('db_username_is_unique', $is_unique['message']);
			}
			return false;
		} else { return true; }
	}

	public function db_email_is_exist($str)
	{
		$ci = $this->loader();
		$where = array('email' => $str);
		$is_exist = $this->query_is_exist('users', $where);
		if($is_exist['code'] != 200) {
			if($is_exist['code'] == 400) {
				$ci->form_validation->set_message('db_email_is_exist', '{field} tidak terdaftar');
			} else {
				$ci->form_validation->set_message('db_email_is_exist', $is_exist['message']);
			}
			return false;
		} else { return true; }
	}

	public function db_username_is_exist($str)
	{
		$ci = $this->loader();
		$where = array('username' => $str);
		$is_exist = $this->query_is_exist('users', $where);
		if($is_exist['code'] != 200) {
			if($is_exist['code'] == 400) {
				$ci->form_validation->set_message('db_username_is_exist', '{field} tidak terdaftar');
			} else {
				$ci->form_validation->set_message('db_username_is_exist', $is_unique['message']);
			}
			return false;
		} else { return true; }
	}

	public function db_email_edit($str, $match)
	{
		$ci = $this->loader();
		$data = $ci->form_validation->validation_data;
		if($str !== $data[$match]) {
			$where = array('email' => $str);
			$is_unique = $this->query_is_unique('users', $where);
			if($is_unique['code'] != 200) {
				if($is_unique['code'] == 400) {
					$ci->form_validation->set_message('db_email_edit', $ci->mess_unique);
				} else {
					$ci->form_validation->set_message('db_email_edit', $is_unique['message']);
				}
				return false;
			} else { return true; }
		} else { return true; }
	}

	public function db_username_edit($str, $match)
	{
		$ci = $this->loader();
		$data = $ci->form_validation->validation_data;
		if($str !== $data[$match]) {
			$where = array('username' => $str);
			$is_unique = $this->query_is_unique('users', $where);
			if($is_unique['code'] != 200) {
				if($is_unique['code'] == 400) {
					$ci->form_validation->set_message('db_username_edit', $ci->mess_unique);
				} else {
					$ci->form_validation->set_message('db_username_edit', $is_unique['message']);
				}
				return false;
			} else { return true; }
		} else { return true; }
	}

	public function db_username_reset($str, $match)
	{
		$ci = $this->loader();
		$data = $ci->form_validation->validation_data;
		if($str == $data[$match]) {
			$where = array('username' => $str);
			$is_exist = $this->query_is_exist('users', $where);
			if($is_exist['code'] != 200) {
				if($is_exist['code'] == 400) {
					$ci->form_validation->set_message('db_username_reset', '{field} tidak terdaftar');
				} else {
					$ci->form_validation->set_message('db_username_reset', $is_unique['message']);
				}
				return false;
			} else { return true; }
		} else { return true; }
	}

	public function db_namatoko_is_unique($str, $match)
	{
		$ci = $this->loader();
		$data = $ci->form_validation->validation_data;
		$where = array('nama_toko' => $str,
			'alamat' => $data[$match]);
		$is_unique = $this->query_is_unique('par_pembeli', $where);
		if($is_unique['code'] != 200) {
			if($is_unique['code'] == 400) {
				$ci->form_validation->set_message('db_namatoko_is_unique', '{field} sudah terdaftar');
			} else {
				$ci->form_validation->set_message('db_namatoko_is_unique', $is_unique['message']);
			}
			return false;
		} else { return true; }
	}

	public function db_edit_namatoko_is_unique($str, $match)
	{
		$ci = $this->loader();
		$data = $ci->form_validation->validation_data;
		if(($str !== $data['nama_toko_old']) || ($data['alamat'] !== $data['alamat_old'])) {
			$where = array('nama_toko' => $str,
				'alamat' => $data[$match]);
			$is_unique = $this->query_is_unique('par_pembeli', $where);
			if($is_unique['code'] != 200) {
				if($is_unique['code'] == 400) {
					$ci->form_validation->set_message('db_edit_namatoko_is_unique', '{field} sudah terdaftar');
				} else {
					$ci->form_validation->set_message('db_edit_namatoko_is_unique', $is_unique['message']);
				}
				return false;
			} else { return true; }
		} else { return true; }
	}

	public function db_namachannel_is_unique($str, $match)
	{
		$ci = $this->loader();
		$data = $ci->form_validation->validation_data;
		$where = array('nama_channel' => $str,
			'alamat' => $data[$match]);
		$is_unique = $this->query_is_unique('par_channel', $where);
		if($is_unique['code'] != 200) {
			if($is_unique['code'] == 400) {
				$ci->form_validation->set_message('db_namachannel_is_unique', '{field] sudah terdaftar');
			} else {
				$ci->form_validation->set_message('db_namachannel_is_unique', $is_unique['message']);
			}
			return false;
		} else { return true; }
	}

	public function db_edit_namachannel_is_unique($str, $match)
	{
		$ci = $this->loader();
		$data = $ci->form_validation->validation_data;
		if(($str !== $data['nama_channel_old']) || ($data['alamat'] !== $data['alamat_old'])) {
			$where = array('nama_channel' => $str,
				'alamat' => $data[$match]);
			$is_unique = $this->query_is_unique('par_channel', $where);
			if($is_unique['code'] != 200) {
				if($is_unique['code'] == 400) {
					$ci->form_validation->set_message('db_edit_namachannel_is_unique', '{field} sudah terdaftar');
				} else {
					$ci->form_validation->set_message('db_edit_namachannel_is_unique', $is_unique['message']);
				}
				return false;
			} else { return true; }
		} else { return true; }
	}

	public function valid_rule($str)
	{
		$ci = $this->loader();
		if(!empty($str)) {
			if(($str!=='admin') && ($str!=='manager') && ($str!=='user')) {
				$ci->form_validation->set_message('valid_rule', '{field} tidak sesuai');
				return false;
			} else { return true; }
		} else { return true; }
	}



















	

	public function recovery_email($str)
	{
		$ci = $this->loader();
		$where = array('email' => $str);
		$is_exist = $this->query_is_exist('users', $where);
		if($is_exist['code'] != 200) {
			if($is_exist['code'] == 400) {
				$ci->form_validation->set_message('recovery_email', 'The Email or username not registed.');
			} else {
				$ci->form_validation->set_message('recovery_email', $is_unique['message']);
			}
			return false;
		} else { return true; }
	}

	public function recovery_username($str)
	{
		$ci = $this->loader();
		$where = array('username' => $str);
		$is_exist = $ci->validation->is_exist('users', $where);
		if($is_exist['code'] != 200) {
			if($is_exist['code'] == 400) {
				$ci->form_validation->set_message('recovery_username', 'The Email or username not registed.');
			} else {
				$ci->form_validation->set_message('recovery_username', $is_unique['message']);
			}
			return false;
		} else { return true; }
	}

	public function db_rulename_is_unique($str)
	{
		$ci = $this->loader();
		$where = array('nama' => $str);
		$is_unique = $ci->validation->is_unique('rules', $where);
		if($is_unique['code'] != 200) {
			if($is_unique['code'] == 400) {
				$ci->form_validation->set_message('db_rulename_is_unique', $ci->mess_unique);
			} else {
				$ci->form_validation->set_message('db_rulename_is_unique', $is_unique['message']);
			}
			return false;
		} else { return true; }
	}

	public function db_navname_is_unique($str)
	{
		$ci = $this->loader();
		$where = array('nama' => $str);
		$is_unique = $ci->validation->is_unique('navigasi', $where);
		if($is_unique['code'] != 200) {
			if($is_unique['code'] == 400) {
				$ci->form_validation->set_message('db_navname_is_unique', $ci->mess_unique);
			} else {
				$ci->form_validation->set_message('db_navname_is_unique', $is_unique['message']);
			}
			return false;
		} else { return true; }
	}

	public function db_urutan_is_unique($str)
	{
		$ci = $this->loader();
		$where = array('urutan' => $str);
		$is_unique = $ci->validation->is_unique('navigasi', $where);
		if($is_unique['code'] != 200) {
			if($is_unique['code'] == 400) {
				$ci->form_validation->set_message('db_urutan_is_unique', $ci->mess_unique);
			} else {
				$ci->form_validation->set_message('db_urutan_is_unique', $is_unique['message']);
			}
			return false;
		} else { return true; }
	}

	

	public function valid_navnama($str, $match)
	{
		$ci = $this->loader();
		$data = $ci->form_validation->validation_data;
		if($str !== $data[$match]) {
			$where = array('nama' => $str);
			$is_unique = $ci->validation->is_unique('navigasi', $where);
			if($is_unique['code'] != 200) {
				if($is_unique['code'] == 400) {
					$ci->form_validation->set_message('valid_navnama', $ci->mess_unique);
				} else {
					$ci->form_validation->set_message('valid_navnama', $is_unique['message']);
				}
				return false;
			} else { return true; }
		} else { return true; }
	}

	public function valid_urutan($str, $match)
	{
		$ci = $this->loader();
		$data = $ci->form_validation->validation_data;
		if($str !== $data[$match]) {
			$where = array('urutan' => $str);
			$is_unique = $ci->validation->is_unique('navigasi', $where);
			if($is_unique['code'] != 200) {
				if($is_unique['code'] == 400) {
					$ci->form_validation->set_message('valid_urutan', $ci->mess_unique);
				} else {
					$ci->form_validation->set_message('valid_urutan', $is_unique['message']);
				}
				return false;
			} else { return true; }
		} else { return true; }
	}

	public function db_classnama_is_unique($str)
	{
		$ci = $this->loader();
		$where = array('nama' => $str);
		$is_unique = $ci->validation->is_unique('par_class', $where);
		if($is_unique['code'] != 200) {
			if($is_unique['code'] == 400) {
				$ci->form_validation->set_message('db_classnama_is_unique', $ci->mess_unique);
			} else {
				$ci->form_validation->set_message('db_classnama_is_unique', $is_unique['message']);
			}
			return false;
		} else { return true; }
	}

	public function valid_classnama($str, $match)
	{
		$ci = $this->loader();
		$data = $ci->form_validation->validation_data;
		if($str !== $data[$match]) {
			$where = array('nama' => $str);
			$is_unique = $ci->validation->is_unique('par_class', $where);
			if($is_unique['code'] != 200) {
				if($is_unique['code'] == 400) {
					$ci->form_validation->set_message('valid_classnama', $ci->mess_unique);
				} else {
					$ci->form_validation->set_message('valid_classnama', $is_unique['message']);
				}
				return false;
			} else { return true; }
		} else { return true; }
	}

	public function valid_gender($str) 
	{
		$ci = $this->loader();
		if(!empty($str)) {
			if(($str!=='laki-laki') && ($str!=='perempuan')) {
				$ci->form_validation->set_message('valid_gender', 'The {field} field not allowed value.');
				return false;
			} else { return true; }
		} else { return true; }
	}

	public function valid_birth($str)
	{
		$ci = $this->loader();
		if(!empty($str)) {
			$ci->load->helper('datetime');
			$now = now('str');
			$birth = strtotime($str);
			$diff = difftime_manual($birth, $now);
			if($diff['tahun'] < 17) {
				$ci->form_validation->set_message('valid_birth', 'The {field} field must be greater than 17+');
				return false;
			} else { return true; }
		} else { return true; }
	}


	public function valid_close($str)
	{
		$ci = $this->loader();
		if(!empty($str)) {
			if(($str!=='temporary') && ($str!=='permanent')) {
				$ci->form_validation->set_message('valid_close', 'The {field} field not allowed value.');
				return false;
			} else { return true; }
		} else { return true; }
	}




    // ------------------------------------------------------------------------

}   // End of MY_Form_validation Class.

/**
 * ----------------------------------------------------------------------------
 * Filename: MY_Form_validation.php
 * Location: ./application/libraries/MY_Form_validation.php
 * ----------------------------------------------------------------------------
 */ 
