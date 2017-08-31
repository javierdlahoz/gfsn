<div class="row" ng-app='gfsn' ng-controller="MemberController as vm" ng-cloak>
	<div class="col-md-12">
		<form ng-submit="vm.login()">
		<div class="form-group">
			<input type="email" placeholder="Your Email" class="form-control" ng-model="vm.user.email" required="required" name="email">
		</div>
		<div class="form-group">
			<input type="password" placeholder="Your Password" class="form-control" ng-model="vm.user.password"
				minLength="5" required="required" name="password">
		</div>
		<div class="alert alert-danger" ng-show="vm.wrongCredentials">{{vm.wrongCredentialsMessage}}</div>
		<a href="<?php echo wp_lostpassword_url(); ?>">Forgot your password?</a>
		<button type="submit" class="btn member-btn">Login</button>
	</form>
	</div>
</div>