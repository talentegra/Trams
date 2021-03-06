<?php


/* Location: ./application/models/Enrollment_model.php */
/* Derived from Harviacode  */
/* Modified by Vivek Raghunathan 2016-06-21 15:48:54 */
/* Email : vivekra@dqserv.com */
/* http://dqserv.com */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Enrollment_model extends CI_Model
{

    public $table = 'enrollment';
    public $id = 'enroll_id';
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
    function get_all_enrollment()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result_array();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
	
	
	// get data array by id
    function get_enrollment($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row_array();
    }
	    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('enroll_id', $q);
	$this->db->or_like('enroll_date', $q);
	$this->db->or_like('stud_id', $q);
	$this->db->or_like('batch_id', $q);
	$this->db->or_like('score', $q);
	$this->db->or_like('registration_fee', $q);
	$this->db->or_like('admission_fee', $q);
	$this->db->or_like('discount', $q);
	$this->db->or_like('discount_percent', $q);
	$this->db->or_like('tax', $q);
	$this->db->or_like('total_fee', $q);
	$this->db->or_like('payment_mode', $q);
	$this->db->or_like('payment_option', $q);
	$this->db->or_like('notes', $q);
	$this->db->or_like('certificate_notes', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $sort_column = '',$sort_by = '',$q = NULL) {
		if($sort_column!='' && $sort_by!= '' ){
            $this->db->order_by($sort_column, $sort_by);
        }
		else { 
        $this->db->order_by($this->id, $this->order);
		}
        $this->db->like('enroll_id', $q);
	$this->db->or_like('enroll_date', $q);
	$this->db->or_like('stud_id', $q);
	$this->db->or_like('batch_id', $q);
	$this->db->or_like('score', $q);
	$this->db->or_like('registration_fee', $q);
	$this->db->or_like('admission_fee', $q);
	$this->db->or_like('discount', $q);
	$this->db->or_like('discount_percent', $q);
	$this->db->or_like('tax', $q);
	$this->db->or_like('total_fee', $q);
	$this->db->or_like('payment_mode', $q);
	$this->db->or_like('payment_option', $q);
	$this->db->or_like('notes', $q);
	$this->db->or_like('certificate_notes', $q);
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

/* End of file Enrollment_model.php */