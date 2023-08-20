<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_keys extends CI_migration
{
	private $tb_name;
	private $tb_engine;
	private $tb_field;

	function __construct()
	{
		parent::__construct();
		$this->tb_name = 'keys';
		$this->tb_key = 'id';
		$this->tb_engine = array('ENGINE' => 'InnoDB');
		$this->tb_field = $this->set_field();
	}

	public function set_field()
	{
		$field = array(
			'id' => $this->id(),
			'user_id' => $this->user_id(),
			'key' => $this->key(),
			'level' => $this->level(),
			'ignore_limits' => $this->ignore_limits(),
			'is_private_key' => $this->is_private_key(),
			'ip_addresses' => $this->ip_addresses(),
			'date_created' => $this->date_created());
		return $field;
	}

	public function id()
	{
		$attr = array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => false,
			'auto_increment' => TRUE);
		return $attr;
	}

	public function user_id()
	{
		$attr = array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => false);
		return $attr;
	}

	public function key()
	{
		$attr = array(
			'type' => 'VARCHAR',
			'constraint' => 40,
			'null' => false);
		return $attr;
	}

	public function level()
	{
		$attr = array(
			'type' => 'INT',
			'constraint' => 2,
			'null' => false);
		return $attr;
	}

	public function ignore_limits()
	{
		$attr = array(
			'type' => 'TINYINT',
			'constraint' => 1,
			'null' => false,
			'default' => 0);
		return $attr;
	}

	public function is_private_key()
	{
		$attr = array(
			'type' => 'TINYINT',
			'constraint' => 1,
			'null' => false,
			'default' => 0);
		return $attr;
	}

	public function ip_addresses()
	{
		$attr = array(
			'type' => 'TEXT',
			'null' => true,
			'default' => NULL);
		return $attr;
	}

	public function date_created()
	{
		$attr = array(
			'type' => 'DATE',
			'null' => false,);
		return $attr;
	}

	public function up()
	{

		$exis = $this->db->table_exists($this->tb_name);
		if(!$exis)
		{
			$this->dbforge->add_field($this->tb_field);
			$this->dbforge->add_key($this->tb_key, TRUE);
			$this->dbforge->create_table($this->tb_name, FALSE, $this->tb_engine);

			$value = $this->set_value();
			$this->load->database();
			$this->db->insert_batch($this->tb_name, $value);
		}
	}

	public function down()
	{
		$this->dbforge->drop_table($this->tb_name);
	}

	public function set_value()
	{
		$time = new DateTime();
		$created = $time->format('Y-m-d');
		$data[] = array(
			'id' => NULL,
			'user_id' => '',
			'key' => 'ci3-key',
			'level' => '',
			'ignore_limits' => '0',
			'is_private_key' => '0',
			'ip_addresses' => NULL,
			'date_created' => $created);
		return $data;
	}
}
?>
