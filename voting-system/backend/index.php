<?php
require "./vendor/autoload.php";
require "rest/services/CandidateService.php";
require "rest/services/UserService.php";
require "rest/services/VoteService.php";
require "rest/services/InquiryService.php";
require "rest/services/PartyService.php";

Flight::register('candidate_service', "CandidateService");
Flight::register('user_service', "UserService");
Flight::register('vote_service', "VoteService");
Flight::register('inquiry_service', "InquiryService");
Flight::register('party_service', "PartyService");

require_once 'rest/routes/CandidateRoutes.php';
require_once 'rest/routes/UserRoutes.php';
require_once 'rest/routes/VoteRoutes.php';
require_once 'rest/routes/InquiryRoutes.php';
require_once 'rest/routes/PartyRoutes.php';

Flight::start();