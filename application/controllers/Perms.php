<?php

/* Location: ./application/controllers/Perms.php */
/* Derived from Harviacode  */
/* Modified by Vivek Raghunathan 2016-06-21 17:42:48 */
/* Email : vivekra@dqserv.com */
/* http://dqserv.com */



if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Perms extends APP_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Perms_model');
        $this->load->library('form_validation');
		$this->load->library('Arbac');
		if(!$this->arbac->is_loggedin()){ redirect('scp/login'); }
    }

    public function index()
    {
        $data = array(
            'title' => 'TRAMS::SCP::arbac_perms',
            'sort_by' => 'DESC',
            'sort_column' => 'id',
			'q' => '',
			'total_rows' => ''
        );
        $this->_tpl('perms/permissions_list', $data);
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
        $config['div'] = 'Perms_list'; //parent div tag id
        $config['base_url'] = base_url(). 'Perms/list_data';
        $config['total_rows'] = $this->Perms_model->total_rows($q);
        $config['per_page'] = $this->perPage;

        $this->ajax_pagination->initialize($config);

        //get the posts data
        $perms_data = $this->Perms_model->get_limit_data($config['per_page'], $offset,$sort_column ,$sort_by , $q);

        $data = array(
            'perms_data' => $perms_data,
            'page' => $page,
            'sort_by' => $sort_by,
            'sort_column' => $sort_column,
            'set_user_pagination_status' => $this->perPage,
            'title' => 'TRAMS | ',
            'primary_role_id' => $this->session->userdata('primary_role'),
			'total_rows' => $config['total_rows']
        );

        //load the view
        $this->load->view('perms/permissions_list_data', $data);
    }

    public function read($id) 
    {
        $row = $this->Perms_model->get_by_id($id);
        if ($row) {
            $data = array(
			'title'  => 'TRAMS::SCP::Perms',
		'id' => $row->id,
		'perm_type' => $row->perm_type,
		'name' => $row->name,
		'definition' => $row->definition,
	    );
			$this->_tpl('perms/permissions_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('perms'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('perms/create_action'),
			'title'  => 'TRAMS::SCP::Create Perms',
	    'id' => set_value('id'),
	    'perm_type' => set_value('perm_type'),
	    'name' => set_value('name'),
	    'definition' => set_value('definition'),
	);
          $this->_tpl('perms/permissions_form', $data);	
		
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'perm_type' => $this->input->post('perm_type',TRUE),
		'name' => $this->input->post('name',TRUE),
		'definition' => $this->input->post('definition',TRUE),
	    );

            $this->Perms_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('perms'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Perms_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('perms/update_action'),
				'title'  => 'TRAMS::SCP::Update Perms',
		'id' => set_value('id', $row->id),
		'perm_type' => set_value('perm_type', $row->perm_type),
		'name' => set_value('name', $row->name),
		'definition' => set_value('definition', $row->definition),
	    );
			$this->_tpl('perms/permissions_edit', $data);
		
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('perms'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'perm_type' => $this->input->post('perm_type',TRUE),
		'name' => $this->input->post('name',TRUE),
		'definition' => $this->input->post('definition',TRUE),
	    );

            $this->Perms_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('perms'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Perms_model->get_by_id($id);

        if ($row) {
            $this->Perms_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('perms'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('perms'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('perm_type', 'perm type', 'trim|required');
	$this->form_validation->set_rules('name', 'name', 'trim|required');
	$this->form_validation->set_rules('definition', 'definition', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Perms.php */
