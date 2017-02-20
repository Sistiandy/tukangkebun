<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Logs controllers Class
 *
 * @package     SYSCMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Logs_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model('logs/Logs_model');
    }

    public function index() {
        $data['title'] = 'Log Aktifitas';
        $data['main'] = 'logs/list';
        $this->load->view('admin/layout', $data);
    }

    public function ajax_list() {
        $keys = $this->Logs_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($keys as $key) {
            $no++;
            $row = array();
            $row[] = $key->log_date;
            $row[] = $key->log_module;
            $row[] = $key->log_action;
            $row[] = $key->log_info;
            $row[] = $key->user_full_name;
            //add html for action
//            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$log->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
//                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$log->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Logs_model->count_all(),
            "recordsFiltered" => $this->Logs_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}
