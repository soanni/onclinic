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
        $this->db->select('patient_id,firstname, lastname, age, sex, ssn, telephone, email, birthday, locked');
        $this->db->from('patients');
        $this->db->order_by('lastname','ASC');
        return $this->db->get()->result_array();
    }

    public function getRow($id){
        $query = $this->db->get_where('patients',array('patient_id'=>$id));
        return $query->row_array();
    }

    public function update($data,$id){
        $this->db->where('patient_id',$id);
        return $this->db->update('patients',$data);
    }

    public function lockPatient($id){
        $this->db->where('patient_id',$id);
        return $this->db->update('patients',array('changedate'=>date('Y-m-j H:i:s'),'locked'=>'1'));
    }

    public function unlockPatient($id){
        $this->db->where('patient_id',$id);
        return $this->db->update('patients',array('changedate'=>date('Y-m-j H:i:s'),'locked'=>'0'));
    }
}