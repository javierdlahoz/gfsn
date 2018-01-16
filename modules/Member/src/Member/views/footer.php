<div class="footer-btm-row footer-wrapper">
  <div class="container">
    <div class="col-md-6 col-sm-12">
      <h4>Follow Us:</h4>
      <div class="footer-social-wrapper">
        <a href="https://www.facebook.com/NonprofitLibrary/" target="_blank">
          <div class="footer-social-network facebook">
            <i class="fa fa-facebook"></i>
          </div>
        </a>
        <a href="https://twitter.com/nonprofit_lib" target="_blank">
          <div class="footer-social-network twitter">
            <i class="fa fa-twitter"></i>
          </div>
        </a>
        <a href="https://www.linkedin.com/company/11219667/" target="_blank">
          <div class="footer-social-network linkedin">
            <i class="fa fa-linkedin"></i>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-6 col-sm-12">
      <div class="pull-right">
        <?php $cUser = wp_get_current_user();
          if($cUser->ID === 0) : ?>
            <a href="/login"><button type="button" class="btn btn-login">Log In</button></a>
            <button type="button" class="btn btn-join" onclick="openSubscribeModal()">
              Join for Free Today
            </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>