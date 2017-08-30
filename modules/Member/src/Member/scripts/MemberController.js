angular.module('gfsn').controller('MemberController', MemberController);

function onCaptchaSuccess() {
	jQuery('#createUserBtn').prop("disabled", false);
}

function MemberController($scope, MemberService) {
	var vm = this;
	vm.defaultModalTitle = "To Download, Become a Member Today. It's Free!";
	vm.MemberService = MemberService;
	vm.validated = false;
	vm.localProductId = null;
	vm.userLoggedIn = false;
	vm.user = {email: null, password: null};
	vm.subscriber = {email: null, redirectUrl: window.location.href};
	vm.tab = 'subscribe';
	vm.messageToShow = false;
	vm.retryMessage = false;
	vm.warningMessage = null;
	vm.wrongCredentials = false;
	vm.warningMessageType = 'warning';
	vm.notarobot = true;
	vm.alreadyAMember = false;
	vm.modalTitle = vm.defaultModalTitle;
	vm.wrongCredentialsMessage = 'Wrong credentials';
	
	vm.initialize = function() {
		if (vm.getParameterByName('action') === 'download') {
			jQuery(document).ready(function() {
				jQuery("#downloadProductButton").click();
			});
		}
	}

	vm.downloadFiles = function(productId) {
		vm.localProductId = productId;

		if (vm.userLoggedIn) {
			if (vm.validated) {
				vm.getFilesAndDownload(productId);	
			} else {
				vm.handleDownloads();
			}
		} else {
			vm.isLoggedIn();
		}
	}

	vm.createUser = function() {
		if(vm.notarobot !== true) {
			return false;
		}
		vm.initializeForms();
		vm.messageToShow = true;
		vm.warningMessage = 'Please wait';

		vm.MemberService.createUser(vm.subscriber, function(response) {
			if (response.success) {
				vm.warningMessage = null;
				vm.modalTitle = 'Thank You from Nonprofit Library';
				vm.validated = response.validated;
				vm.handleDownloads();
			} else {
				vm.warningMessage = 'This email is already in use. Already a member?';
				vm.warningMessageType = 'danger';
				vm.alreadyAMember = true;
			}
		});
	}

	vm.login = function() {
		vm.initializeForms();
		vm.MemberService.login(vm.user, function(response) {
			if (response.success) {
				vm.validated = response.validated;
				vm.handleDownloads();
			} else {
				vm.wrongCredentialsMessage = response.data.message;
				vm.wrongCredentials = true;
			}
		});
	}

	vm.loginAndRedirect = function() {
		vm.initializeSubscription();
		vm.messageToShow = true;
		vm.warningMessage = 'Please Wait';
		vm.MemberService.login(vm.user, function(response) {
			if (response.success) {
				vm.warningMessage = 'Redirecting...'
				vm.validated = response.validated;
				window.location.href = '/my-account/edit-account';
			} else {
				vm.wrongCredentialsMessage = response.data.message;
				vm.messageToShow = false;
				vm.wrongCredentials = true;
			}
		});
	}

	vm.isLoggedIn = function(restartForms = true) {
		if (restartForms) {
			vm.initializeForms();	
		}
		
		vm.MemberService.isLoggedIn(function(response) {
			vm.warningMessage = false;
			if (response.success) { 
				vm.validated = response.validated;
				vm.userLoggedIn = true;
				vm.handleDownloads();
			} else {
				vm.userLoggedIn = false;
				vm.toogleModal();
			}
		});
	}

	vm.handleDownloads = function() {
		if(vm.validated) {
			vm.getFilesAndDownload();
			vm.toogleModal(false);
		} else {
			vm.messageToShow = true;
			vm.retryMessage = true;
			vm.toogleModal();
		}
	}

	vm.getFilesAndDownload = function() {
		vm.MemberService.getFilesFromProduct(vm.localProductId, function(response) {
			for(var i = 0; i < response.files.length; i ++ ) {
				vm.downloadFile(response.files[i]);
			}
		});	
	}

	vm.downloadFile = function(file) {
		var link = document.createElement('a');
		link.href = file;
		link.download = file;
		document.body.appendChild(link);
		link.click();
	}

	vm.retryDownloadFiles = function() {
		vm.messageToShow = true;
		vm.warningMessageType = 'warning';
		vm.warningMessage = 'Please wait';
		vm.isLoggedIn(false);
	}

	vm.resendEmail = function() {
		vm.warningMessage = 'Please wait';
		vm.MemberService.resendEmail(function(response) {
			vm.warningMessageType = 'success';
			vm.warningMessage = 'Email sent, please check your email inbox';
		});
	}

	vm.initializeForms = function() {
		vm.modalTitle = vm.defaultModalTitle;
		vm.wrongCredentials = false;
		vm.retryMessage = false;
		vm.warningMessage = null;
		vm.messageToShow = false;
		vm.warningMessageType = 'warning';
		vm.alreadyAMember = false;
	}

	vm.initializeSubscription = function() {
		vm.wrongCredentials = false;
		vm.retryMessage = false;
		vm.warningMessage = null;
		vm.messageToShow = false;
		vm.warningMessageType = 'warning';
		vm.alreadyAMember = false;
	}

	vm.toogleModal = function(show = true) {
		if (show) {
			jQuery("#subscribeModal").modal();	
		} else {
			jQuery("#subscribeModal").modal('hide');
		}
	}

	vm.getParameterByName = function(name) {
    var url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
	}

	vm.initialize();
}