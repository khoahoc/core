<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_admin extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        if (!$this->session->userdata('account')) {
            $this->message_model->pushAlertMessage('warning', 'Session expired! Please try to login again!');
            redirect('login');
        }
    }

    public function view($page = 'dashboard')
    {
        print_r($_SESSION);
        $data = '';
        $this->load
            ->view('admin/template/top', $data)
            ->view('admin/' . $page, $data)
            ->view('admin/template/bot', $data);
    }
    

}

/* End of file Pages_admin.php */
