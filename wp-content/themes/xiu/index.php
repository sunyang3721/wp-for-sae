<?php get_header(); ?>
<div class="content-wrap">
	<div class="content">
		<?php echo _hui('ads_index_01_s') ? '<div class="ads ads-content">'._hui('ads_index_01').'</div>' : '' ?>
		<?php if( !$paged && _hui('focus_s') ) hui_posts_focus() ?>
		<?php if( !$paged && _hui('most_list_s') ){ ?>
		<div class="most-comment-posts">
			<h3 class="title"><strong><?php echo _hui('most_list_title') ?></strong></h3>
			<ul><?php hui_recent_posts_most($days=_hui('most_list_date'), $nums=_hui('most_list_number')); ?></ul>
		</div>
		<?php } ?>
		<?php if( !$paged && _hui('sticky_s') ) hui_posts_sticky( $title=_hui('sticky_title'), $showposts=_hui('sticky_limit') ) ?>
		<?php echo _hui('ads_index_02_s') ? '<div class="ads ads-content">'._hui('ads_index_02').'</div>' : '' ?>
		<?php 
			if( $paged && $paged > 1 ){
				printf('<h3 class="title"><strong>所有文章</strong> <small>第'.$paged.'页</small></h3>');
			}else{
				printf('<h3 class="title">'.(_hui('recent_posts_number')?'<small class="pull-right">24小时更新：'.hui_get_recent_posts_number().'篇 &nbsp; &nbsp; 一周更新：'.hui_get_recent_posts_number(7).'篇</small>':'').'<strong>'._hui('index_list_title').'</strong></h3>');
			}

			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
			    'caller_get_posts' => 1,
			    'paged' => $paged
			);
			query_posts($args);

			hui_post_excerpt();
		?>
		<?php echo _hui('ads_index_03_s') ? '<div class="ads ads-content">'._hui('ads_index_03').'</div>' : '' ?>
	</div>
</div>
<?php get_sidebar(); get_footer(); ?>