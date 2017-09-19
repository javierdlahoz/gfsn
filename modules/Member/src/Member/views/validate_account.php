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
				<div>Leave it blank if you don't want to change your password</div>
				<input type="password" name="password" class="form-control" placeholder="Your Password" minLength="5">
			</div>
			<button type="submit" class="btn btn-success btn-block">Save & Start to Download Content</button>
		</form>
	</div>
</div>