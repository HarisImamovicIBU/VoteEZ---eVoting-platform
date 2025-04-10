<?php
require_once __DIR__ . "/BaseDao.php";
class CandidateDao extends BaseDao{
    public function __construct(){
        parent::__construct("candidates");
    }
    public function get_by_party_id($party_id){
        return $this->query("SELECT * FROM ". $this->table_name . " WHERE party_id = :party_id ", ['party_id'=>$party_id]);
    }
    public function increment_votes($id, $id_column = "id"){
        $query = "UPDATE " . $this->table_name . " SET vote_count = vote_count + 1 WHERE $id_column = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->execute(['id'=>$id]);
    }
}