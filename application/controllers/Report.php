<?php

class Report extends CI_Controller{
    protected $_validation_rules = array(
        array(
            'field'=>'patient',
            'label'=>'Patient',
            'rules'=>array('required')
        ),
        array(
            'field'=>'doctor',
            'label'=>'Doctor',
            'rules'=>array('required')
        )
    );

    public function __construct(){
        parent::__construct();
        $this->load->model('report_model');
        $this->load->helper('form');
        $this->load->helper('url_helper');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function create(){
        // only operators could see report create page
        if(isset($_SESSION['is_operator']) && $_SESSION['is_operator']){
            $data = new stdClass();
            $data->title = 'Create new report';
            $data->patients = $this->report_model->getPatients();
            $data->doctors = $this->report_model->getDoctors();
            $data->tests = $this->report_model->getTests();
            $this->form_validation->set_rules($this->_validation_rules);
            if($this->form_validation->run() === FALSE){
                $this->load->view('report/create',$data);
            }else{
                $results = $this->input->post();
                if($this->report_model->insertReportWithDetails($results)){
                    redirect('operator/profile');
                }else{
                    $data->error = 'The error occured during saving the report in the database. Please,try again.';
                    $this->load->view('report/create',$data);
                }
            }
        }else{
            redirect('/');
        }
    }

    public function index($patientid = null){
        $data = new stdClass();
        $data->title = 'List of reports';
        if(!is_null($patientid) && is_numeric($patientid)){

        }else{
            $patients = $this->report_model->getPatients();
            $data->patients = $patients;
            $reports = array();
            foreach($patients as $id=>$name){
                $reports[$id] = $this->report_model->get_reports_list($id);
            }
            $data->reports = $reports;
            $this->load->view('report/list',$data);
        }
    }

    public function view($reportid){
        if(!is_null($reportid) && is_numeric($reportid)){
            $data = new stdClass();
            $data->title = "Detailed report";
            $head = $this->report_model->getReportHead($reportid);
            $details = $this->report_model->getReportDetails($reportid);
            $data->head = $head[0];
            $data->details = $details;
            $this->load->view('report/view',$data);
        }else{
            redirect('report/index');
        }
    }
}