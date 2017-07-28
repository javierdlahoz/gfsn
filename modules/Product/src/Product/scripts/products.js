
document.addEventListener('DOMContentLoaded', function(){ 
	jQuery("#gfsn-price-free").on('click', function(event) {
		event.preventDefault();
		jQuery('#downloadProductButton').click();
	});
}, false);