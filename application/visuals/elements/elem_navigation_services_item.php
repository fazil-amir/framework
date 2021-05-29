<?php 

function getNavItem() {
  $result = '';
  foreach($data['navigationLinks'] as $page) {
    $result += _getDropdown($page['cat_name'], $page['pages']);
  }
}

function _getNavItem($link, $caption, $isDropdownItem = false) {
  $active = '';
  $itemClass = $isDropdownItem ? 'dropdown-item' : 'nav-item';
  return '
    <li 
      class="' . $itemClass . ' ' . $active . '"
    >
        <a 
          href="' . $link . '" 
          class="nav-link"
        >'
          . $caption . 
        '</a>
    </li>
  ';
}

function _getDropdown($catName, $pages) {
  return '
    <li class="nav-item dropdown">
      <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">' . $catName . '<b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li class="dropdown-item"><a href="#">Another action</a></li>
        <li class="dropdown-item"><a href="#">Something else here</a></li>
        <li class="dropdown-item"><a href="#">Separated link</a></li>
        <li class="dropdown-item"><a href="#">One more separated link</a></li>
      </ul>
    </li>
  ';
}

function _getLinks($links) {
  foreach($links as $link) {
    
  }
} 

?>

<div class="collapse navbar-collapse" id="ftco-nav">
  <ul class="navbar-nav">
    <?php echo getNavItem(); ?>
    <!-- <li class="nav-item active"><a href="index.html" class="nav-link">Home</a></li>
    <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
    <li class="nav-item"><a href="project.html" class="nav-link">Projects</a></li>
    <li class="nav-item"><a href="services.html" class="nav-link">Services</a></li>
    <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
    
    <li class="nav-item dropdown">
      <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">Category Name<b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li class='dropdown-item'><a href="#">Another action</a></li>
        <li class='dropdown-item'><a href="#">Something else here</a></li>
        <li class='dropdown-item'><a href="#">Separated link</a></li>
        <li class='dropdown-item'><a href="#">One more separated link</a></li>
      </ul>
    </li> -->

  </ul>
</div>