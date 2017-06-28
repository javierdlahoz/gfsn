angular.module('gfsn').controller('MemberController', MemberController);

function MemberController($scope, MemberService) {
	var vm = this;
	vm.MemberService = MemberService;
	vm.validated = false;
	vm.localProductId = null;
	vm.userLoggedIn = false;
	vm.nonce = null;
	vm.user = {email: null, password: null};
	vm.subscriber = {email: null};
	vm.tab = 'subscribe';
	vm.messageToShow = false;
	vm.retryMessage = false;
	vm.warningMessage = null;
	vm.wrongCredentials = false;
	vm.warningMessageType = 'warning';

	vm.downloadFiles = function(productId, nonce) {
		vm.localProductId = productId;
		vm.nonce = nonce;

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
		vm.initializeForms();
		vm.messageToShow = true;
		vm.warningMessage = 'Please wait';

		vm.MemberService.createUser(vm.subscriber, function(response) {
			vm.warningMessage = null;
			vm.userLoggedIn = true;
			vm.validated = response.validated;
			vm.handleDownloads();
		});
	}

	vm.login = function() {
		vm.initializeForms();
		vm.MemberService.login(vm.user, function(response) {
			if (response.success) {
				vm.validated = response.validated;
				vm.handleDownloads();
			} else {
				vm.wrongCredentials = true;
			}
		});
	}

	vm.isLoggedIn = function(restartForms = true) {
		if (restartForms) {
			vm.initializeForms();	
		}
		
		vm.MemberService.isLoggedIn(vm.nonce, function(response) {
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
		vm.MemberService.resendEmail(vm.nonce, function(response) {
			vm.warningMessageType = 'success';
			vm.warningMessage = 'Email sent, please check your email inbox';
		});
	}

	vm.initializeForms = function() {
		vm.wrongCredentials = false;
		vm.retryMessage = false;
		vm.warningMessage = null;
		vm.messageToShow = false;
		vm.warningMessageType = 'warning';
	}

	vm.toogleModal = function(show = true) {
		if (show) {
			jQuery("#subscribeModal").modal();	
		} else {
			jQuery("#subscribeModal").modal('hide');
		}
	}
}