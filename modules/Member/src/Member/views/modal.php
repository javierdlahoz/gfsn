<script src='https://www.google.com/recaptcha/api.js'></script>
<div id="subscribeModal" class="modal fade ontop" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">{{vm.modalTitle}}</h4>
      </div>
      <div class="modal-body">

	      <div ng-show="vm.messageToShow">
	      	<div class="alert alert-{{vm.warningMessageType}}" ng-show="vm.warningMessage">{{vm.warningMessage}}</div>
	      	<button type="button" class="member-btn btn btn-default" ng-show="vm.alreadyAMember"
	      		ng-click="vm.messageToShow = false; vm.tab = 'login'; vm.modalTitle = 'Log in for Instant Access'">Already a Member?</button>

	      	<div ng-show="vm.retryMessage">
	      		<p>
	      			<big>
	      				<b>One Last Step</b>, check the activation email sent to your mailbox by the system to activate your free membership
	      			</big>
	      		</p>
	      		<small>Note: Please check your "junk" folder in case you can't find our activation email.</small>
	      		<!--button class="btn btn-success" ng-click="vm.retryDownloadFiles()">Retry</button>
	      		<button class="btn btn-primary" ng-click="vm.resendEmail()">Resend Email</button-->
	      	</div>
	      </div>
      	
      	<div ng-hide="vm.messageToShow">
      		<form ng-submit="vm.createUser()" ng-show="vm.tab == 'subscribe'">
	          <div class="form-group">
							<input type="email" class="form-control" placeholder="Your Email" id="email" ng-model="vm.subscriber.email" 
								required="required" autofocus>
					    <input type="hidden" ng-model="vm.notarobot">
					  </div>
					  <!--div class="g-recaptcha" data-sitekey="6LcI1CcUAAAAALqCBdun8-YyGVMYZgz6--B1sy4S" data-callback="onCaptchaSuccess"></div-->
	          <button type="submit" class="member-btn btn" id="createUserBtn">Subscribe</button>
	          <button type="button" class="member-btn btn btn-default" 
	          	ng-click="vm.tab = 'login'; vm.modalTitle = 'Log in for Instant Access'">Already a Member?</button>
				  </form>

				  <form ng-show="vm.tab == 'login'" ng-submit="vm.login()">
		        <div class="form-group">
							<input type="email" placeholder="Your Email" class="form-control" ng-model="vm.user.email" 
								required="required" name="email" autofocus>
					  </div>
	          <div class="form-group">
					    <input type="password" placeholder="Your Password" class="form-control" ng-model="vm.user.password"
					    	minLength="5" required="required" name="password">
					  </div>
					  <div class="alert alert-danger" ng-show="vm.wrongCredentials">{{vm.wrongCredentialsMessage}}</div>
					  <a href="<?php echo wp_lostpassword_url(); ?>">Forgot your password?</a>
					  <button type="submit" class="btn member-btn">Login</button>
					  <button type="button" class="member-btn btn btn-default" 
					  	ng-click="vm.tab = 'subscribe'; vm.modalTitle = vm.defaultModalTitle">Subscribe as a new member</button>
				  </form>
      	</div>

      </div>
    </div>
  </div>
</div>
