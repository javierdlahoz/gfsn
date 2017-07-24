<div id="gfsnCarousel" class="carousel slide" data-ride="carousel">
  
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
		<?php foreach($sliders as $slide): ?>
		<div class="item active">
			<div class="gfsn-carousel-img" style="background-image: url('<?php echo wp_get_attachment_url(get_post_thumbnail_id($slide->ID)); ?>')">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6 gfsn-carousel-content">
							<div class="container">
								<div class="row">
									<div class="col-md-12 text-center">
										<h4>Test 4 echo!</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#gfsnCarousel" data-slide="prev">
		<div class="carousel-control-wrapper">
			<i class="fa fa-chevron-left"></i>
		</div>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#gfsnCarousel" data-slide="next">
    <div class="carousel-control-wrapper">
			<i class="fa fa-chevron-right"></i>
		</div>
    <span class="sr-only">Next</span>
  </a>
</div>