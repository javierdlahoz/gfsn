<?php
$products = \Member\Service\MemberService::getDownloadedProductsByUserId($user->ID);
if(!empty($products)):
?>
<h2>Downloaded Products</h2>
<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th id="columnname" class="manage-column column-columnname" scope="col">Resource</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($products as $product): ?>
		<tr>
			<td class="column-columnname">
				<a href="<?php echo get_permalink($product->id); ?>" target="_blank"><?php echo $product->name; ?></a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; 