document.addEventListener('DOMContentLoaded', function(){ 
	jQuery("#gfsn-price-free").on('click', function(event) {
		event.preventDefault();
		jQuery('#downloadProductButton').click();
	});
}, false);

function goTo(url = '/') {
	window.location.href = url;
}

function getResource() {
	return {
		url: window.location.href,
		title: document.title
	};
}

function shareResourceToEmails() {
	window.collectForm = jQuery('#collect-email-form');
	window.waitAlert = jQuery("#collect-email-wait");
	window.successAlert = jQuery("#collect-email-success");

	var alert = jQuery('#collect-email-error');
	var emailList = jQuery('#collected-emails').val().replace(/ /g,'');
	var emails = emailList.split(",");
	jQuery(alert).hide();
	jQuery(window.successAlert).hide();

	for(var i=0; i < emails.length; i++) {
		if(!validateEmailFromList(emails[i])){
			jQuery(alert).text('The value "' + emails[i] + '" is not a valid email');
			jQuery(alert).show();
			return false;
		}
	}
	
	subscribeEmails(emails);
	shareResource(emails);
	return false;
}

function validateEmailFromList(email) {
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

function subscribeEmails(emails) {
	for(var i=0; i < emails.length; i++) { 
		subscribeEmailToDrip(emails[i]);
	}
}

function shareResource(emails) {
	jQuery(window.collectForm).hide();
	jQuery(window.waitAlert).show();
	jQuery.ajax({
		type: "POST",
		url: '/wp-json/gfsn-api/membership/share-resource',
		data: {emails: emails, resource: getResource()},
		success: function() {
			handleSuccessSharing();
		},
		dataType: 'json'
	});
}

function handleSuccessSharing() {	
	jQuery(window.waitAlert).hide();
	jQuery(window.successAlert).show();
}

function shareResourceOnFacebook() {
    FB.ui({method: 'share', href: window.location.href});
}

function shareResourceOnTwitter() {
	var text = 'Check out this awesome nonprofit resource.';
	var resourceUrl = window.location.href;
	var url = "https://twitter.com/intent/tweet?text=" + text + "&url=" + resourceUrl + "&hashtags=free,nonprofit&via=nonprofit_lib";
	var win = window.open(url, '_blank');
  	win.focus();
}

function shareResourceOnLinkedin() {
    var text = 'Check out this awesome nonprofit resource.';
    var resourceUrl = window.location.href;
    var url = "http://www.linkedin.com/shareArticle?mini=true&url=" + resourceUrl;
    url += "&title=" + text;
    var win = window.open(url, '_blank');
    win.focus();
}