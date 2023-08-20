<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_limits extends CI_migration
{
	private $tb_name;
	private $tb_engine;
	private $tb_field;

	function __construct()
	{
		parent::__construct();
		$this->tb_name = 'limits';
		$this->tb_key = 'id';
		$this->tb_engine = array('ENGINE' => 'InnoDB');
		$this->tb_field = $this->set_field();
	}

	public function set_field()
	{
		$field = array(
			'id' => $this->id(),
			'uri' => $this->uri(),
			'count' => $this->count(),
			'hour_started' => $this->hour_started(),
			'api_key' => $this->api_key());
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

	public function uri()
	{
		$attr = array(
			'type' => 'VARCHAR',
			'constraint' => 225,
			'null' => false);
		return $attr;
	}

	public function count()
	{
		$attr = array(
			'type' => 'INT',
			'constraint' => 10,
			'null' => false);
		return $attr;
	}

	public function hour_started()
	{
		$attr = array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => false);
		return $attr;
	}

	public function api_key()
	{
		$attr = array(
			'type' => 'VARCHAR',
			'constraint' => 40,
			'null' => false);
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
		}
	}

	public function down()
	{
		$this->dbforge->drop_table($this->tb_name);
	}
}
?>
