<?php
require_once "BaseService.php";
require_once __DIR__ . "/../dao/UserDao.php";

class UserService extends BaseService{
    public function __construct(){
        parent::__construct(new UserDao);
    }
    public function get_by_email($email){
        return $this->dao->get_by_email($email);
    }
    public function change_vote_status($id){
        return $this->dao->change_vote_status($id);
    }
}