<?php
require_once "BaseService.php";
require_once __DIR__ . "/../dao/AuthDao.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService extends BaseService {
    private $auth_dao;
    public function __construct() {
        $this->auth_dao = new AuthDao();
        parent::__construct(new AuthDao);
    }

    public function get_user_by_email($email){
        return $this->auth_dao->get_user_by_email($email);
    }

    public function register($entity) {   
        if (empty($entity['name']) || empty($entity['email']) || empty($entity['password']) || empty($entity['phone'])) {
            return ['success' => false, 'error' => 'Name, email, password and phone are required.'];
        }
        $email_exists = $this->auth_dao->get_user_by_email($entity['email']);
        if($email_exists){
            return ['success' => false, 'error' => 'Email already registered.'];
        }
        $entity['password'] = password_hash($entity['password'], PASSWORD_BCRYPT);
        $entity['has_voted']=0;
        $entity['role']="voter";
        $entity = parent::add($entity);
        unset($entity['password']);
        return ['success' => true, 'data' => $entity];              
    }

    public function login($entity) {   
        if (empty($entity['email']) || empty($entity['password']) || empty($entity['phone'])) {
            return ['success' => false, 'error' => 'Email, password and phone are required.'];
        }

        $user = $this->auth_dao->get_user_by_email($entity['email']);
        if(!$user){
            return ['success' => false, 'error' => 'Invalid email.'];
        }
        if(!$user || !password_verify($entity['password'], $user['password']))
            return ['success' => false, 'error' => 'Invalid email or password.'];

        if(!$user || $entity['phone']!=$user['phone']){
            return ['success' => false, 'error' => 'Invalid email or phone.'];
        }
        unset($user['password']);
        
        $jwt_payload = [
            'user' => $user,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24)
        ];

        $token = JWT::encode(
            $jwt_payload,
            Config::JWT_SECRET(),
            'HS256'
        );

        return ['success' => true, 'data' => array_merge($user, ['token' => $token])];              
    }
}