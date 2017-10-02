<?php global $product; ?>
<div class="row">
	<div class="col-md-12 product-description">
		<h4>Share This Resource</h4>
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
		</div>
	</div>
</div>
<?php include_once 'email-modal.php'; ?>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '2007003996185323',
      xfbml      : true,
      version    : 'v2.10'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>