<?php
session_start();
require('dbconnect.php');
require_once('function.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  //ログインしている
  $_SESSION['time'] = time();
  $member = $db->prepare('SELECT * FROM members WHERE id=?');
  $member->execute(array($_SESSION['id']));
  $meber = $member->fetch();
} else {
  //ログインしていない
  header('Location: login.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>ひとこと掲示板</title>
	<link rel="stylesheet" href="./style.css" />
</head>
<body>
<div id="wrap">
  <div id="head">
    <h1>ひとこと掲示板</h1>
  </div>
  <div id="content">
    <form action="" method="post">
      <dl>
        <dt><?php echo htmlESC($member['name']); ?>さん、メッセージをどうぞ</dt>
        <dd>
          <textarea name="message" cols="50" rows="5"></textarea>
        </dd>
      </dl>
      <div>
        <input type="submit" value="投稿する"/>
      </div>
    </form>
  </div>
</div>
</body>
</html>
