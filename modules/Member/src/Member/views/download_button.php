<?php
	global $product;
	if($product->get_downloadable()):
?>
<button class="btn btn-success btn-download" type="button" 
	onclick='downloadFiles(<?php echo $product->get_id(); ?>, "<?php echo wp_create_nonce('wp_rest') ?>")'>
	Download
</button>

<?php include __DIR__. '/modal.php'; ?>
<?php endif; 