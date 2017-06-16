<?php
function throw403($err) {
  header('HTTP/1.1 403 Forbidden');
  echo $err;
  die();
}

function pl_assert($condition, $err = '') {
  if (!$condition) {
    trigger_error("Assert failure:\n$err");
  }
}