<?php get_header(); ?>
<div class="content-wrap">
	<div class="content">
		<?php while (have_posts()) : the_post(); ?>
		<header class="article-header">
			<h1 class="article-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
			<ul class="article-meta">
				<?php $author = get_the_author();
    if( _hui('author_link') ){
        $author = '<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.$author.'</a>';
    } ?>
				<li><?php echo $author ?> 发布于 <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></li>
				<li><?php echo '分类：';the_category(' / '); ?></li>
				<li><?php echo hui_get_post_from() ?></li>
				<li><?php echo hui_get_views() ?></li>
				<li><?php echo hui_get_comment_number() ?></li>
				<li><?php edit_post_link('[编辑]'); ?></li>
			</ul>
		</header>
		<?php if( _hui('ads_post_01_s') ) echo '<div class="ads ads-content ads-post">'._hui('ads_post_01').'</div>'; ?>
		<article class="article-content">
			<?php the_content(); ?>
		</article>
		<?php endwhile;  ?>
		<div class="article-social">
			<?php echo hui_get_post_like($class='action action-like'); ?>
			<a href="#comments" class="action action-comment" data-event="<?php echo is_user_logged_in() ? 'comment' : 'login' ?>"><i class="glyphicon glyphicon-comment"></i><span><?php echo hui_get_comment_number('评论 ('); ?></span></a>
			<span class="action action-share bdsharebuttonbox">
				<i class="glyphicon glyphicon-share"></i>分享 (<span class="bds_count" data-cmd="count"></span>)
				<div class="action-popover">
				<div class="popover top in"><div class="arrow"></div><div class="popover-content"><a class="bds_qzone" data-cmd="qzone"></a><a class="bds_tsina" data-cmd="tsina"></a><a class="bds_weixin" data-cmd="weixin"></a><a class="bds_tqq" data-cmd="tqq"></a><a class="bds_sqq" data-cmd="sqq"></a><a class="bds_renren" data-cmd="renren"></a></div></div></div>
			</span>
		</div>
		<div class="article-tags">
			<?php the_tags('标签：','',''); ?>
		</div>
		<?php if( _hui('ads_post_02_s') ) echo '<div class="ads ads-content ads-related">'._hui('ads_post_02').'</div>'; ?>
		<?php hui_posts_related( _hui('related_title'), _hui('post_related_n') ) ?>
		<?php if( _hui('sticky_post_s') ) hui_posts_sticky( $title=_hui('sticky_title'), $showposts=_hui('sticky_limit') ) ?>
		<?php if( _hui('ads_post_03_s') ) echo '<div class="ads ads-content ads-comment">'._hui('ads_post_03').'</div>'; ?>
		<?php comments_template('', true); ?>
	</div>
</div>
<?php get_sidebar(); get_footer(); ?>