document.addEventListener('DOMContentLoaded', function(){ 
	jQuery("#gfsn-price-free").on('click', function(event) {
		event.preventDefault();
		jQuery('#downloadProductButton').click();
	});
}, false);

function goTo(url = '/') {
	window.location.href = url;
}

function shareResourceToEmails(form) {
	var form = jQuery('#collect-email-form');
	var alert = jQuery('#collect-email-error');
	var successAlert = jQuery("#collect-email-success");
	var emailList = jQuery('#collected-emails').val().replace(/ /g,'');
	var emails = emailList.split(",");
	jQuery(alert).hide();
	jQuery(successAlert).hide();

	for(var i=0; i < emails.length; i++) {
		if(!validateEmailFromList(emails[i])){
			jQuery(alert).text('The value "' + emails[i] + '" is not a valid email');
			jQuery(alert).show();
			return false;
		}
	}
	// subscribeEmails(emails);
	jQuery(successAlert).show();
	jQuery(form).hide();
	return false;
}

function validateEmailFromList(email) {
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

function subscribeEmails(emails) {
	var user = {};
	for(var i=0; i < emails.length; i++) { 
		user = {email: emails[i], first_name: '', last_name: ''};
		subscribeUser(user);
	}
}