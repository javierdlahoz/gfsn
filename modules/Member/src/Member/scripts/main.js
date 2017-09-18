angular.module('gfsn', []);
function goTo(url) {
	window.location.href = url;
}
function openSubscribeModal() {
	var downloadModal = jQuery('#subscribeModal');
	if(downloadModal.length && downloadModal.length > 0) {
		jQuery(downloadModal).modal('show');
	} else {
		jQuery('#subscribeMemberModal').modal('show');
	}
}