<meta charset='utf-8' />
<style>body{font-size:2em;}table{font-size:1em;}</style>
<SCRIPT type="text/javascript">
var strUA = "";
strUA = navigator.userAgent.toLowerCase();

if(strUA.indexOf("iphone") >= 0) {
  document.write('<meta name="viewport" content="width=100%, minimum-scale=0.45, maximum-scale=0.45, user-scalable=no" />');
} else if (strUA.indexOf("ipad") >= 0) {
  document.write('<meta name="viewport" content="width=100%, minimum-scale=0.9, maximum-scale=0.9, user-scalable=no" />');
} else if (strUA.indexOf("android 2.3") >= 0) {
  document.write('<meta name="viewport" content="width=100%, minimum-scale=0.45, maximum-scale=0.45, initial-scale=0.45, user-scalable=yes" />');
} else {
  document.write('<meta name="viewport" content="width=100%, minimum-scale=0.38, maximum-scale=0.38, user-scalable=no" />');
}
</script>
<link href="/resources/bstyle.css" rel="stylesheet">
<link href="/resources/news.css" rel="stylesheet">
<link href="/resources/css/style.css" rel="stylesheet">

<?php
$uid=$_SESSION['server']['HTTP_USER_ID'];
$params = [];
foreach ($mysql->query('SELECT * FROM user_params WHERE user_id='.$uid)->fetchAll() as $v) {
  $params[$v['param']] = (int)$v['value'];
}
$unit = getUnitDb();

require 'config/maintenance.php';

$max_album_id=$unit->query('SELECT max(unit_number) FROM unit_m WHERE unit_id<='.$max_unit_id)->fetchColumn();

if(isset($_GET['switch_card']) && $params['enable_card_switch']) {
  $mysql->prepare('UPDATE user_params SET value=? WHERE user_id=? and param="card_switch"')->execute([$_GET['switch_card'], $uid]);
  $params['card_switch']=$_GET['switch_card'];
}elseif(isset($_GET['submit']) && $_GET['submit']=='提交') {
  if(is_numeric($_GET['avatar']) && $_GET['avatar']>0 && $_GET['avatar']<=$max_album_id) {
    $rankup=0;
    if(isset($_GET['rankup']))
      $rankup=1;
    $unit_id=$unit->query('SELECT unit_id FROM unit_m WHERE unit_number='.$_GET['avatar'])->fetchColumn();
    $mysql->query('REPLACE INTO user_params values (?, ?, ?)', [$uid, 'extend_avatar', $unit_id]);
    $mysql->query('REPLACE INTO user_params values (?, ?, ?)', [$uid, 'extend_avatar_is_rankup', $rankup]);
    echo '<h3>修改成功！重启游戏后生效。</h3>';
  }
  else echo '<p>输入错误！</p>';
}
?>

<DIV id="wrapper_news" style="width: 100% !important">
<div class="title_news fs34" style="width:100%">
  <span class="ml30">卡片设置
  </span><a id="back" href="/webview.php/settings/index">
  <div class="topback">
    <img src="/resources/com_button_01.png" data-on="/resources/com_button_02se.png">
  </div>
  </a>
</div>
<div class="content_news_all" style="margin-top:0">
  <div id="box1">

<div class="title_news_all fs30">
      <span class="ml40">卡片开关</span>
    </div>
    <div class="content_all">
      <div class="note">
      <p>您的UID：<?=$uid?>，已<?=($params['card_switch']?'启':'禁')?>用卡片功能。<br />
<?php if($params['enable_card_switch']) : ?>
<a href="/webview.php/settings/card?switch_card=<?=($params['card_switch']?'0':'1')?>"><?=($params['card_switch']?'禁':'启')?>用卡片功能</a>
<br /><span style="color:red;font-weight:bold">
<?php else : ?>
您无权启用卡片功能。
<?php endif; ?></p>
      </div>
    </div>

    <div class="title_news_all fs30">
      <span class="ml40">相关信息</span>
    </div>
    <div class="content_all">
      <div class="note">
      <p>注意：重启游戏后生效。不重启的话任何操作都可能导致客户端崩溃或者“服务器爆炸”！</span><br />（若您只是想查看另一模式的排行榜可以不用重启游戏）</p>
      </div>
    </div>
    <div class="title_news_all fs30">
      <span class="ml40">相关信息</span>
    </div>
    <div class="content_all">
      <div class="note">
      <p><span style="font-weight:bold">设置头像</span><br />您可以设置无卡模式下的排行榜中自己显示的头像。<br /><br />

<form method="get" action="/webview.php/settings/card">
请输入卡片的相册ID：<input type="text" name="avatar" autocomplete="off" />（最大ID：<?=$max_album_id?>）<br /><input type="checkbox" name="rankup" value="rankup" />觉醒<br /><br /><input type="submit" name="submit" value="提交" />
</form>
</p>
      </div>
    </div>
</div>
</div>
</DIV>
<DIV class="footer_news_all"><IMG width="100%" src="/resources/bg03.png"> 
</DIV>