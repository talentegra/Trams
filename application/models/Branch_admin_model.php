<?php
/* 
 * Generated by CRUDigniter v2.1 Beta 
 * www.crudigniter.com
 */
 
class Branch_admin_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get branch_admin by id
     */
    function get_branch_admin($id)
    {
        return $this->db->get_where('branch_admins',array('id'=>$id))->row_array();
    }
	/*
     * Get branch_admin by id
     */
    function get_branch_admin_by_branch_id($branch_id)
    {
        return $this->db->get_where('branch_admins',array('branch_id'=>$branch_id))->result_array();
    }
    
    /*
     * Get all branch_admins
     */
    function get_all_branch_admins()
    {
        return $this->db->get('branch_admins')->result_array();
    }
    
    /*
     * function to add new branch_admin
     */
    function add_branch_admin($params)
    {
        $this->db->insert('branch_admins',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update branch_admin
     */
    function update_branch_admin($id,$params)
    {
        $this->db->where('id',$id);
        $this->db->update('branch_admins',$params);
    }
    
    /*
     * function to delete branch_admin
     */
    function delete_branch_admin($id)
    {
        $this->db->delete('branch_admins',array('id'=>$id));
    }
	/*
     * Get all branch_admins
     */
    function get_all_branch_admins_details()
    {
       // return $this->db->get('branch_admins')->result_array();
		$this->db->select('branch_admins.*,users.first_name,users.last_name,branch.branch_code');
		$this->db->from('branch_admins');
		$this->db->join('users', 'users.id = branch_admins.user_id');
		$this->db->join('branch', 'branch.id = branch_admins.branch_id');
		$this->db->where('branch.active','1');
		$this->db->where('users.active','1');
		return $this->db->get()->result_array();
    }
	
	/*
     * function to add new branch_admin
     */
    function add_branch_admin_in_batch($params)
    {
        $this->db->insert_batch('branch_admins',$params);
        return $this->db->insert_id();
    }
}
