<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users controllers Class
 *
 * @package     SYSCMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Users_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model('users/Users_model');
    }

    public function index() {
        $data['users'] = $this->Users_model->get();
        $data['title'] = 'Pengguna';
        $data['main'] = 'users/list';
        $this->load->view('admin/layout', $data);
    }

    public function ajax_list() {
        $keys = $this->Users_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($keys as $key) {
            $no++;
            $row = array();
            $row[] = $key->user_full_name;
            $row[] = $key->user_email;
            $row[] = $key->role_name;

            //add html for action
            $row[] = btn_list('users', $key->user_id, $key->user_full_name) ;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Users_model->count_all(),
            "recordsFiltered" => $this->Users_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    // Add User and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');

        if (!$this->input->post('user_id')) {
            $this->form_validation->set_rules('user_password', 'Password', 'trim|required|xss_clean|min_length[6]');
            $this->form_validation->set_rules('passconf', 'Konfirmasi password', 'trim|required|xss_clean|min_length[6]|matches[user_password]');
            $this->form_validation->set_rules('user_name', 'Username', 'trim|required|xss_clean|is_unique[users.user_name]');
            $this->form_validation->set_message('passconf', 'Password dan konfirmasi password tidak cocok');
        }
        $this->form_validation->set_rules('role_id', 'Peran', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user_full_name', 'Nama lengkap', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user_pob', 'Tempat lahir', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user_dob', 'Tanggal lahir', 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            if ($this->input->post('user_id')) {
                $params['user_id'] = $id;
            } else {
                $params['user_input_date'] = date('Y-m-d H:i:s');
                $params['user_name'] = $this->input->post('user_name');
                $params['user_password'] = sha1($this->input->post('user_password'));
            }
            $params['user_role_role_id'] = $this->input->post('role_id');
            $params['user_full_name'] = $this->input->post('user_full_name');
            $params['user_email'] = $this->input->post('user_email');
            $params['user_pob'] = $this->input->post('user_pob');
            $params['user_dob'] = $this->input->post('user_dob');
            $params['user_last_update'] = date('Y-m-d H:i:s');
            $status = $this->Users_model->add($params);

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Users',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('user_name')
                    )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' Petugas Berhasil');
            redirect('admin/users');
        } else {
            if ($this->input->post('user_id')) {
                redirect('admin/users/edit/' . $this->input->post('user_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $object = $this->Users_model->get(array('id' => $id));
                if ($object == NULL) {
                    redirect('admin/users');
                } else {
                    $data['user'] = $object;
                }
            }
            $data['roles'] = $this->Users_model->get_roles();
            $data['title'] = $data['operation'] . ' Pengguna';
            $data['main'] = 'users/add';
            $this->load->view('admin/layout', $data);
        }
    }

    // View data detail
    public function view($id = NULL) {
        $data['user'] = $this->Users_model->get(array('id' => $id));
        $data['title'] = 'Pengguna';
        $data['main'] = 'users/view';
        $this->load->view('admin/layout', $data);
    }

    // Delete to database
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Users_model->delete($id);
            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $id,
                        'log_module' => 'Users',
                        'log_action' => 'Hapus',
                        'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
                    )
            );
            $this->session->set_flashdata('success', 'Hapus Pengguna berhasil');
            redirect('admin/users');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/users/edit/' . $id);
        }
    }

}
