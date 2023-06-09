<?php
namespace Sepid;
use Walker_Comment;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Comments_Walker extends Walker_Comment {
	var $tree_type = 'comment';
	var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

	// constructor – wrapper for the comments list
	function __construct() { ?>

		<section class="comments-list">

	<?php }

	// start_lvl – wrapper for child comments list
function start_lvl( &$output, $depth = 0, $args = array() ) {
	$GLOBALS['comment_depth'] = $depth + 2; ?>

	<section class="child-comments comments-list">

<?php }

	// end_lvl – closing wrapper for child comments list
function end_lvl( &$output, $depth = 0, $args = array() ) {
	$GLOBALS['comment_depth'] = $depth + 2; ?>

	</section>

<?php }

	// start_el – HTML for comment template
function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
	$depth++;
	$GLOBALS['comment_depth'] = $depth;
	$GLOBALS['comment'] = $comment;
	$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );

	if ( 'article' == $args['style'] ) {
		$tag = 'article';
		$add_below = 'comment';
	} else {
		$tag = 'article';
		$add_below = 'comment';
	} ?>
	<div <?php comment_class(empty( $args['has_children'] ) ? '' :'parent') ?> id="comment-<?php comment_ID() ?>" itemprop="comment" itemscope itemtype="http://schema.org/Comment">
	<article >
		<div class="comment-meta post-meta" role="complementary">
			<figure class="gravatar"><?php echo get_avatar( $comment, 32 ); ?></figure>
			<strong class="comment-author">
				<a class="comment-author-link" href="<?php comment_author_url(); ?>" itemprop="author"><?php comment_author(); ?></a>
			</strong>
		</div>
		<div class="comment-content post-content" itemprop="text">
			<?php comment_text() ?>
			<?php if ($comment->comment_approved == '0') : ?>
				<p class="comment-wait-for-approved">دیدگاه شما پس از تایید مدیر نمایش داده می شود.</p>
			<?php endif; ?>
			<time class="comment-meta-item" datetime="<?php comment_date('Y-m-d') ?>T<?php comment_time('H:iP') ?>" itemprop="datePublished"><?php comment_date('j F Y') ?></time>
			<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</div>
	</article>

<?php }

	// end_el – closing HTML for comment template
function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>


	</div>

<?php }

	// destructor – closing wrapper for the comments list
	function __destruct() { ?>

		</section>

	<?php }

}


?>