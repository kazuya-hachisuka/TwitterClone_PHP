<?php
require_once("function.php");
session_start();

if (!isset($_SESSSION['join'])) {
  header('Location: index.php');
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
	<link rel="stylesheet" href="../style.css" />
</head>
<body>
  <form action="" method="post">
    <dl>
      <dt>ニックネーム</dt>
      <dd>
        <?php echo htmlESC($_SESSION['join']['name']); ?>
      </dd>
      <dt>メールアドレス</dt>
      <dd>
        <?php echo htmlESC($_SESSION['join']['email']); ?>
      </dd>
      <dt>パスワード</dt>
      <dd>[表示されません]</dd>
      <dt>写真など</dt>
      <dd>
        <img src="../member_picture/<?php echo htmlESC($_SESSION['join']['image']); ?>" width="100" height="100" alt="" >
      </dd>
    </dl>
    <div>
      <a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する"></div>
    </div>
  </form>
</body>
</html>
