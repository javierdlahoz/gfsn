angular.module('gfsn').controller('MemberController', MemberController);

function MemberController($scope, MemberService) {
	var vm = this;
	vm.MemberService = MemberService;
	vm.validated = false;
	vm.localProductId = null;
	vm.userLoggedIn = false;
	vm.nonce = null;
	vm.user = {user_login: null, user_password: null};
	vm.subscriber = {email: null};
	vm.tab = 'subscribe';
	vm.messageToShow = false;
	vm.retryMessage = false;
	vm.warningMessage = null;
	vm.wrongCredentials = false;

	vm.downloadFiles = function(productId, nonce) {
		vm.localProductId = productId;
		vm.nonce = nonce;

		if(vm.userLoggedIn) {
			vm.getFilesAndDownload(productId);
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

	vm.isLoggedIn = function() {
		vm.initializeForms();
		vm.MemberService.isLoggedIn(vm.nonce, function(response) {
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

	vm.initializeForms = function() {
		vm.retryMessage = false;
		vm.warningMessage = null;
		vm.messageToShow = false;
	}

	vm.toogleModal = function(show = true) {
		if (show) {
			jQuery("#subscribeModal").modal();	
		} else {
			jQuery("#subscribeModal").modal('hide');
		}
	}
}