<?php

/* Location: ./application/controllers/Designation.php */
/* Derived from Harviacode  */
/* Modified by Vivek Raghunathan 2016-06-21 15:48:30 */
/* Email : vivekra@dqserv.com */
/* http://dqserv.com */



if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Designation extends APP_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Designation_model');
        $this->load->library('form_validation');
		$this->load->library('Arbac');
		if(!$this->arbac->is_loggedin()){ redirect('scp/login'); }
    }

    public function index()
    {
        $data = array(
            'title' => 'TRAMS::SCP::designation',
            'sort_by' => 'DESC',
            'sort_column' => 'id',
			'q' => '',
			'total_rows' => ''
        );
        $this->_tpl('designation/designation_list', $data);
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
        $config['div'] = 'Designation_list'; //parent div tag id
        $config['base_url'] = base_url(). 'Designation/list_data';
        $config['total_rows'] = $this->Designation_model->total_rows($q);
        $config['per_page'] = $this->perPage;

        $this->ajax_pagination->initialize($config);

        //get the posts data
        $designation_data = $this->Designation_model->get_limit_data($config['per_page'], $offset,$sort_column ,$sort_by , $q);

        $data = array(
            'designation_data' => $designation_data,
            'page' => $page,
            'sort_by' => $sort_by,
            'sort_column' => $sort_column,
            'set_user_pagination_status' => $this->perPage,
            'title' => 'TRAMS | ',
            'primary_role_id' => $this->session->userdata('primary_role'),
			'total_rows' => $config['total_rows']
        );

        //load the view
        $this->load->view('designation/designation_list_data', $data);
    }

    public function read($id) 
    {
        $row = $this->Designation_model->get_by_id($id);
        if ($row) {
            $data = array(
			'title'  => 'TRAMS::SCP::Designation',
		'id' => $row->id,
		'name' => $row->name,
		'position' => $row->position,
		'created' => $row->created,
		'updated' => $row->updated,
	    );
			$this->_tpl('designation/designation_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('designation'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('designation/create_action'),
			'title'  => 'TRAMS::SCP::Create Designation',
	    'id' => set_value('id'),
	    'name' => set_value('name'),
	    'position' => set_value('position'),
	    'created' => set_value('created'),
	    'updated' => set_value('updated'),
	);
          $this->_tpl('designation/designation_form', $data);	
		
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
		'position' => $this->input->post('position',TRUE),
		'created' => date('Y-m-d H:i:s'),
		'updated' => date('Y-m-d H:i:s'),
	    );

            $this->Designation_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('designation'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Designation_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('designation/update_action'),
				'title'  => 'TRAMS::SCP::Update Designation',
		'id' => set_value('id', $row->id),
		'name' => set_value('name', $row->name),
		'position' => set_value('position', $row->position),
		'created' => set_value('created', $row->created),
		'updated' => set_value('updated', $row->updated),
	    );
			$this->_tpl('designation/designation_edit', $data);
		
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('designation'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
		'position' => $this->input->post('position',TRUE),
		
		'updated' => date('Y-m-d H:i:s'),
	    );

            $this->Designation_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('designation'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Designation_model->get_by_id($id);

        if ($row) {
            $this->Designation_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('designation'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('designation'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('name', 'name', 'trim|required');
	$this->form_validation->set_rules('position', 'position', 'trim|required|numeric');
		
		

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Designation.php */
