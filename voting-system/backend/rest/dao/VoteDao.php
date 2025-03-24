<?php
require_once __DIR__ . "/BaseDao.php";

class VoteDao extends BaseDao{
    public function __construct(){
        parent::__construct("user_candidates");
    }
    public function get_by_user_id($user_id){
        return $this->query("SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id", ['user_id'=>$user_id]);
    }
}