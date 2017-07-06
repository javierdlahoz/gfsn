<?php 

if(wp_get_current_user()->ID === 0) {
	echo '<script type="text/javascript">
		window.location.href = "/";
	</script>';
}

use Member\Controller\MemberController;

$user = wp_get_current_user();
$cUser = get_userdata($user->ID);
if($_POST['first_name']) {
	if(MemberController::updateCurrentUser()) {
		$redirectUrl = get_user_meta($user->ID, MemberController::REDIRECT_URL, true);
		// echo '<script type="text/javascript">
		// window.location.href = "'.$redirectUrl.'";
		// </script>';
	}
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="alert alert-success">Account successfully validated</div>
		<form action="" method="POST">
			<div class="form-group">
				<input type="text" name="first_name" class="form-control" placeholder="Your First Name" 
					required="required" value="<?php echo $user->first_name; ?>">
			</div>
			<div class="form-group">
				<input type="text" name="last_name" class="form-control" placeholder="Your Lasst Name" 
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