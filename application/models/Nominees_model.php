<?php 

class Nominees_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->_table = 'nominees';

    }
}