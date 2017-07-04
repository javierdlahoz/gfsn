<?php 

use Author\Service\AuthorService;

global $post;
$authors = AuthorService::getAuthorsFromPost($post->ID);
if (count($authors) > 0):
?>
<div class="row">
<?php foreach ($authors as $author): ?>
	<div class="col-md-3 col-sm-6 text-center">
		<div class="author-chip-container">
			<center>
				<div class="author-avatar" style="background-image: url(<?php echo get_the_post_thumbnail_url($author->ID) ?>)"></div>
			</center>
			<div><b><?php echo $author->post_title; ?></b></div>
			<div class="btn-read-more-container">
				<a rel="nofollow" href="<?php echo get_post_permalink($author->ID); ?>" class="button product_type_simple ajax_add_to_cart author-more-btn">
				Read more</a>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>
<?php endif;