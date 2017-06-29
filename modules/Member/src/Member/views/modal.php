<div id="subscribeModal" class="modal fade ontop" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Download Files</h4>
      </div>
      <div class="modal-body">

	      <div ng-show="vm.messageToShow">
	      	<div class="alert alert-{{vm.warningMessageType}}" ng-show="vm.warningMessage">{{vm.warningMessage}}</div>

	      	<div ng-show="vm.retryMessage">
	      		<p>Your account hasn't been validated yet, please check your email and validate your account</p>
	      		<button class="btn btn-success" ng-click="vm.retryDownloadFiles()">Retry</button>
	      		<button class="btn btn-primary" ng-click="vm.resendEmail()">Resend Email</button>
	      	</div>
	      </div>
      	
      	<div ng-hide="vm.messageToShow">
      		<form ng-submit="vm.createUser()" ng-show="vm.tab == 'subscribe'">
		        <p>Subscribtion is free, just introduce your email address</p>
	          <div class="form-group">
					    <label for="email">Email address:</label>
					    <input type="email" class="form-control" id="email" ng-model="vm.subscriber.email" required="required">
					  </div>
					  <div class="form-group">
					    <label for="firstName">First name:</label>
					    <input type="text" class="form-control" id="firstName" ng-model="vm.subscriber.firstName" required="required">
					  </div>
					  <div class="form-group">
					    <label for="lastName">Last name:</label>
					    <input type="text" class="form-control" id="lastName" ng-model="vm.subscriber.lastName" required="required">
					  </div>
	          <p><a href="#" ng-click="vm.tab = 'login'">Already a Member?</a></p>
					  <button type="submit" class="btn btn-success">Subscribe</button>
				  </form>

				  <form ng-show="vm.tab == 'login'" ng-submit="vm.login()">
		        <div class="form-group">
					    <label for="email">Email address:</label>
					    <input type="email" class="form-control" ng-model="vm.user.email" required="required" name="email">
					  </div>
	          <div class="form-group">
					    <label for="password">Password:</label>
					    <input type="password" class="form-control" ng-model="vm.user.password" minLength="5" required="required" name="password">
					  </div>
					  <div class="alert alert-danger" ng-show="vm.wrongCredentials">Wrong Credentials</div>
					  <p><a href="#" ng-click="vm.tab = 'subscribe'">Subscribe as a new member</a></p>
					  <p><a href="<?php echo wp_lostpassword_url(); ?>">Forgot your password?</a></p>
					  <button type="submit" class="btn btn-success">Login</button>
				  </form>
      	</div>

      </div>
    </div>
  </div>
</div>
