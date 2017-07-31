document.addEventListener('DOMContentLoaded', function(){ 
	jQuery("#gfsn-price-free").on('click', function(event) {
		event.preventDefault();
		jQuery('#downloadProductButton').click();
	});
}, false);

function goTo(url = '/') {
	window.location.href = url;
}