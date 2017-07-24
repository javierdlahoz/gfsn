<?php
	$what = get_page_by_path('about-us/what-we-do');
	$who = get_page_by_path('about-us/who-we-are');
	$why = get_page_by_path('about-us/why-we-do-it');
?>
<div class="gfsn-about-section">
	<div class="container">
		<div class="row">
			<div class="col-md-4 about-section-content">
				<div class="about-section-icon">
					<i class="fa fa-commenting"></i>
				</div>
				<h2><?php echo $who->post_title; ?></h2>
				<p><?php echo $who->post_content; ?></p>
			</div>
			<div class="col-md-4 about-section-content">
				<div class="about-section-icon">
					<i class="fa fa-pencil"></i>
				</div>
				<h2><?php echo $what->post_title; ?></h2>
				<p><?php echo $what->post_content; ?></p>
			</div>
			<div class="col-md-4 about-section-content">
				<div class="about-section-icon">
					<i class="fa fa-question"></i>
				</div>
				<h2><?php echo $why->post_title; ?></h2>
				<p><?php echo $why->post_content; ?></p>
			</div>
		</div>
	</div>
</div>