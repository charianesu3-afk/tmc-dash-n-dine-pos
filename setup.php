<?php
require_once __DIR__.'/config/database.php';
$message=''; $error='';
try {
 $server=new PDO('mysql:host='.DB_HOST.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
 $server->exec('CREATE DATABASE IF NOT EXISTS `'.DB_NAME.'` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
 $pdo=db();
 $schema=file_get_contents(__DIR__.'/database/schema.sql');
 foreach(preg_split('/;\s*(?:\r?\n|$)/', $schema) as $statement){$statement=trim($statement);if($statement!=='')$pdo->exec($statement);}
 $cats=['Fast Food','Burgers','Meals','Drinks','Desserts'];
 $st=$pdo->prepare('INSERT IGNORE INTO categories(name) VALUES(?)'); foreach($cats as $c)$st->execute([$c]);
 $products=[
 ['Fast Food','Egg Roll','Fried egg on a toasted bun',1.00],['Fast Food','French Fries','Hot chips with a lightly spicy sprinkle',1.00],
 ['Fast Food','Hot Chips & Russian Sausage','French fries served with Russian sausage',1.50],
 ['Burgers','Value Beef Burger','Grilled beef patty on a toasted bun with lettuce, tomato, onion and burger sauce',1.50],
 ['Burgers','Beef Egg Burger','Beef patty with lettuce, tomato, onion, fried egg and burger sauce',2.00],
 ['Meals','Traditional Beef Stew','Beef stew served with sadza and pan-fried leafy greens',1.50],
 ['Meals','Rice & Beef Stew','Served with coleslaw',2.00],['Meals','Quarter Chicken','Served with hot chips, sadza or rice',4.00],
 ['Meals','T-Bone Steak','Served with hot chips, sadza or rice',4.00],['Meals','Pork Chop','Served with hot chips, sadza or rice',3.50],
 ['Meals','Chicken Roast with Rice','One piece served with rice and coleslaw',2.00],['Meals','Chicken Roast with Sadza','One piece served with sadza and leafy greens',2.00],
 ['Meals','Steak Pie','Homemade beef steak pie',1.50],['Drinks','Soft Drink 330ml Can','Coke, Fanta or Sprite',0.70],
 ['Drinks','Soft Drink 440ml PET','Coke, Fanta or Sprite',0.70],['Drinks','Soft Drinks 300ml (2 for $1)','Two-bottle offer; one product unit is one two-bottle deal',1.00],
 ['Drinks','Minute Maid Refresh 400ml','',0.50],['Drinks','Minute Maid Delight 400ml','',1.00],['Drinks','Mineral Water 500ml','',0.30],
 ['Desserts','Ice Cream Cone','',0.50],['Desserts','Flavoured Yoghurt','',0.60]
 ];
 $ins=$pdo->prepare('INSERT INTO products(category_id,name,description,price) SELECT id,?,?,? FROM categories WHERE name=?');
 foreach($products as $p){$check=$pdo->prepare('SELECT id FROM products WHERE name=?');$check->execute([$p[1]]);if(!$check->fetch())$ins->execute([$p[1],$p[2],$p[3],$p[0]]);}
 $u=$pdo->prepare('SELECT id FROM users WHERE username=?');$u->execute(['admin']);
 if(!$u->fetch()){$add=$pdo->prepare('INSERT INTO users(full_name,username,password_hash,role) VALUES(?,?,?,?)');$add->execute(['System Administrator','admin',password_hash('ChangeMe123!',PASSWORD_DEFAULT),'admin']);}
 $message='Setup completed. Your menu has been loaded and the initial administrator account is ready.';
} catch(Throwable $e){$error=$e->getMessage();}
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Install TMC POS</title><link rel="stylesheet" href="assets/css/style.css"></head><body class="setup-body"><main class="setup-card"><div class="brand-mark">T</div><h1>TMC DASH 'N' DINE</h1><h2>System installation</h2><?php if($message):?><div class="alert success"><?=htmlspecialchars($message)?></div><p><b>Username:</b> admin<br><b>Temporary password:</b> ChangeMe123!</p><p>Sign in, change the password, then delete or rename setup.php so it cannot be run again.</p><a class="btn primary" href="login.php">Go to login</a><?php else:?><div class="alert danger">Installation error: <?=htmlspecialchars($error)?></div><p>Check that Apache and MySQL are running and that config/config.php has the correct database settings.</p><?php endif;?></main></body></html>
