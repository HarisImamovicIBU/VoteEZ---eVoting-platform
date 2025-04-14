<?php
require_once __DIR__ . "/BaseDao.php";

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct("users");
    }
    public function get_by_email($email){
        return $this->query("SELECT * FROM " . $this->table_name . " WHERE email = :email", ['email'=>$email]);
    }
    public function change_vote_status($id){
        $query = "UPDATE " . $this->table_name . " SET has_voted = 1 WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->execute(['id'=>$id]);
    }
}