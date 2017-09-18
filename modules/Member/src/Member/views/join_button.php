<?php if(wp_get_current_user()->ID === 0) : ?>
<button type="button" class="btn btn-join gfsn-btn-join" onclick="goTo('/library')">
	Browse and Join,<br>
	It's Free!
</button>
<?php endif; 