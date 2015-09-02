<?php
add_action('widgets_init','unregister_d_widget');
function unregister_d_widget(){
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Recent_Comments');
}



add_action( 'widgets_init', 'widget_searchbox_loader' );

function widget_searchbox_loader() {
	register_widget( 'widget_searchbox' );
}

class widget_searchbox extends WP_Widget {
	function widget_searchbox() {
		$widget_ops = array( 'classname' => 'widget_searchbox', 'description' => '搜索' );
		$this->WP_Widget( 'widget_searchbox', 'D-搜索', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$place = $instance['place'];
		$button = $instance['button'];

		echo $before_widget;
		echo $before_title.$title.$after_title; 
		echo '<form method="get" class="search-form" action="'.esc_url( home_url( '/' ) ).'" ><input class="form-control" name="s" type="text" placeholder="'.$place.'" autofocus="" x-webkit-speech=""><input class="btn" type="submit" value="'.$button.'"></form>';
		echo $after_widget;
	}

	function form($instance) {
		$defaults = array( 'title' => '搜索', 'place' => '输入关键字', 'button' => '搜索' );
		$instance = wp_parse_args( (array) $instance, $defaults ); 
?>
		<p>
			<label>
				标题：
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		<p>
			<label>
				搜索框默认文字：
				<input class="widefat" id="<?php echo $this->get_field_id('place'); ?>" name="<?php echo $this->get_field_name('place'); ?>" type="text" value="<?php echo $instance['place']; ?>" />
			</label>
		</p>
		<p>
			<label>
				搜索按钮文字：
				<input class="widefat" id="<?php echo $this->get_field_id('button'); ?>" name="<?php echo $this->get_field_name('button'); ?>" type="text" value="<?php echo $instance['button']; ?>" />
			</label>
		</p>

<?php
	}
}



add_action( 'widgets_init', 'widget_comments_loader' );

function widget_comments_loader() {
	register_widget( 'widget_comments' );
}

class widget_comments extends WP_Widget {
	function widget_comments() {
		$widget_ops = array( 'classname' => 'widget_comments', 'description' => '显示网友最新评论（头像+名称+评论）' );
		$this->WP_Widget( 'widget_comments', 'D-最新评论', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$limit = $instance['limit'];
		$outer = $instance['outer'];

		echo $before_widget;
		echo $before_title.$title.$after_title; 
		echo '<ul>';

		global $wpdb;
		$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved,comment_author_email, comment_type,comment_author_url, SUBSTRING(comment_content,1,60) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE user_id!='".$outer."' AND comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $limit";
		$comments = $wpdb->get_results($sql);
		foreach ( $comments as $comment ) {
			$output .= $comment->user_id.'<li><a'.hui_target_blank().' href="'.get_permalink($comment->ID).'#comment-'.$comment->comment_ID.'" title="'.$comment->post_title.'上的评论">'.hui_get_avatar($user_id=$comment->user_id, $user_email=$comment->comment_author_email).strip_tags($comment->comment_author).' <span class="text-muted">'.timeago( $comment->comment_date_gmt ).'说：<br>'.str_replace(' src=', ' data-original=', convert_smilies(strip_tags($comment->com_excerpt))).'</span></a></li>';
		}
		
		echo $output;

		echo '</ul>';
		echo $after_widget;
	}

	function form($instance) {
		$defaults = array( 'title' => '最新评论', 'limit' => 8, 'outer' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );
?>
		<p>
			<label>
				标题：
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		<p>
			<label>
				显示数目：
				<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo $instance['limit']; ?>" />
			</label>
		</p>
		<p>
			<label>
				排除某用户ID：
				<input class="widefat" id="<?php echo $this->get_field_id('outer'); ?>" name="<?php echo $this->get_field_name('outer'); ?>" type="number" value="<?php echo $instance['outer']; ?>" />
			</label>
		</p>

<?php
	}
}



add_action( 'widgets_init', 'widget_postlist_loader' );
function widget_postlist_loader() {
	register_widget( 'widget_postlist' );
}

class widget_postlist extends WP_Widget {
	function widget_postlist() {
		$widget_ops = array( 'classname' => 'widget_postlist', 'description' => '图文展示（最新文章+热门文章+随机文章）' );
		$this->WP_Widget( 'widget_postlist', 'D-聚合文章', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title        = apply_filters('widget_name', $instance['title']);
		$limit        = $instance['limit'];
		$cat          = $instance['cat'];
		$orderby      = $instance['orderby'];
		$img = $instance['img'];

		$style='';
		if( !$img ) $style = ' class="nopic"';
		echo $before_widget;
		echo $before_title.$title.$after_title; 
		echo '<ul'.$style.'>';

		$args = array(
			'order'            => DESC,
			'cat'              => $cat,
			'orderby'          => $orderby,
			'showposts'        => $limit,
			'caller_get_posts' => 1
		);
		query_posts($args);
		while (have_posts()) : the_post(); 
		?>
		<li><a<?php echo hui_target_blank() ?> href="<?php the_permalink(); ?>"><?php if( $img ){echo '<span class="thumbnail">'; echo hui_get_thumbnail(); echo '</span>'; }else{$img = '';} ?><span class="text"><?php the_title(); ?></span><?php echo hui_get_views($class='text-muted post-views') ?></a></li>
		<?php
			
		endwhile; wp_reset_query();

		echo '</ul>';
		echo $after_widget;

	}

	function form( $instance ) {
		$defaults = array( 'title' => '最新文章', 'limit' => 8, 'orderby' => 'date', 'img' => 'on' );
		$instance = wp_parse_args( (array) $instance, $defaults );
?>
		<p>
			<label>
				标题：
				<input style="width:100%;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		<p>
			<label>
				排序：
				<select style="width:100%;" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" style="width:100%;">
					<option value="comment_count" <?php selected('comment_count', $instance['orderby']); ?>>评论数</option>
					<option value="date" <?php selected('date', $instance['orderby']); ?>>发布时间</option>
					<option value="rand" <?php selected('rand', $instance['orderby']); ?>>随机</option>
				</select>
			</label>
		</p>
		<p>
			<label>
				分类限制：
				<a style="font-weight:bold;color:#f60;text-decoration:none;" href="javascript:;" title="格式：1,2 &nbsp;表限制ID为1,2分类的文章&#13;格式：-1,-2 &nbsp;表排除分类ID为1,2的文章&#13;也可直接写1或者-1；注意逗号须是英文的">？</a>
				<input style="width:100%;" id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>" type="text" value="<?php echo $instance['cat']; ?>" size="24" />
			</label>
		</p>
		<p>
			<label>
				显示数目：
				<input style="width:100%;" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo $instance['limit']; ?>" size="24" />
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['img'], 'on' ); ?> id="<?php echo $this->get_field_id('img'); ?>" name="<?php echo $this->get_field_name('img'); ?>">显示图片
			</label>
		</p>
		
	<?php
	}
}




add_action( 'widgets_init', 'widget_tags_loader' );
function widget_tags_loader() {
	register_widget( 'widget_tags' );
}

class widget_tags extends WP_Widget {
	function widget_tags() {
		$widget_ops = array( 'classname' => 'widget_tags', 'description' => '显示热门标签' );
		$this->WP_Widget( 'widget_tags', 'D-标签云', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$count = $instance['count'];

		echo $before_widget;
		echo $before_title.$title.$after_title; 
		echo '<ul class="widget_tags_inner">';
		$tags_list = get_tags('orderby=count&order=DESC&number='.$count);
		if ($tags_list) { 
			$i = 0;
			foreach($tags_list as $tag) {
				$i++;
				echo '<li><a title="'.$tag->count.'个话题" href="'.get_tag_link($tag).'">'. $tag->name .'</a></li>'; 
			} 
		}else{
			echo '暂无标签！';
		}
		echo '</ul>';
		echo $after_widget;
	}

	function form($instance) {
		$defaults = array( 'title' => '热门标签', 'count' => 24 );
		$instance = wp_parse_args( (array) $instance, $defaults );
?>
		<p>
			<label>
				名称：
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				显示数量：
				<input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="number" value="<?php echo $instance['count']; ?>" class="widefat" />
			</label>
		</p>
<?php
	}
}




add_action( 'widgets_init', 'widget_ads_loader' );
function widget_ads_loader() {
	register_widget( 'widget_ads' );
}

class widget_ads extends WP_Widget {
	function widget_ads() {
		$widget_ops = array( 'classname' => 'widget_ads', 'description' => '显示一个广告(包括富媒体)' );
		$this->WP_Widget( 'widget_ads', 'D-广告', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$code = $instance['code'];

		echo $before_widget;
		echo '<div class="widget_ads_inner">'.$code.'</div>';
		echo $after_widget;
	}

	function form($instance) {
		$defaults = array( 'title' => '广告 '.date('m-d'), 'code' => '<a href="链接地址"><img src="图片地址"></a>' );
		$instance = wp_parse_args( (array) $instance, $defaults );
?>
		<p>
			<label>
				广告名称：
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				广告代码：
				<textarea id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>" class="widefat" rows="12" style="font-family:Courier New;"><?php echo $instance['code']; ?></textarea>
			</label>
		</p>
<?php
	}
}
