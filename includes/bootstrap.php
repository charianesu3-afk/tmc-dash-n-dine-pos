<?php
if(session_status()===PHP_SESSION_NONE) session_start();
require_once __DIR__.'/../config/database.php';
function e($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function money($v){return '$'.number_format((float)$v,2);}
function logged_in(){return !empty($_SESSION['user']);}
function require_login(){if(!logged_in()){header('Location: login.php');exit;}}
function is_manager(){return logged_in() && in_array($_SESSION['user']['role'],['admin','manager'],true);}
function require_manager(){require_login();if(!is_manager()){http_response_code(403);exit('Access denied. Manager permission required.');}}
function csrf(){if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));return $_SESSION['csrf'];}
function verify_csrf(){if(!hash_equals($_SESSION['csrf']??'',$_POST['csrf']??'')){http_response_code(419);exit('Session expired. Refresh the page and try again.');}}
function log_action($action,$details=''){if(logged_in()){$s=db()->prepare('INSERT INTO audit_logs(user_id,action,details) VALUES(?,?,?)');$s->execute([$_SESSION['user']['id'],$action,$details]);}}
