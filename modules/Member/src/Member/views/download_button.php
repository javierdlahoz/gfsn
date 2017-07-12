<?php
	global $product;
	if($product->get_downloadable()):
?>
<div ng-app='gfsn' ng-controller="MemberController as vm" ng-cloak>
	<button class="btn btn-success btn-download" type="button" id="downloadProductButton"
		ng-click='vm.downloadFiles(<?php echo $product->get_id(); ?>)'>
		<i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Download
	</button>
	<?php include __DIR__. '/modal.php'; ?>
</div>
<?php 
endif;
if($_GET['subscribe'] === 'yes') :
	$user = wp_get_current_user();
?>
<script>
	jQuery(document).ready(function() {
		var user = {
			email: '<?php echo $user->user_email; ?>',
			first_name: '<?php echo $user->first_name; ?>',
			last_name: '<?php echo $user->last_name; ?>'
		};
		subscribeUser(user);
	});
</script>
<?php	endif;