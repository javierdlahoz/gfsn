<div id="collectEmailModal" class="modal fade ontop" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Share This Resource</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" style="display:none" id="collect-email-error"></div>
        <div class="alert alert-success" style="display:none" id="collect-email-success">
          Resource Shared Successfully
        </div>
        <div class="alert alert-warning" style="display:none" id="collect-email-wait">
          Please wait
        </div>
        <form onsubmit="return shareResourceToEmails(this)" id="collect-email-form">
          <div class="form-group">
            <p>Do you want to share this with? <small class="email-modal-small-info">(Separate addresses with commas)</small></p>
            <input type="text" class="form-control" placeholder="Emails" id="collected-emails" required="required">
            <!--p class="email-error" ng-show="vm.wrongEmail">Please enter a valid email address</p-->
          </div>
          <button type="submit" class="member-btn btn">Share</button>
        </form>
      </div>
    </div>
  </div>
</div>