<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends BaseV1Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['head_title']           = $this->theme_config['site_title'].' - '.$this->theme_config['site_headding'];
        $this->data['meta_description']     = $this->theme_config['site_headding'];
        $this->data['meta_keywords']        = $this->theme_config['site_title'];
    }
    public function __destruct()
    {
        $this->db->close();
    }

    public function index()
    {
        $this -> view_render('contact');
    }
    public function form(){
        $this->load->library('email');

        $this->email->initialize(array(
          'protocol' => 'smtp',
          'smtp_host' => 'smtp.sendgrid.net',
          'smtp_user' => 'sendgridusername',
          'smtp_pass' => 'sendgridpassword',
          'smtp_port' => 587,
          'crlf' => "\r\n",
          'newline' => "\r\n"
        ));

        $this->email->from('your@example.com', 'Your Name');
        $this->email->to('someone@example.com');
        $this->email->cc('another@another-example.com');
        $this->email->bcc('them@their-example.com');
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');
        $this->email->send();

        echo $this->email->print_debugger();
    }

}