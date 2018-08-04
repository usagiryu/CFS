<?
 	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
 	if(strpos($agent, 'iphone') || strpos($agent, 'ipad') )
 		$device_type = 'ios';
 	else
 		$device_type = 'other';
 	
?>
<header class="mdui-appbar mdui-appbar-fixed">
	<div class="mdui-toolbar mdui-color-theme">
		<span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white" >
			<i class="mdui-icon material-icons" onclick="location.href='/webview.php/login/welcome'">arrow_back</i>
		</span>
		<a class="mdui-typo-title" style="text-transform:capitalize;"><?=$action?></a>
		<div class="mdui-toolbar-spacer"></div>
	</div>
</header>
<div class="mdui-container" <?if($device_type == 'ios') print('style="display:none;"'); ?>>
	<div class="doc-container">
		<form method="post" action="/webview.php/login/login" autocomplete="off">
			<div class="mdui-textfield mdui-textfield-floating-label">
	  			<label class="mdui-textfield-label">用户名</label>
	  			<input class="mdui-textfield-input" type="text" name="id" maxlength="9" required/>
	 			 <div class="mdui-textfield-error">用户名不能为空</div>
			</div>
			<div class="mdui-textfield mdui-textfield-floating-label">
	  			<label class="mdui-textfield-label">密码</label>
	  			<input class="mdui-textfield-input" type="text" name="password" maxlength="64" required/>
	 			 <div class="mdui-textfield-error">密码不能为空</div>
			</div>
			<div class="br"></div>
	  		<input class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" type="submit" value="登入" />
		</form>
	</div>
</div>

<div class="mdui-container framecard" <?if($device_type == 'other') print('style="display:none;"'); ?>>
	<div class="br"></div>
	<div class="mdui-card" onclick="location.href='native://browser?url=http%3A%2F%2F<?=$_SERVER['SERVER_NAME']?>%2Fwebview%2Flogin%2Flogin_ios.php%3Ftoken%3D<?=$token?>%26username%3D<?=$username['username']?>'" >
	  	<div class="mdui-card-media">
	    	<img src="/assets/img/apple_out.jpg"/>
	    	<div class="mdui-card-media-covered">
	      		<div class="mdui-card-primary">
	        		<div class="mdui-card-primary-title">我们识别到你的设备为iOS</div>
	        		<div class="mdui-card-primary-subtitle">由于本软件机能受限，暂不支持iOS设备软件内登陆，点击此处调用系统浏览器进行操作</div>
	      		</div>
	    	</div>
	  	</div>
	</div>
</div>