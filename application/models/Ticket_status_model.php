<?php


/* Location: ./application/models/Ticket_status_model.php */
/* Derived from Harviacode  */
/* Modified by Vivek Raghunathan 2016-03-25 02:07:00 */
/* Email : vivekra@dqserv.com */
/* http://dqserv.com */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ticket_status_model extends CI_Model
{

    public $table = 'ticket_status';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }
	
	// get all data array
    function get_all_ticket_status()
	{
        $this->db->where('flags', 1);
		//$this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result_array();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
	
	
	// get data array by id
    function get_ticket_status_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row_array();
    }
	
	//get only active data
	function get_ticket_status()
	{
		$this->db->where('flags', 1);
		return $this->db->get($this->table)->row_array();
	}
	    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('name', $q);
	$this->db->or_like('state', $q);
	$this->db->or_like('mode', $q);
	$this->db->or_like('flags', $q);
	$this->db->or_like('sort', $q);
	$this->db->or_like('properties', $q);
	$this->db->or_like('created', $q);
	$this->db->or_like('updated', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('name', $q);
	$this->db->or_like('state', $q);
	$this->db->or_like('mode', $q);
	$this->db->or_like('flags', $q);
	$this->db->or_like('sort', $q);
	$this->db->or_like('properties', $q);
	$this->db->or_like('created', $q);
	$this->db->or_like('updated', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Ticket_status_model.php */