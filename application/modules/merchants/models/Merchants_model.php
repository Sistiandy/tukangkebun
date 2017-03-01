<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Merchant Model Class
 *
 * @package     SYSCMS
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Merchants_model extends CI_Model {

    var $table = 'merchants';
    var $all_column = array('merchants.merchant_id', 'password', 'merchant_name', 'merchant_phone', 'phone_is_whatsapp', 'merchant_email', 'merchant_logo', 'merchant_cover', 'merchant_description',
        'merchant_address', 'merchant_web', 'merchant_facebook', 'merchant_twitter', 'merchant_pob', 'merchant_dob', 'merchant_owner_name', 'merchant_owner_phone', 'merchant_owner_ktp', 'merchant_status', 'merchant_package', 'merchant_is_deleted', 'merchant_input_date', 'merchant_last_update'); //set all column field database
    var $order = array('merchant_last_update' => 'desc'); // default order 

    function __construct() {
        parent::__construct();
    }

    private function _get_datatables_query() {

        $this->db->from($this->table);
        $this->db->where('merchant_is_deleted', FALSE);

        $i = 0;

        foreach ($this->all_column as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->all_column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->all_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $this->db->select('merchants.merchant_id, password, merchant_name, merchant_email, merchant_phone, phone_is_whatsapp, merchant_address, merchant_logo, merchant_cover, merchant_description, merchant_web, merchant_facebook, merchant_twitter, merchant_pob, merchant_dob, merchant_owner_name, merchant_owner_phone, merchant_owner_ktp, merchant_is_deleted, merchant_status, merchant_package, merchant_input_date, merchant_last_update');
        $this->db->select('merchants.province_province_id, province.province_name');
        $this->db->select('merchants.kabupaten_kabupaten_id, kabupaten.kabupaten_name');

        $this->db->join('province', 'province.province_id = merchants.province_province_id', 'left');
        $this->db->join('kabupaten', 'kabupaten.kabupaten_id = merchants.kabupaten_kabupaten_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Get From Databases
    function get($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('merchants.merchant_id', $params['id']);
        }

        if (isset($params['password'])) {
            $this->db->where('password', $params['password']);
        }
        $this->db->where('merchant_is_deleted', FALSE);

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('merchant_last_update', 'desc');
        }

        $this->db->select('merchants.merchant_id, password, merchant_name, merchant_email, merchant_phone, phone_is_whatsapp, merchant_address, merchant_logo, merchant_cover, merchant_description, merchant_web, merchant_facebook, merchant_twitter, merchant_pob, merchant_dob, merchant_owner_name, merchant_owner_phone, merchant_owner_ktp, merchant_is_deleted, merchant_status, merchant_package, merchant_input_date, merchant_last_update');
        $this->db->select('merchants.province_province_id, province.province_name');
        $this->db->select('merchants.kabupaten_kabupaten_id, kabupaten.kabupaten_name');

        $this->db->join('province', 'province.province_id = merchants.province_province_id', 'left');
        $this->db->join('kabupaten', 'kabupaten.kabupaten_id = merchants.kabupaten_kabupaten_id', 'left');
        $res = $this->db->get('merchants');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function add($data = array()) {

        if (isset($data['merchant_id'])) {
            $this->db->set('merchant_id', $data['merchant_id']);
        }

        if (isset($data['merchant_name'])) {
            $this->db->set('merchant_name', $data['merchant_name']);
        }

        if (isset($data['password'])) {
            $this->db->set('password', $data['password']);
        }

        if (isset($data['merchant_email'])) {
            $this->db->set('merchant_email', $data['merchant_email']);
        }

        if (isset($data['merchant_phone'])) {
            $this->db->set('merchant_phone', $data['merchant_phone']);
        }

        if (isset($data['phone_is_whatsapp'])) {
            $this->db->set('phone_is_whatsapp', $data['phone_is_whatsapp']);
        }

        if (isset($data['merchant_address'])) {
            $this->db->set('merchant_address', $data['merchant_address']);
        }

        if (isset($data['merchant_logo'])) {
            $this->db->set('merchant_logo', $data['merchant_logo']);
        }

        if (isset($data['merchant_cover'])) {
            $this->db->set('merchant_cover', $data['merchant_cover']);
        }

        if (isset($data['merchant_description'])) {
            $this->db->set('merchant_description', $data['merchant_description']);
        }

        if (isset($data['merchant_web'])) {
            $this->db->set('merchant_web', $data['merchant_web']);
        }

        if (isset($data['merchant_facebook'])) {
            $this->db->set('merchant_facebook', $data['merchant_facebook']);
        }

        if (isset($data['merchant_twitter'])) {
            $this->db->set('merchant_twitter', $data['merchant_twitter']);
        }

        if (isset($data['merchant_pob'])) {
            $this->db->set('merchant_pob', $data['merchant_pob']);
        }

        if (isset($data['merchant_dob'])) {
            $this->db->set('merchant_dob', $data['merchant_dob']);
        }

        if (isset($data['merchant_status'])) {
            $this->db->set('merchant_status', $data['merchant_status']);
        }

        if (isset($data['merchant_package'])) {
            $this->db->set('merchant_package', $data['merchant_package']);
        }

        if (isset($data['province_province_id'])) {
            $this->db->set('province_province_id', $data['province_province_id']);
        }

        if (isset($data['kabupaten_kabupaten_id'])) {
            $this->db->set('kabupaten_kabupaten_id', $data['kabupaten_kabupaten_id']);
        }

        if (isset($data['merchant_owner_name'])) {
            $this->db->set('merchant_owner_name', $data['merchant_owner_name']);
        }

        if (isset($data['merchant_owner_phone'])) {
            $this->db->set('merchant_owner_phone', $data['merchant_owner_phone']);
        }

        if (isset($data['merchant_owner_ktp'])) {
            $this->db->set('merchant_owner_ktp', $data['merchant_owner_ktp']);
        }

        if (isset($data['merchant_is_deleted'])) {
            $this->db->set('merchant_is_deleted', $data['merchant_is_deleted']);
        }

        if (isset($data['merchant_input_date'])) {
            $this->db->set('merchant_input_date', $data['merchant_input_date']);
        }

        if (isset($data['merchant_last_update'])) {
            $this->db->set('merchant_last_update', $data['merchant_last_update']);
        }

        if (isset($data['merchant_id'])) {
            $this->db->where('merchant_id', $data['merchant_id']);
            $this->db->update('merchants');
            $id = $data['merchant_id'];
        } else {
            $this->db->insert('merchants');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Drop some data to table
    function delete($id) {
        $this->db->set('merchant_is_deleted', 1);
        $this->db->where('merchant_id', $id);
        $this->db->update('merchants');
    }

}
