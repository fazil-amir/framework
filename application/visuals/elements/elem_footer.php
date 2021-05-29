<?php

function _getFooterLinksFromLib($AC = null) {
  $ci = & get_instance();
  $ci -> load -> library('../../modules/block_cms/library/Block_cms');
  return $ci -> block_cms -> getPartialPage($AC);
}

function getFooterLink() {
  $pages = _getFooterLinksFromLib('PRODUCT_PAGE');
  $results = '';
  foreach($pages as $page) {
    $results .= '<li><a class="pr-3" href="' . getHref($page['seo_uri'], $page['category']['seo_uri']) . '">' . titleCase($page['caption']) . '</a></li>';
  }
  return $results;
}

function getGenericLink() {
  $pages = _getFooterLinksFromLib('GENERIC_PAGE');
  $results = '';
  foreach($pages as $page) {
    $results .= '<li><a class="pr-3" href="' . getHref($page['seo_uri'], '', 'page/') . '">' . titleCase($page['caption']) . '</a></li>';
  }
  return $results;
}

?>
<footer class="ftco-footer ftco-bg-dark ftco-section">
  <div class="container">

    <div class="row">

      <div class="col-md-12 mb-5">
        <div class="ftco-footer-widget">
          <h2 class="ftco-heading-2">Have a Questions?</h2>
          <div class="block-23">
            <ul>
              <li>
                <span class="icon icon-map-marker"></span>
                <span class="text" data-live-edit-id='footer:contact:address'>Office No. M-01, Building No: C-135, MBZ City ME-9, Abu Dhabi, UAE.P.O.Box 28687 </span>
              </li>
              <li>
                <a href="#" class="mb-0">
                  <span class="icon icon-phone"></span>
                  <span class="text" data-live-edit-id='footer:contact:phone'> +971 2 55 66 55 3</span>
                </a>
              </li>
              <li>
                <a href="#" class="mb-0">
                  <span class="icon icon-envelope"></span>
                  <span class="text" data-live-edit-id='footer:contact:email'>info@superfmuae.com</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="ftco-footer-widget">
          <h2 class="ftco-heading-2">Services</h2>
          <div class="block-23">
            <ul class="d-flex flex-wrap">
              <?php echo getFooterLink(); ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="ftco-footer-widget">
          <h2 class="ftco-heading-2">Links</h2>
          <div class="block-23">
            <ul class="d-flex flex-wrap">
              <li><a class="pr-3" href="<?php echo baseURL(); ?>">Home</a></li>
              <li><a class="pr-3" href="<?php echo baseURL('about-us'); ?>">About</a></li>
              <li><a class="pr-3" href="<?php echo baseURL('contact-us'); ?>">Contact Us</a></li>
              <?php echo getGenericLink(); ?>
            </ul>
          </div>
        </div>
      </div>

    </div>
    <div class="row">
      <div class="col-md-12">
        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
      </div>
      <div class="col-md-12">
        Engineered by <a target='_blank' href="http://fazilamir.me">Fazil Amir</a>
      <div>
    </div>
  </div>
</footer>