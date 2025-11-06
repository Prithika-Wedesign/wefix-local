<?php if ( ! defined( 'ABSPATH' ) ) { exit; }

global $post;
$author_id = $post->post_author;
?>

<!-- Entry Author -->
<div class="single-entry-author">
	<div class="meta-author-img">
		<?php echo get_avatar($author_id, 40 );?>
	</div>
	<div class="meta-author-info">
		<span><?php esc_html_e('by', 'wefix-pro'); ?></span>
		<a href="<?php echo get_author_posts_url($author_id);?>" title="<?php esc_attr_e('View all posts by ', 'wefix-pro'); echo get_the_author_meta( 'nicename', $author_id );?>"><?php echo get_the_author_meta( 'nicename', $author_id );?></a>
    </div>
    <div class="author-hover-details">
        <div class="author-hover-img">
            <?php echo get_avatar($author_id, 70 );?>
        </div>
        <div class="author-hover-info">
            <a href="<?php echo get_author_posts_url($author_id);?>" title="<?php esc_attr_e('View all posts by ', 'wefix-pro'); echo get_the_author_meta( 'nicename', $author_id );?>"><?php echo get_the_author_meta( 'nicename', $author_id );?></a>
            <p><?php echo get_the_author_meta( 'user_description', $author_id );?></p>
        </div>
    </div>
</div><!-- Entry Author -->