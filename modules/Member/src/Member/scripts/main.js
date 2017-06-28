angular.module('gfsn', []);

var formId = "#subscribeForm";
var loginFormId = "#loginForm";
var subscritionSuccess = "#subscritionSuccess";
var wrongCredentials = "#loginWrongCredentials";
var localFiles = [];
var localProductId = null;
var userLoggedIn = false;
var isValidated = false;

/*document.addEventListener('DOMContentLoaded', function(){ 
  jQuery(formId).submit(function(event) {
		event.preventDefault();
		subscribeUser(jQuery(formId));
	});

	jQuery(loginForm).submit(function(event) {
		event.preventDefault();
		login();
	});	  
}, false);

function getFilesAndDownload(productId) {
	var url = '/wp-json/gfsn-api/membership/files?product_id=' + productId;
	jQuery.get(url, function(response) {
		for(var i = 0; i < response.files.length; i ++ ) {
			downloadFile(response.files[i]);
		}
	});
}

function retryDownloadFiles() {
	jQuery("#subscribeModal").modal('hide');
	downloadFiles(localProductId);	
}

function downloadFiles(productId, nonce) {
	localProductId = productId;

	if(userLoggedIn) {
		getFilesAndDownload(productId);
	} else {
		var url = '/wp-json/gfsn-api/membership/logged-in?_wpnonce=' + nonce;

		jQuery.get(url, function(data) {
			if (data.success) {
				isValidated = data.validated;
				if(data.validated) {
					userLoggedIn = true;
					getFilesAndDownload(productId);
				}
				else {
					jQuery("#notValidated").show();
					jQuery("#subscribeForm").hide();
					jQuery("#subscribeModal").modal();
				}
			}
			else {
				jQuery("#subscribeModal").modal();	
			}
		});
	}
}

function downloadFile(file) {
	var link = document.createElement('a');
	link.href = file;
	link.download = file;
	document.body.appendChild(link);
	link.click();
}

function subscribeUser(form) {
	var inputs = jQuery(formId + ' :input');
	var values = {};
  var key = '';
  inputs.each(function() {
  	key = jQuery(this).attr('id');
  	if (key) {
  		values[jQuery(this).attr('id')] = jQuery(this).val();	
  	}
  });
  createUser(values);
}

function createUser(user){
	var url = '/wp-json/gfsn-api/membership';
	showWaitMessage();

	jQuery.post(url, user, function(data) {
		getFilesAndDownload(localProductId);
		userLoggedIn = true;

		jQuery(formId).hide();
		jQuery("#modalWait").hide();
		jQuery(subscritionSuccess).show();

		setTimeout(function() {
			closeSubscribtionModal();
		}, 3000);
		
	})
	.fail(function(data) {
		console.log(data);
	});
}

function login() {
	jQuery(wrongCredentials).hide();
	var url = '/wp-json/gfsn-api/membership/login';
	var user = {
		email: jQuery("#login_email").val(),
		password: jQuery("#login_password").val()
	};

	jQuery.post(url, user, function(data) {
		if (data.success) {
			closeSubscribtionModal();
			getFilesAndDownload(localProductId);
		} else {
			jQuery(wrongCredentials).show();
		}
	});
}

function closeSubscribtionModal() {
	jQuery("#subscribeModal").modal('hide');
}

function showLoginForm() {
	jQuery("#subscribeForm").hide();
	jQuery("#loginForm").show();
}

function showRegistrationForm() {
	jQuery("#subscribeForm").show();
	jQuery("#loginForm").hide();
}

function showWaitMessage() {
	jQuery("#modalWait").show();
	jQuery("#subscribeForm").hide();	
}*/