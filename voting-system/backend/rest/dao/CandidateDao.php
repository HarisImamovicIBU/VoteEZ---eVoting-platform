<?php
require_once __DIR__ . "/BaseDao.php";
class CandidateDao extends BaseDao{
    public function __construct(){
        parent::__construct("candidates");
    }
    public function get_by_party_id($party_id){
        return $this->query("SELECT * FROM ". $this->table_name . " WHERE party_id = :party_id ", ['party_id'=>$party_id]);
    }
}