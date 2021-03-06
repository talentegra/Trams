<?php

/* Location: ./application/controllers/Branch_type.php */
/* Derived from Harviacode  */
/* Modified by Vivek Raghunathan 2016-06-21 15:46:38 */
/* Email : vivekra@dqserv.com */
/* http://dqserv.com */



if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Branch_type extends APP_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Branch_type_model');
        $this->load->library('form_validation');
		$this->load->library('Arbac');
		if(!$this->arbac->is_loggedin()){ redirect('scp/login'); }
    }

    public function index()
    {
        $data = array(
            'title' => 'TRAMS::SCP::branch_type',
            'sort_by' => 'DESC',
            'sort_column' => 'branch_type_id',
			'q' => '',
			'total_rows' => ''
        );
        $this->_tpl('branch_type/branch_type_list', $data);
    }

    public function list_data()
    {
		$page = $this->input->post('page');
        $sort_by = $this->input->post('sortby');
        $sort_column = $this->input->post('sort_column');
		$q = $this->input->post('q');

        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $this->perPage = 5;

        if ($this->input->post('per_page') > 0) {
            $this->perPage = $this->input->post('per_page');
        }

        //pagination configuration
        $config['first_link'] = 'First';
        $config['div'] = 'Branch_type_list'; //parent div tag id
        $config['base_url'] = base_url(). 'Branch_type/list_data';
        $config['total_rows'] = $this->Branch_type_model->total_rows($q);
        $config['per_page'] = $this->perPage;

        $this->ajax_pagination->initialize($config);

        //get the posts data
        $branch_type_data = $this->Branch_type_model->get_limit_data($config['per_page'], $offset,$sort_column ,$sort_by , $q);

        $data = array(
            'branch_type_data' => $branch_type_data,
            'page' => $page,
            'sort_by' => $sort_by,
            'sort_column' => $sort_column,
            'set_user_pagination_status' => $this->perPage,
            'title' => 'TRAMS | ',
            'primary_role_id' => $this->session->userdata('primary_role'),
			'total_rows' => $config['total_rows']
        );

        //load the view
        $this->load->view('branch_type/branch_type_list_data', $data);
    }

    public function read($id) 
    {
        $row = $this->Branch_type_model->get_by_id($id);
        if ($row) {
            $data = array(
			'title'  => 'TRAMS::SCP::Branch_type',
		'branch_type_id' => $row->branch_type_id,
		'branch_type_name' => $row->branch_type_name,
		'active' => $row->active,
		'created' => $row->created,
		'updated' => $row->updated,
	    );
			$this->_tpl('branch_type/branch_type_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('branch_type'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('branch_type/create_action'),
			'title'  => 'TRAMS::SCP::Create Branch_type',
	    'branch_type_id' => set_value('branch_type_id'),
	    'branch_type_name' => set_value('branch_type_name'),
	    'active' => set_value('active'),
	    'created' => set_value('created'),
	    'updated' => set_value('updated'),
	);
          $this->_tpl('branch_type/branch_type_form', $data);	
		
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'branch_type_name' => $this->input->post('branch_type_name',TRUE),
		'active' => $this->input->post('active',TRUE),
		'created' => date('Y-m-d H:i:s'),
		'updated' => date('Y-m-d H:i:s'),
	    );

            $this->Branch_type_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('branch_type'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Branch_type_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('branch_type/update_action'),
				'title'  => 'TRAMS::SCP::Update Branch_type',
		'branch_type_id' => set_value('branch_type_id', $row->branch_type_id),
		'branch_type_name' => set_value('branch_type_name', $row->branch_type_name),
		'active' => set_value('active', $row->active),
		'created' => set_value('created', $row->created),
		'updated' => set_value('updated', $row->updated),
	    );
			$this->_tpl('branch_type/branch_type_edit', $data);
		
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('branch_type'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('branch_type_id', TRUE));
        } else {
            $data = array(
		'branch_type_name' => $this->input->post('branch_type_name',TRUE),
		'active' => $this->input->post('active',TRUE),
		
		'updated' => date('Y-m-d H:i:s'),
	    );

            $this->Branch_type_model->update($this->input->post('branch_type_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('branch_type'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Branch_type_model->get_by_id($id);

        if ($row) {
            $this->Branch_type_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('branch_type'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('branch_type'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('branch_type_name', 'branch type name', 'trim|required');
	$this->form_validation->set_rules('active', 'active', 'trim|required');
		
		

	$this->form_validation->set_rules('branch_type_id', 'branch_type_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Branch_type.php */
