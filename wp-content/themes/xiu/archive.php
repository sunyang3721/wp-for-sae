<?php 
get_header(); 
$pagedtext = '';
if( $paged && $paged > 1 ){
	$pagedtext = ' <small>第'.$paged.'页</small>';
}
?>

<div class="content-wrap">
	<div class="content">
		<h1 class="title"><strong><?php 
			if(is_day()) echo the_time('Y年m月j日');
			elseif(is_month()) echo the_time('Y年m月');
			elseif(is_year()) echo the_time('Y年'); 
		?>的文章</strong><?php echo $pagedtext ?></h1>
		<?php hui_post_excerpt() ?>
	</div>
</div>

<?php get_sidebar(); get_footer(); ?>