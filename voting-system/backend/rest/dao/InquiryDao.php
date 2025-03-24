<?php
require_once __DIR__ . "/BaseDao.php";

class InquiryDao extends BaseDao{
    public function __construct(){
        parent::__construct("inquiries");
    }
    public function get_by_user_id($user_id){
        return $this->query("SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id", ['user_id'=>$user_id]);
    }
}