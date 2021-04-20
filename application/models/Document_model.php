<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Document_model extends CI_Model {
    public function get_all($table = 'documents')
    {
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function verify_login($email, $password)
    {
        $this->db
                ->select('*')
                ->from('users')
                ->where('user_email', $email)
                ->where('user_password', sha1($password.$this->config->item('encryption_key')));
                        
        $query = $this->db->get();
        if($query->num_rows() == 1)
            return TRUE;
        else 
            return FALSE;
    }

    public function get_one_by_email($email)
    {
        $this->db
                ->select('*')
                ->from('users')
                ->where('user_email', $email);
                        
        $query = $this->db->get();
        if($query->num_rows() == 1)
            return $query->row_array();
        else 
            return FALSE;
    }
    public function get_one_by_id($id)
    {
        $this->db
                ->select('*')
                ->from('users')
                ->where('user_id', $id);
                        
        $query = $this->db->get();
        if($query->num_rows() == 1)
            return $query->row_array();
        else 
            return FALSE;
    }
    
    public function get($number)
    {
        $query = $this->db->get('users', $number);
        return $query->result();
    }

    public function add($data)
    {
        $this->db->insert('users', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
    }

    public function remove($id)
    {
        $this->db->delete('users', array('user_id' => $id));
    }
    

}

/* End of file Document_model.php */
