<?php 

use Author\Service\AuthorService;

global $post;
$authors = AuthorService::getAuthorsFromPost($post->ID);
if (count($authors) > 0):
?>
<div class="woocommerce">
	<div class="woocommerce-content">
		<ul class="products">
			<?php foreach ($authors as $author): ?>
				<li class="post-53 product type-product status-publish has-post-thumbnail product_cat-free-pdf first instock downloadable shipping-taxable product-type-simple">
					<a href="<?php echo get_permalink($author->ID); ?>" class="woocommerce-LoopProduct-link">
						<center>
							<div class="author-avatar" style="background-image: url(<?php echo get_the_post_thumbnail_url($author->ID) ?>)"></div>
						</center>
						<h3 class="woocommerce-loop-product__title"><?php echo $author->post_title; ?></h3>
					</a>
					<a rel="nofollow" href="<?php echo get_permalink($author->ID); ?>" 
						class="button product_type_simple ajax_add_to_cart">Show Bio</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

<?php endif;