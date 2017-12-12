<div class="row" ng-app='gfsn' ng-controller="MemberController as vm" ng-cloak>
	<div class="col-md-6 col-md-offset-3 text-center">
		<h4>Please enter your credentials</h4>
		<form ng-submit="vm.loginAndRedirect()">
		<div class="form-group">
			<input type="email" placeholder="Your Email" class="form-control" ng-model="vm.user.email" required="required" name="email">
		</div>
		<div class="form-group">
			<input type="password" placeholder="Your Password" class="form-control" ng-model="vm.user.password"
				minLength="5" required="required" name="password">
		</div>
		<div class="alert alert-warning" ng-show="vm.loading">Please Wait...</div>
		<div class="alert alert-danger" ng-show="vm.wrongCredentials">{{vm.wrongCredentialsMessage}}</div>
		<a href="/my-account/lost-password">Forgot your password?</a>
		<button type="submit" class="btn member-btn">Login</button>
	</form>
	</div>
</div>