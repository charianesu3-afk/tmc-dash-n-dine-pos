<?php
require_once __DIR__.'/includes/bootstrap.php';
if(logged_in()){header('Location: dashboard.php');exit;}
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 if(!hash_equals($_SESSION['csrf']??'',$_POST['csrf']??''))$error='Please refresh the page and try again.';
 else {$s=db()->prepare('SELECT * FROM users WHERE username=? AND is_active=1');$s->execute([trim($_POST['username']??'')]);$u=$s->fetch();if($u && password_verify($_POST['password']??'',$u['password_hash'])){session_regenerate_id(true);$_SESSION['user']=['id'=>$u['id'],'full_name'=>$u['full_name'],'username'=>$u['username'],'role'=>$u['role']];header('Location: dashboard.php');exit;}else $error='Incorrect username or password.';}
}
$token=csrf();
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login | TMC DASH 'N' DINE</title><link rel="stylesheet" href="assets/css/style.css"></head><body class="login-body"><div class="login-wrap"><div class="login-brand"><div class="brand-mark big">T</div><h1>TMC DASH 'N' DINE</h1><p>Restaurant Point of Sale & Management</p></div><form class="login-card" method="post"><h2>Welcome back</h2><p class="muted">Sign in to continue to your workspace.</p><?php if($error):?><div class="alert danger"><?=e($error)?></div><?php endif;?><input type="hidden" name="csrf" value="<?=e($token)?>"><label>Username</label><input name="username" required autofocus placeholder="Enter username"><label>Password</label><input name="password" type="password" required placeholder="Enter password"><button class="btn primary full" type="submit">Sign in</button><small class="muted center">Local restaurant system · USD</small></form></div></body></html>
