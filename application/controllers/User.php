<?php
/* 
 * Generated by CRUDigniter v2.1 Beta 
 * www.crudigniter.com
 */
 
class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
		else {
			if (!check_access($this->session->userdata('user_id'),'user')){
				redirect('auth/login', 'refresh');
			}
		}
        $this->load->model('User_model');
    } 

    /*
     * Listing of users
     */
    function index()
    {
        $data['users'] = $this->User_model->get_all_users_admin_by_group(2);
		//echo $this->db->last_query();
        $this->load->view('user/index',$data);
    }

    /*
     * Adding a new user
     */
    function add()
    {   
        $this->load->library('form_validation');

		$this->form_validation->set_rules('username','Username','max_length[100]|required');
		$this->form_validation->set_rules('password','Password','required|max_length[255]');
		$this->form_validation->set_rules('email','Email','required|max_length[100]|valid_email');
		$this->form_validation->set_rules('first_name','First Name','max_length[50]|required');
		$this->form_validation->set_rules('last_name','Last Name','max_length[50]|required');
		
		if($this->form_validation->run())     
        {  
        //$salt       = $this->store_salt ? $this->salt() : FALSE;
		//$password   = $this->hash_password($password);	
           /* $params = array(
				'username' => $this->input->post('username'),
				'password' => $password,
				'email' => $this->input->post('email'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company' => $this->input->post('company'),
				'phone' => $this->input->post('phone'),
            );*/
            $email    = strtolower($this->input->post('email'));
            $identity = $email;
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
            );
            //$user_id = $this->User_model->add_user($params,'2');
			$groups = array('2');
			$this->Ion_auth_model->register($identity, $password, $email, $additional_data,$groups);
            redirect('user/index');
        }
        else
        {
            $this->load->view('user/add');
        }
    }  

    /*
     * Editing a user
     */
    function edit($id)
    {   
        // check if the user exists before trying to edit it
        $user = $this->User_model->get_user($id);
        
        if(isset($user['id']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('username','Username','max_length[100]|required');
			$this->form_validation->set_rules('password','Password','required|max_length[255]');
			$this->form_validation->set_rules('email','Email','required|max_length[100]|valid_email');
			$this->form_validation->set_rules('first_name','First Name','max_length[50]|required');
			$this->form_validation->set_rules('last_name','Last Name','max_length[50]|required');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					'ip_address' => $this->input->post('ip_address'),
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password'),
					'salt' => $this->input->post('salt'),
					'email' => $this->input->post('email'),
					'activation_code' => $this->input->post('activation_code'),
					'forgotten_password_code' => $this->input->post('forgotten_password_code'),
					'forgotten_password_time' => $this->input->post('forgotten_password_time'),
					'remember_code' => $this->input->post('remember_code'),
					'created_on' => $this->input->post('created_on'),
					'modified_on' => $this->input->post('modified_on'),
					'last_login' => $this->input->post('last_login'),
					'active' => $this->input->post('active'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'company' => $this->input->post('company'),
					'phone' => $this->input->post('phone'),
                );

                $this->User_model->update_user($id,$params);            
                redirect('user/index');
            }
            else
            {   
                $data['user'] = $this->User_model->get_user($id);
    
                $this->load->view('user/edit',$data);
            }
        }
        else
            show_error('The user you are trying to edit does not exist.');
    } 

    /*
     * Deleting user
     */
    function remove($id)
    {
        $user = $this->User_model->get_user($id);

        // check if the user exists before trying to delete it
        if(isset($user['id']))
        {
            $this->User_model->delete_user($id);
            redirect('user/index');
        }
        else
            show_error('The user you are trying to delete does not exist.');
    }
    
}
