<?php

class Patient_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function create($data){
        // passcode shouldn't be changed to lower case
        $passcode = $data['passcode'];
        unset($data['passcode']);
        // to lower case
        $data_lower = array_map(function($x){return strtolower($x);},$data);
        $help_array = array(
            'locked'=>'0',
            'changedate'=>date('Y-m-j H:i:s')
        );
        $data = array_merge($data_lower,$help_array,array('passcode'=>$passcode));
        return $this->db->insert('patients',$data);
    }

    public function getAllRows(){
        return $this->db->get('patients');
    }
}