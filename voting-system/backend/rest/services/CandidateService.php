<?php
require_once "BaseService.php";
require_once __DIR__ . "/../dao/CandidateDao.php";

class CandidateService extends BaseService{
    public function __construct(){
        parent::__construct(new CandidateDao);
    }
    public function get_by_party_id($party_id) {
        return $this->dao->get_by_party_id($party_id);
    }
    public function increment_votes($id, $id_column='id'){
        return $this->dao->increment_votes($id, $id_column);
    }
}