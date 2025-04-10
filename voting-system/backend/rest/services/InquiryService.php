<?php
require_once "BaseService.php";
require_once __DIR__ . "/../dao/InquiryDao.php";

class InquiryService extends BaseService{
    public function __construct(){
        parent::__construct(new InquiryDao);
    }
    public function get_by_user_id($user_id){
        return $this->dao->get_by_user_id($user_id);
    }
}