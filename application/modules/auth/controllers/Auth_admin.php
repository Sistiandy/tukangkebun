<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Auth controllers class
 *
 * @package     SIJPT
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Auth_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('users/Users_model');
        $this->load->library('form_validation');
        $this->load->helper('string');
    }

    function index() {
        redirect('admin/auth/login');
    }

    function login() {
        if ($this->session->userdata('logged')) {
            redirect('admin');
        }
        if ($this->input->post('location')) {
            $location = $this->input->post('location');
        } else {
            $location = NULL;
        }
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($_POST AND $this->form_validation->run() == TRUE) {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->Users_model->get(array('username' => $username, 'password' => sha1($password)));

            if (count($user) > 0) {
                $this->session->set_userdata('logged', TRUE);
                $this->session->set_userdata('uid', $user[0]['user_id']);
                $this->session->set_userdata('uname', $user[0]['user_name']);
                $this->session->set_userdata('uemail', $user[0]['user_email']);
                $this->session->set_userdata('ufullname', $user[0]['user_full_name']);
                $this->session->set_userdata('uroleid', $user[0]['user_role_role_id']);
                $this->session->set_userdata('urolename', $user[0]['role_name']);
                if ($location != '') {
                    header("Location:" . htmlspecialchars($location));
                } else {
                    redirect('admin');
                }
            } else {
                if ($location != '') {
                    $this->session->set_flashdata('failed', 'Maaf, username dan password tidak cocok!');
                    header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($location));
                } else {
                    $this->session->set_flashdata('failed', 'Maaf, username dan password tidak cocok!');
                    redirect('admin/auth/login');
                }
            }
        } else {
            $this->load->view('admin/login');
        }
    }

    // Logout Processing
    function logout() {
        $this->session->unset_userdata('logged');
        $this->session->unset_userdata('uid');
        $this->session->unset_userdata('uname');
        $this->session->unset_userdata('uemail');
        $this->session->unset_userdata('ufullname');
        $this->session->unset_userdata('uroleid');
        $this->session->unset_userdata('urolename');

        $q = $this->input->get(NULL, TRUE);
        if ($q['location'] != NULL) {
            $location = $q['location'];
        } else {
            $location = NULL;
        }
        header("Location:" . $location);
    }

}
