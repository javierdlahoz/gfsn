<?php if ( $sliders->have_posts() ) : ?>
<div id="gfsnCarousel" class="carousel slide" data-ride="carousel">
  
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
		<?php while ($sliders->have_posts()) : $sliders->the_post(); ?>
		<div class="item active">
			<div class="gfsn-carousel-img" style="background-image: url('<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>')">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6 gfsn-carousel-content">
							<div class="container">
								<div class="row">
									<div class="col-md-12 text-center">
										<?php the_content(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endwhile; ?>
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
<?php endif; 