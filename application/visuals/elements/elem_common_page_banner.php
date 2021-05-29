<?php 

  function getBannerImage($data) {
    if(isset($data['bannerData']['backgroundImg'])) {
      return $data['bannerData']['backgroundImg'];
    }
  }

  function getHeadline($data) {
    if(isset($data['bannerData']['headline'])) {
      echo '<h1 class="mb-1 bread">' . $data['bannerData']['headline'] . '</h1>';
    } 
  }
  
  function getSubHeadline($data) {
    if(isset($data['bannerData']['subHeadline'])) {
      echo '<p class="bread-2">' . $data['bannerData']['subHeadline'] . '</p>';
    } 
  }

?>

<section class="hero-wrap hero-wrap-2" style="background-image: url('<?php echo getBannerImage($data); ?>');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text align-items-center justify-content-center">
      <div class="col-md-9 ftco-animate text-center fadeInUp ftco-animated">
        <?php getHeadline($data) ?>
        <?php getSubHeadline($data) ?>
      </div>
    </div>
  </div>
</section>