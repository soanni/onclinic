<?php

interface User_interface{
    public function login();
    public function logout();
    public function profile($userid);
}