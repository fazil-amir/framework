<?php include('maps/panel.php'); ?>

<header class="header">
  <div class="logo">
    <a href="<?php echo baseURL('panel/'); ?>">
      <img height="50" src="<?php echo baseURL('dashboard-assets/images/default_logo.png'); ?>">
    </a>
  </div>
  <nav class="header-nav">
    <ul>
      <li><a class="btn btn-primary btn-md" href="<?php echo baseURL() ?>" target="_blank" id="goto-to-website" >Go To Website</a></li>
      <?php if(in_array('LIVE_EDIT', $panel['load'])) { ?>
        <li><button id="toggle-live-edit" class="btn btn-primary btn-md">Enable Live Edit</button></li>
      <?php } ?>
      <li class='divider'></li>
      <li><a class="btn btn-danger btn-md" href="<?php echo baseURL('panel/user-auth/logout'); ?>">Logout</a></li>
    </ul>
  </nav>
</header>