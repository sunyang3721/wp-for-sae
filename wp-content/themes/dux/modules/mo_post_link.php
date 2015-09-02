<?php  
/**
 * [mo_post_link description]
 * @return [type] [description]
 */
function mo_post_link(){
    global $post;
    $post_ID = $post->ID;
    $link = get_post_meta($post_ID, 'link', true);

    if( $link ){
    	echo '<div class="post-linkto"><a class="btn btn-primary" href="'. $link .'"'. (_hui('post_link_blank_s')?' target="_blank"':'') . (_hui('post_link_nofollow_s')?' rel="external nofollow"':'') .'>'. (is_single()?'<i class="glyphicon glyphicon-share-alt"></i>':'') ._hui('post_link_h1') .' <i class="fa fa-hand-o-right"></i></a></div>';
    }
}