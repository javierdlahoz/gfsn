angular.module('gfsn', []);
function goTo(url) {
	window.location.href = url;
}
function openSubscribeModal() {
	var downloadModal = jQuery('#subscribeModal');
	if(downloadModal.length && downloadModal.length > 0) {
		openDownloadModal(true);
	} else {
		jQuery('#subscribeMemberModal').modal('show');
	}
}
function openDownloadModal(show = true) {
	if (show) {
		jQuery("#subscribeModal").modal();	
	} else {
		jQuery("#subscribeModal").modal('hide');
	}
}
jQuery(document).ready(function() {
	jQuery('#subscribeModal').on('shown.bs.modal', function () {
		jQuery('#subscribeModal #email').focus();
	});
	jQuery('#subscribeMemberModal').on('shown.bs.modal', function () {
		jQuery('#subscribeMemberModal #email').focus();
	});
});