<?php
session_start();
require('dbconnect.php');
require_once('function.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  //ログインしている
  $_SESSION['time'] = time();
  $member = $db->prepare('SELECT * FROM members WHERE id=?');
  $member->execute(array($_SESSION['id']));
  $member = $member->fetch();
} else {
  //ログインしていない
  header('Location: login.php');
  exit();
}
//投稿を記録する
if (!empty($_POST)) {
  if ($_POST['message'] != '') {
    $message = $db->prepare('INSERT INTO posts SET member_id=?, message=?, replay_post_id=?, created=NOW()');
    $message->execute(array($member['id'], $_POST['message'], $_POST['replay_post_id']));
    header('Location: index.php');
    exit();
  }
}
//投稿を取得する
$posts = $db->query('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id ORDER BY p.created DESC');
//投稿機能を取得する
if (isset($_REQUEST['res'])) {
  $response = $db->prepare('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=? ORDER BY p.created DESC');
  $response->execute(array($_REQUEST['res']));
  $table = $response->fetch();
  $message = '@' . $table['name'] . ' ' . $table['message'];
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>ひとこと掲示板</title>
	<link rel="stylesheet" href="style.css" />
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
          <textarea name="message" cols="50" rows="5"><?php echo htmlESC($message); ?></textarea>
          <input type="hidden" name="replay_post_id" value="<?php echo htmlESC($_REQUEST['res']); ?>" />
        </dd>
      </dl>
      <div>
        <input type="submit" value="投稿する"/>
      </div>
    </form>
    <?php foreach ($posts as $post): ?>
    <div class="msg">
      <img src="member_picture/<?php echo htmlESC($post['picture']); ?>" width="48" height="48" alt="<?php echo htmlESC($post['name']); ?>"/>
      <p>
        <?php echo makeLink(htmlESC($post['message'])); ?>
        <span class="name">(<?php echo htmlESC($post['name']); ?>)</span>
        [<a href="index.php?res=<?php echo htmlESC($post['id']); ?>">Re</a>]
      </p>
      <p class="day">
        <a href="view.php?id=<?php echo htmlESC($post['id']); ?>"><?php echo htmlESC($post['created']); ?></a>
        <?php if ($post['replay_post_id'] > 0): ?>
          <a href="view.php?id=<?php echo htmlESC($post['replay_post_id']); ?>">返信元のメッセージ</a>
        <?php endif; ?>
      </p>
    </div>
    <?php endforeach; ?>
  </div>
</div>
</body>
</html>
