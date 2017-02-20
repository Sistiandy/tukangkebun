<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * log Model Class
 *
 * @package     SYSCMS
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Logs_model extends CI_Model {

    var $table = 'logs';
    var $all_column = array('log_id', 'log_date', 'log_action', 'log_module', 'log_info', 'logs.user_id'); //set all column field database
    var $order = array('log_id' => 'desc'); // default order 

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        $this->db->from($this->table);

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

        $this->db->select('logs.log_id, log_date, log_action, log_module, log_info, logs.user_id');
        $this->db->select('user_full_name');
        $this->db->join('users', 'users.user_id = logs.user_id', 'left');
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
            $this->db->where('logs.log_id', $params['id']);
        }

        $this->db->select('logs.log_id, log_date, log_action, log_module, log_info, logs.user_id');
        $this->db->select('user_full_name');

        $this->db->join('users', 'users.user_id = logs.user_id', 'left');
        $res = $this->db->get('logs');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function add($data = array()) {

        if (isset($data['log_id'])) {
            $this->db->set('log_id', $data['log_id']);
        }

        if (isset($data['log_date'])) {
            $this->db->set('log_date', $data['log_date']);
        }

        if (isset($data['log_action'])) {
            $this->db->set('log_action', $data['log_action']);
        }

        if (isset($data['log_module'])) {
            $this->db->set('log_module', $data['log_module']);
        }

        if (isset($data['log_info'])) {
            $this->db->set('log_info', $data['log_info']);
        }

        if (isset($data['user_id'])) {
            $this->db->set('user_id', $data['user_id']);
        }

        if (isset($data['log_id'])) {
            $this->db->where('log_id', $data['log_id']);
            $this->db->update('logs');
            $id = $data['log_id'];
        } else {
            $this->db->insert('logs');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

}
