<?php global $product; ?>
<div class="row">
	<div class="col-md-12 product-description">
		<h4>Share This Free Nonprofit Resource!</h4>
		<div class="share-section">
			<div class="email" data-toggle="modal" data-target="#collectEmailModal">
				<i class="fa fa-envelope"></i>
			</div>
			<div class="facebook" onclick="shareResourceOnFacebook()">
				<i class="fa fa-facebook"></i>
			</div>
			<div class="twitter" onclick="shareResourceOnTwitter()">
				<i class="fa fa-twitter"></i>
			</div>
            <div class="linkedin" onclick="shareResourceOnLinkedin()">
                <i class="fa fa-linkedin"></i>
            </div>
		</div>
	</div>
</div>
<?php include_once 'email-modal.php'; ?>