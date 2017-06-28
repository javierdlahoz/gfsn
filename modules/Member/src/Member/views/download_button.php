<?php
	global $product;
	if($product->get_downloadable()):
?>
<div ng-app='gfsn' ng-controller="MemberController as vm" ng-cloak>
	<button class="btn btn-success btn-download" type="button" id="downloadProductButton"
		ng-click='vm.downloadFiles(<?php echo $product->get_id(); ?>)'>
		Download
	</button>
	<?php include __DIR__. '/modal.php'; ?>
</div>
<?php endif; 