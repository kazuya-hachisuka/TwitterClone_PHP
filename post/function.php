<?php
//htmlspecialcharsを書くのが長いので、作成
function htmlESC($item){
  return htmlspecialchars($item, ENT_QUOTES);
}
//本文内のURLにリンクを設定する
function makeLink($value) {
  return mb_ereg_replace("(https?)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)", '<a href="\1\2">\1\2</a>', $value);
}
?>
