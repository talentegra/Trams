<?php

/* Location: ./application/controllers/Courses.php */
/* Derived from Harviacode  */
/* Modified by Vivek Raghunathan 2016-06-27 18:48:37 */
/* Email : vivekra@dqserv.com */
/* http://dqserv.com */



if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Courses extends APP_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Courses_catalog_model');
		$this->load->model('Categories_model');
		$this->load->model('Course_fee_type_model');
        $this->load->library('form_validation');
		$this->load->library('Arbac');
		if(!$this->arbac->is_loggedin()){ redirect('scp/login'); }
    }

    public function index()
    {
        $data = array(
            'title' => 'TRAMS::SCP::courses_catalog',
            'sort_by' => 'DESC',
            'sort_column' => 'course_id',
			'q' => '',
			'total_rows' => ''
        );
        $this->_tpl('courses/courses_list', $data);
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
        $config['div'] = 'Courses_list'; //parent div tag id
        $config['base_url'] = base_url(). 'Courses/list_data';
        $config['total_rows'] = $this->Courses_catalog_model->total_rows($q);
        $config['per_page'] = $this->perPage;

        $this->ajax_pagination->initialize($config);

        //get the posts data
        $courses_data = $this->Courses_catalog_model->get_limit_data($config['per_page'], $offset,$sort_column ,$sort_by , $q);

        $data = array(
            'courses_data' => $courses_data,
            'page' => $page,
            'sort_by' => $sort_by,
            'sort_column' => $sort_column,
            'set_user_pagination_status' => $this->perPage,
            'title' => 'TRAMS | ',
            'primary_role_id' => $this->session->userdata('primary_role'),
			'total_rows' => $config['total_rows']
        );

        //load the view
        $this->load->view('courses/courses_list_data', $data);
    }

    public function read($id) 
    {
        $row = $this->Courses_catalog_model->get_by_id($id);
        if ($row) {
            $data = array(
			'title'  => 'TRAMS::SCP::Courses',
		'course_id' => $row->course_id,
		'category_id' => $row->category_id,
		'course_code' => $row->course_code,
		'course_name' => $row->course_name,
		'course_summary' => $row->course_summary,
		'course_contents' => $row->course_contents,
		'course_duration' => $row->course_duration,
		'course_fee_type' => $row->course_fee_type,
		'notes' => $row->notes,
		'active' => $row->active,
		'created' => $row->created,
		'updated' => $row->updated,
	    );
			$this->_tpl('courses/courses_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('courses'));
        }
    }

    public function create() 
    {
		$category_list = $this->Categories_model->get_all();
		$course_fee_type_list = $this->Course_fee_type_model->get_all();
        $data = array(
            'button' => 'Create',
            'action' => site_url('courses/create_action'),
			'title'  => 'TRAMS::SCP::Create Courses',
	    'course_id' => set_value('course_id'),
	    'category_id' => set_value('category_id'),
	    'course_code' => set_value('course_code'),
	    'course_name' => set_value('course_name'),
	    'course_summary' => set_value('course_summary'),
	    'course_contents' => set_value('course_contents'),
	    'course_duration' => set_value('course_duration'),
	    'course_fee_type' => set_value('course_fee_type'),
	    'notes' => set_value('notes'),
	    'created' => set_value('created'),
	    'updated' => set_value('updated'),
		'category_list' => $category_list,
		'course_fee_type_list' => $course_fee_type_list,
	);
          $this->_tpl('courses/courses_form', $data);	
		
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'category_id' => $this->input->post('category_id',TRUE),
		'course_code' => $this->input->post('course_code',TRUE),
		'course_name' => $this->input->post('course_name',TRUE),
		'course_summary' => $this->input->post('course_summary',TRUE),
		'course_contents' => $this->input->post('course_contents',TRUE),
		'course_duration' => $this->input->post('course_duration',TRUE),
		'course_fee_type' => $this->input->post('course_fee_type',TRUE),
		'notes' => $this->input->post('notes',TRUE),
		'created' => date('Y-m-d H:i:s'),
		'updated' => date('Y-m-d H:i:s'),
	    );

            $this->Courses_catalog_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('courses'));
        }
    }
    
    public function update($id) 
    {
		$category_list = $this->Categories_model->get_all();
		$course_fee_type_list = $this->Course_fee_type_model->get_all();
        $row = $this->Courses_catalog_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('courses/update_action'),
				'title'  => 'TRAMS::SCP::Update Courses',
		'course_id' => set_value('course_id', $row->course_id),
		'category_id' => set_value('category_id', $row->category_id),
		'course_code' => set_value('course_code', $row->course_code),
		'course_name' => set_value('course_name', $row->course_name),
		'course_summary' => set_value('course_summary', $row->course_summary),
		'course_contents' => set_value('course_contents', $row->course_contents),
		'course_duration' => set_value('course_duration', $row->course_duration),
		'course_fee_type' => set_value('course_fee_type', $row->course_fee_type),
		'notes' => set_value('notes', $row->notes),
		'active' => set_value('active', $row->active),
		'created' => set_value('created', $row->created),
		'updated' => set_value('updated', $row->updated),
		'category_list' => $category_list,
		'course_fee_type_list' => $course_fee_type_list,
	    );
			$this->_tpl('courses/courses_edit', $data);
		
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('courses'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('course_id', TRUE));
        } else {
            $data = array(
		'category_id' => $this->input->post('category_id',TRUE),
		'course_code' => $this->input->post('course_code',TRUE),
		'course_name' => $this->input->post('course_name',TRUE),
		'course_summary' => $this->input->post('course_summary',TRUE),
		'course_contents' => $this->input->post('course_contents',TRUE),
		'course_duration' => $this->input->post('course_duration',TRUE),
		'course_fee_type' => $this->input->post('course_fee_type',TRUE),
		'notes' => $this->input->post('notes',TRUE),
		
		'updated' => date('Y-m-d H:i:s'),
	    );

            $this->Courses_catalog_model->update($this->input->post('course_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('courses'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Courses_catalog_model->get_by_id($id);

        if ($row) {
            $this->Courses_catalog_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('courses'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('courses'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('category_id', 'category id', 'trim|required');
	$this->form_validation->set_rules('course_code', 'course code', 'trim|required');
	$this->form_validation->set_rules('course_name', 'course name', 'trim|required');
		
		

	$this->form_validation->set_rules('course_id', 'course_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function check_exist()
    {
    $val = $this->input->post('val');
	$col = $this->input->post('col');
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$res = $this->Courses_catalog_model->check_exist($val,$col,$id);
	if($res){
		echo 'false';
	}
	else {
		echo 'true';
	}
    }

}

/* End of file Courses.php */
