<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Merchants controllers Class
 *
 * @package     SYSCMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Merchants_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model('merchants/Merchants_model');
    }

    public function index() {
        $data['merchants'] = $this->Merchants_model->get();
        $data['title'] = 'Pedagang';
        $data['main'] = 'merchants/list';
        $this->load->view('admin/layout', $data);
    }

    public function ajax_list() {
        $keys = $this->Merchants_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($keys as $key) {
            $no++;
            $row = array();
            $row[] = $key->merchant_name;
            $row[] = $key->merchant_owner_name;
            $row[] = $key->merchant_phone;
            $row[] = $key->merchant_email;

            //add html for action
            $row[] = btn_list('merchants', $key->merchant_id, $key->merchant_name) ;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Merchants_model->count_all(),
            "recordsFiltered" => $this->Merchants_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    // Add User and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');

        if (!$this->input->post('merchant_id')) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[6]');

            $this->form_validation->set_rules('passconf', 'Konfirmasi password', 'trim|required|xss_clean|min_length[6]|matches[password]');

            $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|is_unique[merchants.username]');
            $this->form_validation->set_message('passconf', 'Password dan konfirmasi password tidak cocok');
        }
        $this->form_validation->set_rules('merchant_name', 'Nama Toko', 'trim|required|xss_clean');
        $this->form_validation->set_rules('merchant_phone', 'No. Telepon', 'trim|required|xss_clean');
        $this->form_validation->set_rules('merchant_email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('merchant_address', 'Alamat', 'trim|required|xss_clean');
        $this->form_validation->set_rules('merchant_owner_name', 'Nama Pemilik', 'trim|required|xss_clean');
        $this->form_validation->set_rules('merchant_owner_phone', 'No.Telepon Pemilik', 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            if ($this->input->post('merchant_id')) {
                $params['merchant_id'] = $id;
            } else {
                $params['merchant_input_date'] = date('Y-m-d H:i:s');
                $params['username'] = $this->input->post('username');
                $params['password'] = sha1($this->input->post('password'));
                $params['merchant_is_deleted'] =  false;
            }
            $params['merchant_name'] = $this->input->post('merchant_name');
            $params['merchant_phone'] = $this->input->post('merchant_phone');
            $params['merchant_email'] = $this->input->post('merchant_email');
            $params['merchant_address'] = $this->input->post('merchant_address');
            $params['merchant_owner_name'] = $this->input->post('merchant_owner_name');
            $params['merchant_owner_phone'] = $this->input->post('merchant_owner_phone');
            $params['users_user_id'] = $this->input->post('user_id');
            $params['merchant_last_update'] = date('Y-m-d H:i:s');
            $params['users_user_id'] = $this->session->userdata('uid');
            $status = $this->Merchants_model->add($params);

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Pedagang',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('merchant_name')
                    )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' Pedagang Berhasil');
            redirect('admin/merchants');
        } else {
            if ($this->input->post('merchant_id')) {
                redirect('admin/merchants/edit/' . $this->input->post('merchant_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $object = $this->Merchants_model->get(array('id' => $id));
                if ($object == NULL) {
                    redirect('admin/merchants');
                } else {
                    $data['merchant'] = $object;
                }
            }
            $data['title'] = $data['operation'] . ' Pedagang';
            $data['main'] = 'merchants/add';
            $this->load->view('admin/layout', $data);
        }
    }

    // View data detail
    public function view($id = NULL) {
        $data['merchant'] = $this->Merchants_model->get(array('id' => $id));
        $data['title'] = 'Pedagang';
        $data['main'] = 'merchants/view';
        $this->load->view('admin/layout', $data);
    }

    // Delete to database
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Merchants_model->delete($id);
            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $id,
                        'log_module' => 'Pedagang',
                        'log_action' => 'Hapus',
                        'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
                    )
            );
            $this->session->set_flashdata('success', 'Hapus Pedagang berhasil');
            redirect('admin/merchants');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/merchants/edit/' . $id);
        }
    }

}
