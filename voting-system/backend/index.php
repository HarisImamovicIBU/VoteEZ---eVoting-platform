<?php
if ($_SERVER['REQUEST_URI'] === '/' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'healthy', 'service' => 'VoteEZ Backend']);
    exit;
}

// Dynamic CORS headers
$allowedOrigins = [
    "http://127.0.0.1:5501",
    "https://vote-ez-e-voting-platform.vercel.app",
];

if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
} 

header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authentication");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(204);
    exit();
} 

require "./vendor/autoload.php";
require "rest/services/CandidateService.php";
require "rest/services/UserService.php";
require "rest/services/VoteService.php";
require "rest/services/InquiryService.php";
require "rest/services/PartyService.php";
require "rest/services/AuthService.php";
require "middleware/AuthMiddleware.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Flight::register('candidate_service', "CandidateService");
Flight::register('user_service', "UserService");
Flight::register('vote_service', "VoteService");
Flight::register('inquiry_service', "InquiryService");
Flight::register('party_service', "PartyService");
Flight::register('auth_service',"AuthService");
Flight::register('auth_middleware', "AuthMiddleware");

Flight::route('/*', function(){
    if(
        strpos(Flight::request()->url, '/auth/login') === 0 ||
        strpos(Flight::request()->url, '/auth/register') === 0
    ) {
        return TRUE;
    } else {
        try{
            $token = Flight::request()->getHeader("Authentication");
            if(Flight::auth_middleware()->verifyToken($token)){
                return TRUE;
            }
        }
        catch (\Exception $e){
            Flight::halt(401, $e->getMessage());
        }
    }
});

require_once __DIR__ . '/rest/routes/CandidateRoutes.php';
require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/VoteRoutes.php';
require_once __DIR__ . '/rest/routes/InquiryRoutes.php';
require_once __DIR__ . '/rest/routes/PartyRoutes.php';
require_once __DIR__ . '/rest/routes/AuthRoutes.php';

Flight::start();