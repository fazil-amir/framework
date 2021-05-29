<?php 
function getHomepageSliderData() {
  $ci = & get_instance();
  $ci -> load -> library('../../modules/widgets/library/Widgets');
  return $ci -> widgets -> getWidget('home page slider', 'IMAGE_SLIDER');
}
$slider = $slider = getHomepageSliderData()
?>

<?php if(count($slider)) { ?>
  <section class="home-slider owl-carousel">
    <?php foreach(json_decode($slider['richData'], true) as $slide) { ?>
      <div class="slider-item" style="background-image:url(<?php echo $slide['slide_image']?>);">
        <div class="overlay"></div>
        <div class="container">
          <div class="row no-gutters slider-text align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate">
            <?php 
              if($slide['headline'] !== '') {
                echo '<h1>' . $slide['headline'] . '</h1>';
              }
              if($slide['caption'] !== '') {
                echo '<span class="subheading">' . $slide['caption'] .'</span>';
              }
              if($slide['btn_link'] !== '') {
                $caption = $slide['btn_caption'] ? $slide['btn_caption'] : 'Read More';
                $linkLarget = $slide['target'] === 'new' ? 'target="_blank"' : '';
                echo '<p><a ' . $linkLarget . ' href="' . $slide['btn_link'] . ' " class="btn btn-primary px-4 py-3 mt-3/">' . $caption . '</a></p>';
              }
            ?>
          </div>
        </div>
        </div>
      </div>
    <?php } ?>
  </section>
<?php } ?>