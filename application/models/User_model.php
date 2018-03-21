<?php 


class User_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->_table = 'users';

    }

    // Log user in
    public function login($username, $password) {
        // Validate
        $this->db->where('username', $username);
        $this->db->where('password', $password);

        $result = $this->db->get('users');
        if ($result->num_rows() == 1) {
            return $result->row(0)->id;
        } else {
            return false;
        }
    }
}