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
            if((isset($_SESSION['is_operator']) && $_SESSION['is_operator']) ||
                (isset($_SESSION['is_patient']) && $_SESSION['is_patient'] && $_SESSION['user_id'] == $patientid)){
                $this->load->model('patient_model');
                $patient_row = $this->patient_model->getRow($patientid);
                $fullname = ucfirst($patient_row['lastname']) . ' ' . ucfirst($patient_row['firstname']);
                $data->heading = "List of reports, {$fullname}";
                $patients[$patientid] = $fullname;
                $data->patients = $patients;
                $reports = array();
                foreach($patients as $id=>$name){
                    $reports[$id] = $this->report_model->get_reports_list($id);
                }
                $data->reports = $reports;
                $this->load->view('report/list',$data);
            }else{
                redirect('/');
            }
        }else{
            // only for operators
            if(isset($_SESSION['is_operator']) && $_SESSION['is_operator']){
                $patients = $this->report_model->getPatients();
                $data->patients = $patients;
                $reports = array();
                foreach($patients as $id=>$name){
                    $reports[$id] = $this->report_model->get_reports_list($id);
                }
                $data->reports = $reports;
                $data->heading = 'List of ALL reports';
                $this->load->view('report/list',$data);
            }else{
                redirect('/');
            }
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

    //send PDF on email
    public function sendPdf($reportid){
        $this->load->library('My_PHPMailer');
        $file = $this->exportToPdf($reportid,'F');
        $head = $this->report_model->getReportHead($reportid);
        $recipient = $head[0]['firstname'] . " ". $head[0]['lastname'];
        if($this->send_email($head[0]['email'], $file, 'report.pdf', $recipient)){
            $this->view($reportid);
        }
    }

    ///////////////////////////////////////////////////////////////////
    public function exportToPdf($reportid,$flag = D){
        $filename = "report{$reportid}" . time();
        $pdfFilePath = str_replace('/','',FCPATH . DIRECTORY_SEPARATOR . "downloads" . DIRECTORY_SEPARATOR . "{$filename}" . ".pdf");
        $data = new stdClass();
        if (file_exists($pdfFilePath) == FALSE){
            ini_set('memory_limit','32M');
            $head = $this->report_model->getReportHead($reportid);
            $details = $this->report_model->getReportDetails($reportid);
            $data->head = $head[0];
            $data->details = $details;
            //render the view into HTML
            $html = $this->load->view('report/pdf_view', $data, true);
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
            $pdf->WriteHTML($html);
            // save to file
            $pdf->Output($pdfFilePath, $flag);
            if($flag == 'F'){
                return $pdfFilePath;
            }
        }
    }

    private function send_email($destination, $filepath, $filename, $recipient){
        $data = new stdClass();
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host       = "smtp.mail.ru";
        $mail->Port       = 465;
        $mail->Username   = "crossover_trial@mail.ru";
        $mail->Password   = "jd5xugLMrr";
        $mail->SetFrom('crossover_trial@mail.ru', 'Webmaster');
        $mail->AddReplyTo('crossover_trial@mail.ru', 'Andrey Andreev');
        $mail->Subject    = "PDF Report From Onclinic Samara";
        $mail->Body      = "Hello, {$recipient}. The requested PDF report is attached to this email. Best regards, OnClinic Samara";
        $mail->AltBody    = "Plain text message";
        $mail->AddAddress($destination, $recipient);
        $mail->AddAttachment($filepath, $filename);
        if(!$mail->Send()){
            $data->heading = "Mail Error";
            $data->message = "Error: " . $mail->ErrorInfo;
            $this->load->view('errors/html/error_general', $data);
            return 0;
        } else {
            return 1;
        }
    }
}