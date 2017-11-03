<?php 
$user = wp_get_current_user();
if($user->ID === 0) {
	echo '<script type="text/javascript">
		window.location.href = "/library";
	</script>';
}
?>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<h2><?php the_title(); ?></h2>
		<div class="alert alert-success">Please complete your first name and last name in the form below</div>
		<form action="/wp-content/plugins/gfsn/gfsn.php" method="POST" class="validate-account-form" onsubmit="return updateUserOnDrip();">
			<input type="hidden" name="validate_account" value="true">
			<div class="form-group">
				<label class="control-label required" id="first_name_label">This field is required *</label>
				<input type="text" name="first_name" id="first_name" class="form-control" placeholder="Your First Name" value="<?php echo $user->first_name; ?>">
			</div>
			<div class="form-group">
				<input type="text" id="last_name" name="last_name" class="form-control" placeholder="Your Last Name" value="<?php echo $user->last_name; ?>">
			</div>
			<div class="form-group">
				<div>To change your password, enter a new password below:</div>
				<input type="password" name="password" class="form-control" placeholder="Your Password" minLength="5">
			</div>
			<button type="submit" class="btn btn-success btn-block">Save & Start to Download Content</button>
		</form>
	</div>
</div>
<script>
	jQuery(document).ready(function() {
		var user = {
			email: '<?php echo $user->user_email; ?>'
		};
		subscribeUser(user);
		toogleFirstNameRequiredLabel();
		jQuery('#first_name').on('change', function() {
			toogleFirstNameRequiredLabel();
		});
	});

	function toogleFirstNameRequiredLabel() {
		var firstName = jQuery('#first_name').val();
		if(firstName) {
			jQuery('#first_name_label').hide();
		} else {
			jQuery('#first_name_label').show();
		}
	}

	function updateUserOnDrip() {
		var user = {
			email: "<?php echo $user->user_login; ?>",
			first_name: jQuery('#first_name').val(),
			last_name: jQuery('#last_name').val()
		};
		updateSubscriberOnDrip(user);
		return true;
	}
</script>