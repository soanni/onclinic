<?php

class Patient extends CI_Controller{
    protected $_validation_rules = array(
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
                'exact_length'=>'SSN MUST be exactly 9 numbers long'
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
        ),
        array(
            'field'=>'passcode',
            'label'=>'Passcode',
            'rules'=>array('required','min_length[10]')
        )
    );

    ///////////////////////////////////////////////

    public function __construct(){
        parent::__construct();
        $this->load->model('patient_model');
        $this->load->helper('form');
        $this->load->helper('url_helper');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function edit($patientid){
        // only operators could see the edit page
        if(isset($_SESSION['is_operator']) && $_SESSION['is_operator']){
            $data = new stdClass();
            $data->title = 'Edit patient';
            $rules = $this->_validation_rules;
            if($patientid){
                $result = $this->patient_model->getRow($patientid);
                if(!is_null($result)){
                    $data->result = $result;
                    // remove validation rule for SSN
                    unset($rules[3]);
                    // new validation rule for SSN without uniqueness restriction
                    $rules[] = array(
                        'field'=>'ssn',
                        'label'=>'SSN',
                        'rules'=>array('integer','required','exact_length[9]'),
                        'errors'=>array(
                            'exact_length'=>'SSN MUST be exactly 9 numbers long'
                        )
                    );
                    $this->form_validation->set_rules($rules);
                    if($this->form_validation->run() === FALSE){
                        $this->load->view('patient/update',$data);
                    }else{
                        $patient_data = $this->input->post();
                        $patient_data['changedate'] = date('Y-m-j H:i:s');
                        if($this->patient_model->update($patient_data,$patientid)){
                            redirect('patient/index');
                        }else{
                            $data->error = 'The error occured during saving the patient in the database. Please,try again.';
                            $this->load->view('patient/update',$data);
                        }
                    }
                }
            }else{
                redirect('operator/profile');
            }
        }else{
            redirect('/');
        }
    }

    public function index(){
        // only operators could see the index page
        if(isset($_SESSION['is_operator']) && $_SESSION['is_operator']){
            $data = new stdClass();
            $data->title = 'Patients list';
            $data->result = $this->patient_model->getAllRows();
            $this->load->view('patient/list',$data);
        }else{
            redirect('/');
        }
    }

    public function create(){
        // only operators could see the index page
        if(isset($_SESSION['is_operator']) && $_SESSION['is_operator']){
            $data = new stdClass();
            $data->title = 'Create new patient';
            // generating random string
            $data->passcode = $this->generatePasscode();
            $rules = $this->_validation_rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() === FALSE){
                $this->load->view('patient/create',$data);
            }else{
                $patient_data = $this->input->post();
                if($this->patient_model->create($patient_data)){
                    redirect('patient/index');
                }else{
                    $data->error = 'The error occured during saving the patient in the database. Please,try again.';
                    $this->load->view('patient/create',$data);
                }
            }
        }else{
            redirect('/');
        }
    }

    public function lock($id = null){
        // only operators could lock the patient
        if(isset($_SESSION['is_operator']) && $_SESSION['is_operator']){
            if($id == null){
                redirect('operator/profile');
            }else{
                $this->patient_model->lockPatient($id);
                redirect('patient/index');
            }
        }else{
            redirect('/');
        }
    }

    public function unlock($id = null){
        // only operators could unlock the patient
        if(isset($_SESSION['is_operator']) && $_SESSION['is_operator']){
            if($id == null){
                redirect('operator/profile');
            }else{
                $this->patient_model->unlockPatient($id);
                redirect('patient/index');
            }
        }else{
            redirect('/');
        }
    }

    private function generatePasscode($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}