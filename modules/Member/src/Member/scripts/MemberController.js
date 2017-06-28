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
		vm.MemberService.createUser(vm.subscriber, function(response) {
			console.log(response);
		});
	}

	vm.login = function() {
		vm.MemberService.login(vm.user, function(response) {
			console.log(response);
		});
	}

	vm.isLoggedIn = function() {
		vm.MemberService.isLoggedIn(vm.nonce, function(response) {
			if (response.success) { 
				vm.validated = response.validated;
				vm.userLoggedIn = true;
				if(response.validated) {
					vm.getFilesAndDownload();
				}
			} else {
				vm.userLoggedIn = false;
				jQuery("#subscribeModal").modal();
			}
		});
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
}