<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
  <div class="container">
  	<ul class="navbar-nav ml-auto">
		<li class="nav-item">
          <a class="nav-link" href="<?php echo baseURL('language-test/1'); ?>">Language Test - 1</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo baseURL('language-test/2'); ?>">Language Test - 2</a>
        </li>
		
		<li class="nav-item">
          <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
              <?php echo $this -> language -> getDefaultLanguage(); ?>
            <span class="caret"></span></button>
            
            <ul class="dropdown-menu">
              <?php foreach( $this -> language -> getLanguages() as $key => $language ) { ?>
                  <li><a href="<?php echo baseURL( 'change-language/' . strtolower($language) ); ?>" data-set-language="<?php echo $language; ?>" ><?php echo ucwords(strtolower($language)); ?></a></li>
              <?php } ?>
            </ul>

          </div>
        </li>

     </ul>
    </div>
</nav>

<header class="masthead text-center text-white d-flex">
  <div class="container my-auto">
	<div class="row">
	  <div class="col-lg-10 mx-auto">
		<h1 class="text-uppercase">
		  <strong data-live-edit-id="<?php echo $data['pageID']; ?>:master:header:main-text">Your Favorite Source</strong>
		</h1>
		<hr>
	  </div>
	  <div class="col-lg-8 mx-auto">
		<p class="text-faded mb-5">Start Bootstrap</p>
	  </div>
	</div>
  </div>
</header>