<?php

/* Location: ./application/controllers/Followup_status_code.php */
/* Derived from Harviacode  */
/* Modified by Vivek Raghunathan 2016-06-21 15:49:16 */
/* Email : vivekra@dqserv.com */
/* http://dqserv.com */



if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Followup_status_code extends APP_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Followup_status_code_model');
        $this->load->library('form_validation');
		$this->load->library('Arbac');
		if(!$this->arbac->is_loggedin()){ redirect('scp/login'); }
    }

    public function index()
    {
        $data = array(
            'title' => 'TRAMS::SCP::followup_status_code',
            'sort_by' => 'DESC',
            'sort_column' => 'followup_status_id',
			'q' => '',
			'total_rows' => ''
        );
        $this->_tpl('followup_status_code/followup_status_code_list', $data);
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
        $config['div'] = 'Followup_status_code_list'; //parent div tag id
        $config['base_url'] = base_url(). 'Followup_status_code/list_data';
        $config['total_rows'] = $this->Followup_status_code_model->total_rows($q);
        $config['per_page'] = $this->perPage;

        $this->ajax_pagination->initialize($config);

        //get the posts data
        $followup_status_code_data = $this->Followup_status_code_model->get_limit_data($config['per_page'], $offset,$sort_column ,$sort_by , $q);

        $data = array(
            'followup_status_code_data' => $followup_status_code_data,
            'page' => $page,
            'sort_by' => $sort_by,
            'sort_column' => $sort_column,
            'set_user_pagination_status' => $this->perPage,
            'title' => 'TRAMS | ',
            'primary_role_id' => $this->session->userdata('primary_role'),
			'total_rows' => $config['total_rows']
        );

        //load the view
        $this->load->view('followup_status_code/followup_status_code_list_data', $data);
    }

    public function read($id) 
    {
        $row = $this->Followup_status_code_model->get_by_id($id);
        if ($row) {
            $data = array(
			'title'  => 'TRAMS::SCP::Followup_status_code',
		'followup_status_id' => $row->followup_status_id,
		'followup_status' => $row->followup_status,
		'active' => $row->active,
		'created' => $row->created,
		'updated' => $row->updated,
	    );
			$this->_tpl('followup_status_code/followup_status_code_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('followup_status_code'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('followup_status_code/create_action'),
			'title'  => 'TRAMS::SCP::Create Followup_status_code',
	    'followup_status_id' => set_value('followup_status_id'),
	    'followup_status' => set_value('followup_status'),
	    'active' => set_value('active'),
	    'created' => set_value('created'),
	    'updated' => set_value('updated'),
	);
          $this->_tpl('followup_status_code/followup_status_code_form', $data);	
		
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'followup_status' => $this->input->post('followup_status',TRUE),
		'active' => $this->input->post('active',TRUE),
		'created' => date('Y-m-d H:i:s'),
		'updated' => date('Y-m-d H:i:s'),
	    );

            $this->Followup_status_code_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('followup_status_code'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Followup_status_code_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('followup_status_code/update_action'),
				'title'  => 'TRAMS::SCP::Update Followup_status_code',
		'followup_status_id' => set_value('followup_status_id', $row->followup_status_id),
		'followup_status' => set_value('followup_status', $row->followup_status),
		'active' => set_value('active', $row->active),
		'created' => set_value('created', $row->created),
		'updated' => set_value('updated', $row->updated),
	    );
			$this->_tpl('followup_status_code/followup_status_code_edit', $data);
		
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('followup_status_code'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('followup_status_id', TRUE));
        } else {
            $data = array(
		'followup_status' => $this->input->post('followup_status',TRUE),
		'active' => $this->input->post('active',TRUE),
		
		'updated' => date('Y-m-d H:i:s'),
	    );

            $this->Followup_status_code_model->update($this->input->post('followup_status_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('followup_status_code'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Followup_status_code_model->get_by_id($id);

        if ($row) {
            $this->Followup_status_code_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('followup_status_code'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('followup_status_code'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('followup_status', 'followup status', 'trim|required');
	$this->form_validation->set_rules('active', 'active', 'trim|required|numeric');
		
		

	$this->form_validation->set_rules('followup_status_id', 'followup_status_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Followup_status_code.php */
