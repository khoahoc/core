<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function view()
    {
        if ($this->session->userdata('account'))
            redirect('admin/dashboard');

        $this->load->view('login/login');
    }

    public function verify()
    {
        // Kiểm tra là GET hay POST
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            // User input
            $email = $this->input->post('login-email');
            $password = $this->input->post('login-password');

            // Options for checking user input
            $this->form_validation->set_rules('login-email', 'Email', 'trim|required|min_length[5]|max_length[50]|valid_email');
            $this->form_validation->set_rules('login-password', 'Password', 'trim|required|min_length[5]|max_length[255]');

            // Handle checking input 
            if ($this->form_validation->run() == TRUE) {
                // Kiểm tra account có chính xác không
                if($this->user_model->verify_login($email, $password))
                {
                    $this->session->set_userdata('account', $email);
                    $this->utils_model->pushAlertMessage('success', 'Đăng nhập thành công!');
                    redirect('admin/dashboard');
                }
                else 
                {
                    $this->utils_model->pushAlertMessage('warning', 'Tài khoản hoặc mật khẩu không đúng!');
                    redirect('login');
                }
                
            }
            // Send error because input not valid
            else
            {
                $this->utils_model->pushAlertMessage('warning', validation_errors());
                redirect('login');
            }
        } 
        else
        {
            $this->utils_model->pushAlertMessage('warning', 'We doesn\'t support GET method for this URL! 🤞');
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('account');
        $this->utils_model->pushAlertMessage('success', "Log out system successfully!");
        redirect('login');
    }

}

/* End of file Login.php */
