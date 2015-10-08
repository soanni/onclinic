<?php

class Operator_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function getUserRow($username){
        $username = strtolower($username);
        $query = $this->db->get_where('operators',array('username' => $username));
        return $query->row_array();
    }

    public function isValidPassword($password,$salt,$encrypted_pass){
        return ($encrypted_pass == sha1($password . $salt));
    }
}