<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

//implements User_interface
class Operator extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('operator_model');
        $this->load->helper('form');
        $this->load->helper('url_helper');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function login(){
        $data = new stdClass();
        $data->title = 'OnClinic Employee Login';
        $rules = array(
            array(
                'field'=>'username',
                'label'=>'Username',
                'rules'=>array('trim','required','alpha_numeric','min_length[4]')
            ),
            array(
                'field'=>'pass',
                'label'=>'Password',
                'rules'=>array('trim','required','min_length[6]')
            )
        );

        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/lab_header',$data);
            $this->load->view('operator/login', $data);
            $this->load->view('templates/lab_footer');
        }else{
            $username = $this->input->post('username');
            $password = $this->input->post('pass');
            $userrow = $this->operator_model->getUserRow($username);
            if(!empty($userrow)){
                // if user is locked then login is impossible
                if($userrow['locked']){
                    $data->error = "User {$username} is locked. You cannot proceed further.";
                }else{
                    // user is unlocked so we need to check the password correctness
                    $salt = $userrow['salt'];
                    $encrypted_pass = $userrow['pwd'];
                    if($this->operator_model->isValidPassword($password,$salt,$encrypted_pass)){
                        // set session variables
                        $_SESSION['user_id'] = (int)$userrow['user_id'];
                        $_SESSION['username'] = (string)$username;
                        $_SESSION['logged_in'] = (bool)true;
                        $_SESSION['is_operator'] = (bool)true;
                        $_SESSION['is_patient'] = (bool)false;
                        $redirect = site_url('operator/profile/' . $userrow['user_id']);
                        //remove after completing profile
                        //$data->error = 'You are logged in';
                        redirect($redirect);
                        exit;
                    }else{
                        $data->error = "Incorrect password provided. Please, try again";
                    }
                }
            }else{
                $data->error = "There is no such username {$username} in the system.";
            }
            $this->load->view('templates/lab_header',$data);
            $this->load->view('operator/login', $data);
            $this->load->view('templates/lab_footer');
        }
    }

    public function logout(){
        $data = new stdClass();
        $data->title = 'Log out';
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            // remove session data
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }
            session_destroy();
            // user logout ok
            redirect('/');
        } else {
            // there user was not logged in, we cannot logged him out,
            // redirect him to site root
            redirect('/');
        }
    }

    public function profile($userid = null){
        $this->load->view('operator/profile');
    }

}