<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->library('session');
	}

	public function index()
	{
		$data = new stdClass();
		$data->title = 'OnClinic Home';
		$this->load->view('templates/lab_header',$data);
		$this->load->view('general/home');
		$this->load->view('templates/lab_footer');
	}

	public function services(){
		$data = new stdClass();
		$data->title = 'OnClinic Services';
		$this->load->view('templates/lab_header', $data);
		$this->load->view('general/services');
		$this->load->view('templates/lab_footer');
	}
}
