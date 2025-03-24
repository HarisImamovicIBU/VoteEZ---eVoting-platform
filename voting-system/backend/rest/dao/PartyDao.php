<?php
require_once __DIR__ . "/BaseDao.php";

class PartyDao extends BaseDao{
    public function __construct(){
        parent::__construct("parties");
    }
}