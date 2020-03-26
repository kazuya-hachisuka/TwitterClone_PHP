<?php
//htmlspecialcharsを書くのが長いので、作成
function htmlESC($item){
  return htmlspecialchars($item, ENT_QUOTES);
}
?>
