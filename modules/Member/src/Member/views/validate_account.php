<?php 
$user = wp_get_current_user();
if($user->ID === 0) {
	echo '<script type="text/javascript">
		window.location.href = "/";
	</script>';
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="alert alert-success">Account successfully validated</div>
		<form action="/wp-content/plugins/gfsn/gfsn.php" method="POST" class="validate-account-form">
			<input type="hidden" name="validate_account" value="true">
			<div class="form-group">
				<input type="text" name="first_name" class="form-control" placeholder="Your First Name" 
					required="required" value="<?php echo $user->first_name; ?>">
			</div>
			<div class="form-group">
				<input type="text" name="last_name" class="form-control" placeholder="Your Last Name" 
					required="required" value="<?php echo $user->last_name; ?>">
			</div>
			<div class="form-group">
				<small>Leave it blank if you don't want to change your password</small>
				<input type="password" name="password" class="form-control" placeholder="Your Password" minLength="5">
			</div>
			<button type="submit" class="btn btn-success btn-block">Save</button>
		</form>
	</div>
</div>