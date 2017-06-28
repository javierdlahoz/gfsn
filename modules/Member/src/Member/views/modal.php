<div id="subscribeModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Download Files</h4>
      </div>
      <div class="modal-body">

      	<div class="alert alert-warning" id="modalWait" style="display: none">Please wait</div>

      	<div id="notValidated" style="display: none">
      		<p>Your account hasn't been validated yet, please check your email and validate your account</p>
      		<button class="btn btn-success" onclick="retryDownloadFiles()">Retry</button>
      	</div>

	  		<form id="subscribeForm">
	        <p>Subscribtion is free, just introduce your email address</p>
          <div class="form-group">
				    <label for="email">Email address:</label>
				    <input type="email" class="form-control" id="email" required="required">
				  </div>
          <p><a href="#" onclick="showLoginForm(); return false;">Already a Member?</a></p>
				  <button type="submit" class="btn btn-success">Subscribe</button>
			  </form>

			  <form id="loginForm" style="display: none">
	        <div class="form-group">
				    <label for="email">Email address:</label>
				    <input type="email" class="form-control" id="login_email" required="required">
				  </div>
          <div class="form-group">
				    <label for="password">Password:</label>
				    <input type="password" class="form-control" id="login_password" minLength="5" required="required">
				  </div>
				  <p><a href="#" onclick="showRegistrationForm(); return false;">Subscribe as a new member</a></p>
				  <p><a href="<?php echo wp_lostpassword_url(); ?>">Forgot your password?</a></p>
				  <div class="alert alert-danger" id="loginWrongCredentials" style="display: none">Wrong Credentials</div>
				  <button type="submit" class="btn btn-success">Login</button>
			  </form>

			  <div id="subscritionSuccess" style="display: none">
			  	<h2>Thanks for your subscrition</h2>
			  </div>
      </div>
    </div>
  </div>
</div>
