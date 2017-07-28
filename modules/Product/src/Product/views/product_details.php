<?php 
use Author\Service\AuthorService;

global $post;
$mediaTypes = wp_get_post_terms($post->ID, 'media-type');
$authors = AuthorService::getAuthorsFromPost($post->ID);
?>
<div class="product_meta">
	<span class="posted_in">Price: <a href="" id="gfsn-price-free">Free, become a member today!</a></span> 
	<span class="posted_in">Media Type: 
		<?php foreach($mediaTypes as $mediaType): ?>
			<a href="" rel="tag"><?php echo $mediaType->name; ?></a>
		<?php endforeach; ?>
	</span>
	<?php if($authors && count($authors) > 0): ?>
	<span class="posted_in">Author: 
		<a href="<?php echo get_permalink($authors[0]->ID); ?>"><?php echo $authors[0]->post_title; ?></a>
	</span>
	<?php endif; ?>
</div>