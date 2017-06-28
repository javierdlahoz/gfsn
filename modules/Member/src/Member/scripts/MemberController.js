angular.module('gfsn').controller('MemberController', MemberController);

function MemberController($scope, MemberService) {
	var vm = this;
	vm.localProductId = null;
	vm.userLoggedIn = false;

	vm.downloadFiles = function(productId, nonce) {
		vm.localProductId = productId;
		console.log('working ok');
		/*if(vm.userLoggedIn) {
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
		}*/
	}
}