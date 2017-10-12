<?php
$user = wp_get_current_user();
if($user->ID !== 0){
    $firstName = $user->first_name;
    $lastName = $user->last_name;
}
?>
<div id="collectEmailModal" class="modal fade ontop" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Share This Free Nonprofit Resource!</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" style="display:none" id="collect-email-error"></div>
                <div class="alert alert-success" style="display:none" id="collect-email-success">
                    Resource successfully shared, thank you.
                </div>
                <div class="alert alert-warning" style="display:none" id="collect-email-wait">
                    Please wait
                </div>
                <form onsubmit="return shareResourceToEmails()" id="collect-email-form">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your First Name" name="first_name"
                               id="collected-fname" required="required" value="<?php echo $firstName; ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your Last Name" name="last_name"
                               id="collected-lname" required="required" value="<?php echo $lastName; ?>">
                    </div>
                    <div class="form-group">
                        <p>Who would you like to share this free nonprofit resource with?
                            <small class="email-modal-small-info">(Separate addresses with commas)</small>
                        </p>
                        <input type="text" class="form-control" placeholder="Email List" id="collected-emails"
                               required="required">
                    </div>
                    <button type="submit" class="member-btn btn">Share</button>
                </form>
            </div>
        </div>
    </div>
</div>