<?php
use Author\Service\AuthorService;
$authors = AuthorService::getAuthors();
?>
<h2>Authors</h2>
<div class="listing-sidebar-box">
	<ul>
		<?php foreach($authors as $author): ?>
		<?php $books = AuthorService::getAmountOfProductsByAuthor($author->ID); ?>
		<?php if($books > 0): ?>
		<li>
			<div class="thumb">
				<img src="<?php echo get_the_post_thumbnail_url($author->ID); ?>">
				<a class="link" href="<?php echo get_permalink($author->ID); ?>"><i aria-hidden="true" class="fa fa-plus"></i></a> 
			</div>
			<div class="text-column">
				<strong class="title"><?php echo $author->post_title; ?></strong>
				<span><?php echo $books; ?> Books</span>
			</div>
		</li>
		<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>