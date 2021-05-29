<?php

$footerLinks = '';

function renderNavigation() {
  $pages = getPageLinks('PRODUCT_PAGE');
  $single = '';
  $multiple = '';
  foreach($pages as $page) {
    if (count($page['pages']) > 1) {
      $multiple .= getDropdown($page['cat_name'], URLTitle($page['cat_name']), $page['pages']);
    } else {
      $link = $page['pages'][0]['seo_uri'];
      $caption = $page['pages'][0]['caption'];
      $single .= getNavItem($link, $caption, URLTitle($page['cat_name']), false);
    }
  }
  return $single . $multiple;
}

function getNavItem($link, $caption, $catURI, $isDropdownItem = true) {
  $active = '';
  $itemClass = $isDropdownItem ? 'dropdown-item' : 'nav-item';
  $anchorClass = !$isDropdownItem ? 'nav-link': '';
  return '
    <li
      class="' . $itemClass . ' ' . $active . '"
    >
        <a
          href="' . getHref($link, $catURI) . '"
          class="' . $anchorClass . '"
        >'
          . titleCase($caption) .
        '</a>
    </li>
  ';
}

function getDropdown($catName, $catURI, $pages) {
  return '
    <li class="nav-item dropdown">
      <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">' . titleCase($catName) . '<b class="caret"></b></a>
      <ul class="dropdown-menu">
        '.
          getLinks($pages, $catURI)
        .'
      </ul>
    </li>
  ';
}

function getLinks($links, $catURI) {
  $result = '';
  foreach($links as $page) {
    $result .= getNavItem($page['seo_uri'], $page['caption'], $catURI);
  }
  return $result;
}

function getPageLinks($accessorName = null) {
  $ci = & get_instance();
  $ci -> load -> library('../../modules/block_cms/library/Block_cms');
  return $ci -> block_cms -> getNavigation($accessorName);
}

function titleCase($str) {
  return ucwords(strtolower($str));
}

function getHref($link, $catURI = '', $key = 'service/') {
  if ($catURI) {
    return baseURL($key . $catURI . '/' . $link);
  }
  return baseURL($key . $link);
}

?>

<div class="bg-top navbar-light">
  <div class="container">
    <div class="row no-gutters d-flex align-items-center align-items-stretch">
      <div class="col-md-6 d-flex align-items-center">
        <a class="navbar-brand" href="<?php echo baseURL(); ?>">
          <img src="<?php echo baseURL('includes/images/logo.png'); ?>" contextmenu="share"/>
        </a>
      </div>
      <div class="col-lg-6 d-block">
        <div class="row d-flex">
          <div class="col-md d-flex topper align-items-center align-items-stretch py-md-4">
            <div class="icon d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
            <div class="text">
              <span data-live-edit-id='navigation:email:address:title'>Email</span>
              <span data-live-edit-id='navigation:contact:email'>info@superfmuae.com</span>
            </div>
          </div>
          <div class="col-md d-flex topper align-items-center align-items-stretch py-md-4">
            <div class="icon d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
            <div class="text">
              <span data-live-edit-id='navigation:phone:number:title'>Phone</span>
              <span data-live-edit-id='navigation:contact:phone'>Call Us: +971 2 55 66 55 3</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar">
  <div class="container d-flex align-items-center">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="oi oi-menu"></span> Menu
    </button>
    <a class="navbar-brand" href="index.html">
      <img src="<?php echo baseURL('includes/images/logo.png'); ?>" />
    </a>
    <div class="collapse navbar-collapse" id="ftco-nav">
      <ul class="navbar-nav">
        <?php echo renderNavigation(); ?>
      </ul>
    </div>
  </div>
</nav>