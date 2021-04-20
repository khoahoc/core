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

    private function page_assets($page)
    {   
        switch ($page) {
            case 'dashboard':
                // Javascript list
                $asset['scripts'] = array(
                    // <!-- Page level plugins -->
                    '<script src="/public/admin/vendor/chart.js/Chart.min.js"></script>',
                    // <!-- Page level custom scripts -->
                    '<script src="/public/admin/js/demo/chart-area-demo.js"></script>',
                    '<script src="/public/admin/js/demo/chart-pie-demo.js"></script>'
                );
                // CSS list
                $asset['styles'] = array(
                    '',
                );
                // Database data
                // $asset['data'] = $this->user_model->get_all();
                break;
            case 'documents':
                // Database data
                $asset['data'] = $this->document_model->get_all();
                break;
            case 'users':
                // Javascript list
                $asset['scripts'] = array(
                    // <!-- Page level plugins -->
                    '<script src="/public/admin/vendor/datatables/jquery.dataTables.min.js"></script>',
                    '<script src="/public/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>',
                    // <!-- Page level custom scripts -->
                    '<script src="/public/admin/js/demo/datatables-demo.js"></script>'
                );
                // CSS list
                $asset['styles'] = array(
                    '<link href="/public/admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">',
                );
                // Database data
                $asset['users'] = $this->user_model->get_all();
                break;

            case 'tasks':
                // Javascript list
                $asset['scripts'] = array(
                    // <!-- Page level plugins -->
                    '<script src="/public/admin/vendor/datatables/jquery.dataTables.min.js"></script>',
                    '<script src="/public/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>',
                    // <!-- Page level custom scripts -->
                    '<script src="/public/admin/js/demo/datatables-demo.js"></script>',
                );
                // CSS list
                $asset['styles'] = array(
                    '<link href="/public/admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">',
                );
                // Database data
                $asset['tasks'] = $this->task_model->get_all_join();
                $asset['task_statuses'] = $this->task_model->get_all('task_statuses');
                $asset['task_priorities'] = $this->task_model->get_all('task_priorities');
                $asset['users'] = $this->user_model->get_all();
                break;

            case 'task_detail':
                
                // Database data
                $id = $this->input->get('id');
                $asset['tasks'] = $this->task_model->get_all_join();
                for ($i=0; $i < count($asset['tasks']); $i++) { 
                    if($asset['tasks'][$i]['task_id'] == $id)
                        $asset['task'] = $asset['tasks'][$i];
                }
                if(! isset($asset['task']))
                    show_404();
                $asset['task_statuses'] = $this->task_model->get_all('task_statuses');
                $asset['task_priorities'] = $this->task_model->get_all('task_priorities');
                $asset['users'] = $this->user_model->get_all();
                $asset['comments'] = $this->comment_model->get_all();
                break;

                

            default:
                break;
        }
        return $asset;
    }

    public function view($page = 'dashboard')
    {

        $data = array(
            'assets' => $this->page_assets($page),
            'account' => $this->user_model->get_one_by_email($this->session->userdata('account')),
            'title' => ucfirst($page),
            'page' => $page,
        );

        $this->load
            ->view('admin/template/header', $data)
            ->view('admin/' . $page, $data)
            ->view('admin/template/footer', $data);
    }
    

}

/* End of file Pages_admin.php */
