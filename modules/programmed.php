<?php
//programmed.php 私服客户端专用功能
function programmed_getCustomLiveList($post = []) {
	if (!isset($post['api_ver'])) {
		$post['api_ver'] = 0;
	}
	global $mysql, $uid, $envi;
	$list = array_map(function ($e) use ($post) {
		$live = json_decode($e['live_json'], true);
		return [
			'live_difficulty_id' => 0 - $e['ID'],
			'dl' => $e['dl'] ? json_decode($e['dl']) : false,
			'live' => $live,
			'notes_setting_asset' => $e['notes_setting_asset'],
			'status' => 1,
			'category' => $e['category'] ? $e['category'] : 'Custom Live',
		];
	}, $mysql->query('SELECT * from programmed_live')->fetchAll());
	if ($envi->params['allow_test_func'] == 0) {
		$list = array_filter($list, function ($v) {
			global $uid;
			if (isset($v['live']['developer_only']) && !isset($v['live']['upload_user'])) {
				return false;
			}else if(isset($v['live']['upload_user']) && $v['live']['upload_user'] != $uid){
				return false;
			}
			return true;
		});
	} else {
		foreach($list as $k => &$v) {
			if (isset($v['live']['developer_only'])) {
				$v['live']['is_not_for_marathon_ranking'] = true;
			}
			if (isset($v['live']['upload_user']) && $v['live']['upload_user'] != $uid) {
				unset($list[$k]);
			}
		}
		$list = array_values($list);
	}
	$notes_setting_asset_list = array_map(function ($e) {
		return $e['notes_setting_asset'];
	}, $list);
	$played = $mysql->query('
		SELECT distinct notes_setting_asset FROM live_ranking
		WHERE user_id='.$uid.' AND card_switch='.$envi->params['card_switch'].' AND random_switch='.$envi->params['random_switch'].'
		AND notes_setting_asset in ("'.implode('","', $notes_setting_asset_list).'")
	')->fetchAll(PDO::FETCH_COLUMN);
	foreach ($list as &$v) {
		if (array_search($v['notes_setting_asset'], $played) !== false) {
			$v['status'] = 2;
		}
	}
	return array_merge($list);
}
