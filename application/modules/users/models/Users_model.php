<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * user Model Class
 *
 * @package     SYSCMS
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Users_model extends CI_Model {

    var $table = 'users';
    var $all_column = array('users.user_id', 'user_name', 'user_full_name', 'user_email',
        'user_pob', 'user_dob'); //set all column field database
    var $order = array('user_last_update' => 'desc'); // default order 

    function __construct() {
        parent::__construct();
    }

    private function _get_datatables_query() {

        $this->db->from($this->table);
        $this->db->where('user_is_deleted', FALSE);

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

        $this->db->select('users.user_id, user_name, user_full_name, user_password, user_email, user_pob,
                user_dob, user_role_role_id, user_input_date, user_last_update');
        $this->db->select('role_name');
        $this->db->join('user_roles', 'user_roles.role_id = users.user_role_role_id', 'left');
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
            $this->db->where('users.user_id', $params['id']);
        }

        if (isset($params['username'])) {
            $this->db->where('user_name', $params['username']);
        }

        if (isset($params['password'])) {
            $this->db->where('user_password', $params['password']);
        }

        if (isset($params['user_role_role_id'])) {
            $this->db->where('user_role_role_id', $params['user_role_role_id']);
        }
        $this->db->where('user_is_deleted', FALSE);

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('user_last_update', 'desc');
        }
        $this->db->select('users.user_id, user_name, user_password, user_full_name, user_email, user_pob, user_dob,
                 user_input_date, user_last_update');
        $this->db->select('user_role_role_id, user_roles.role_name');

        $this->db->join('user_roles', 'user_roles.role_id = users.user_role_role_id', 'left');
        $res = $this->db->get('users');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Get Role From Databases
    function get_roles($params = array()) {
        $this->db->select('user_roles.role_id, role_name');

        if (isset($params['id'])) {
            $this->db->where('user_roles.role_id', $params['id']);
        }
        if (isset($params['role_id'])) {
            $this->db->where('user_roles.role_id', $params['role_id']);
        }

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('user_roles.role_id', 'desc');
        }

        $res = $this->db->get('user_roles');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function add($data = array()) {

        if (isset($data['user_id'])) {
            $this->db->set('user_id', $data['user_id']);
        }

        if (isset($data['user_name'])) {
            $this->db->set('user_name', $data['user_name']);
        }

        if (isset($data['user_password'])) {
            $this->db->set('user_password', $data['user_password']);
        }

        if (isset($data['user_full_name'])) {
            $this->db->set('user_full_name', $data['user_full_name']);
        }

        if (isset($data['user_email'])) {
            $this->db->set('user_email', $data['user_email']);
        }

        if (isset($data['user_pob'])) {
            $this->db->set('user_pob', $data['user_pob']);
        }

        if (isset($data['user_dob'])) {
            $this->db->set('user_dob', $data['user_dob']);
        }

        if (isset($data['user_input_date'])) {
            $this->db->set('user_input_date', $data['user_input_date']);
        }

        if (isset($data['user_last_update'])) {
            $this->db->set('user_last_update', $data['user_last_update']);
        }

        if (isset($data['user_role_role_id'])) {
            $this->db->set('user_role_role_id', $data['user_role_role_id']);
        }

        if (isset($data['user_id'])) {
            $this->db->where('user_id', $data['user_id']);
            $this->db->update('users');
            $id = $data['user_id'];
        } else {
            $this->db->insert('users');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Insert some data to table
    function add_roles($data = array()) {

        if (isset($data['role_id'])) {
            $this->db->set('role_id', $data['role_id']);
        }

        if (isset($data['role_name'])) {
            $this->db->set('role_name', $data['role_name']);
        }

        if (isset($data['role_id'])) {
            $this->db->where('role_id', $data['role_id']);
            $this->db->update('user_roles');
            $id = $data['role_id'];
        } else {
            $this->db->insert('user_roles');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Drop some data to table
    function delete($id) {
        $this->db->set('user_is_deleted', 1);
        $this->db->where('user_id', $id);
        $this->db->update('users');
    }

    // Drop some data to table
    function delete_role($id) {
        $this->db->where('role_id', $id);
        $this->db->delete('user_roles');
    }

    // Change user password
    function change_password($id, $params) {
        $this->db->where('user_id', $id);
        $this->db->update('users', $params);
    }

}
