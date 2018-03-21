<?php 

class Votes_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->_table = 'votes';

    }

    public function getAllCountByNominees() {
        $query = $this->db->query('SELECT votes.*, COUNT(*) AS voteCount, award_categories.name AS category_name, nominees.name AS nominee_name FROM votes LEFT JOIN nominees ON nominees.id=votes.nominee_id LEFT JOIN award_categories ON votes.category_id=award_categories.id GROUP BY nominee_id;');
        return $query->result_array();
    }
}