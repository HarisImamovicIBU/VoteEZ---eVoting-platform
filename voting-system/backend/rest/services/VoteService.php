<?php
require_once "BaseService.php";
require_once __DIR__ . "/../dao/VoteDao.php";

class VoteService extends BaseService{
    public function __construct(){
        parent::__construct(new VoteDao);
    }
    public function get_by_user_id($user_id){
        return $this->dao->get_by_user_id($user_id);
    }
}