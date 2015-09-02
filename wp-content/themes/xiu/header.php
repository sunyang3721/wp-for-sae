<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?php $t = trim(wp_title('', false)); if($t) echo $t._hui('connector'); else ''; bloginfo('name'); if (is_home ()) echo _hui('connector').get_option('blogdescription'); if ($paged > 1) echo '-Page ', $paged; ?></title>
<?php wp_head(); ?>
<link rel="shortcut icon" href="<?php echo HOME_URI.'/favicon.ico' ?>">
<!--[if lt IE 9]><script src="<?php echo THEME_URI ?>/js/html5.js"></script><![endif]-->
</head>
<body <?php body_class( _hui('layout') ); ?>>
<section class="container">
<header class="header">
	<?php hui_logo(); ?>
	<?php hui_nav_menu(); ?>
	<div class="feeds">
		<a class="feed feed-rss" rel="external nofollow" href="<?php echo _hui('feed') ?>" title="Feed订阅" target="_blank">订阅</a>
		<a class="feed feed-weibo" rel="external nofollow" href="<?php echo _hui('weibo') ?>" title="关注微博" target="_blank">微博</a>
		<a class="feed feed-tqq" rel="external nofollow" href="<?php echo _hui('tqq') ?>" title="关注腾讯微博" target="_blank">腾讯微博</a>
		<a class="feed feed-weixin" rel="external nofollow" href="javascript:;" title="关注”<?php echo _hui('wechat') ?>“" data-content="<img src='<?php echo _hui("wechat_qr") ?>'>">微信</a>
	</div>
	<div class="slinks">
		<?php echo _hui('menu_links') ?>
	</div>
	<?php if( is_user_logged_in() ){
		global $current_user;
		get_currentuserinfo();
	?>
		<div class="user-welcome">
			<?php echo hui_get_avatar($user_id=$current_user->ID, $user_email=$current_user->user_email, $src=true); ?>
			<strong><?php echo $current_user->display_name ?></strong><span class="text-muted">欢迎登录！</span>
		</div>
		<p class="user-logout"><a href="<?php echo wp_logout_url() ?>">退出</a></p>
	<?php } ?>
</header>