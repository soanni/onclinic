<?php

class Patient extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('patient_model');
        $this->load->helper('form');
        $this->load->helper('url_helper');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index(){
        // will use inbuilt HTML Table class to autogenerate table from db
        $this->load->library('table');
        $template = array(
            'table_open'            => '<table border="0" cellpadding="4" cellspacing="0">',

            'thead_open'            => '<thead>',
            'thead_close'           => '</thead>',

            'heading_row_start'     => '<tr>',
            'heading_row_end'       => '</tr>',
            'heading_cell_start'    => '<th>',
            'heading_cell_end'      => '</th>',

            'tbody_open'            => '<tbody>',
            'tbody_close'           => '</tbody>',

            'row_start'             => '<tr>',
            'row_end'               => '</tr>',
            'cell_start'            => '<td>',
            'cell_end'              => '</td>',

            'table_close'           => '</table>'
        );
        $query = $this->patient_model->getAllRows();
    }

    public function create(){
        $data = new stdClass();
        $data->title = 'Create new patient';
        $rules = array(
            array(
                'field'=>'firstname',
                'label'=>'Firstname',
                'rules'=>array('alpha','trim','required','min_length[2]','max_length[40]')
            ),
            array(
                'field'=>'lastname',
                'label'=>'Lastname',
                'rules'=>array('alpha','trim','required','min_length[2]','max_length[40]')
            ),
            array(
                'field'=>'age',
                'label'=>'Age',
                'rules'=>array('integer','required','greater_than_equal_to[0]')
            ),
            // American SSN has exact length of 9 symbols
            // SSN must be unique
            array(
                'field'=>'ssn',
                'label'=>'SSN',
                'rules'=>array('integer','required','exact_length[9]','is_unique[patients.ssn]'),
                'errors'=>array(
                    'exact_length'=>'SSN MUST be exactly 9 numbers long',
                    ''
                )
            ),
            // for correctness of international phone format we use regex_match rule
            array(
                'field'=>'telephone',
                'label'=>'Phone',
                'rules'=>array('required','exact_length[14]','regex_match[/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i]'),
                'errors'=>array(
                    'regex_match'=>'Please provide the phone number in numeric format x-xxx-xxx-xxxx',
                    'exact_length'=>'Phone length should exactly 14 symbols x-xxx-xxx-xxxx'
                )
            ),
            array(
                'field'=>'email',
                'label'=>'Email',
                'rules'=>array('required','valid_email')
            ),
            array(
                'field'=>'birthday',
                'label'=>'Birthday',
                'rules'=>array('required')
            )
        );
        // automatically generating passcode
        //$data->passcode = $this->generatePasscode();
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() === FALSE){
            $this->load->view('patient/create',$data);
        }else{
            $patient_data = $this->input->post();
            if($this->patient_model->create($patient_data)){
                redirect('patients/list');
            }else{
                $data->error = 'The error occured during saving the patient in the database. Please,try again.';
                $this->load->view('patient/create',$data);
            }
        }
    }

    public function phone_check($str){

    }

//    private function generatePasscode(){
//
//    }
}