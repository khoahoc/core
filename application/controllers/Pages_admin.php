<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_admin extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        if (!$this->session->userdata('account')) {
            $this->utils_model->pushAlertMessage('warning', 'Session expired! Please try to login again!');
            redirect('login');
        }
    }

    public function view($page = 'dashboard')
    {
        $data = array(
            'page' => $page,
        );
        $this->load
            ->view('admin/template/header', $data)
            ->view('admin/' . $page, $data)
            ->view('admin/template/footer', $data);
    }
    

}

/* End of file Pages_admin.php */
