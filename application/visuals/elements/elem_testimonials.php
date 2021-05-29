<?php 

function getTestimonialsData() {
  $ci = & get_instance();
  $ci -> load -> library('../../modules/widgets/library/Widgets');
  return $ci -> widgets -> getWidget('common testimonial', 'TESTIMONIAL');
}

function itemTemplate($data) {
  $image = $data['photo'];
  $message = $data['message'];
  $name = $data['full_name'];
  $designation = $data['designation'];
  return '
    <div class="item">
      <div class="testimony-wrap d-flex">
        <div class="user-img" style="background-image: url('. $image .')">
        </div>
        <div class="text pl-4">
          <span class="quote d-flex align-items-center justify-content-center">
            <i class="icon-quote-left"></i>
          </span>
          <p>' . $message . '</p>
          <p class="name">' . $name . '</p>
          <span class="position">' . $designation . '</span>
        </div>
      </div>
    </div>
  ';
}

function renderTestimonials() {
  $items = json_decode(getTestimonialsData()['richData'], true);
  $result = '';
  foreach($items as $item) {
    $result .= itemTemplate($item);
  }
  return $result;
}

?>
<?php if(count(getTestimonialsData()))  { ?>
  <section class="ftco-section testimony-section">
    <div class="container">
      <div class="row justify-content-center mb-5">
        <div class="col-md-8 text-center heading-section ftco-animate">
          <h2 class="mb-4" data-live-edit-id="testimonials:client:says:header">Our Clients Says</h2>
          <p data-live-edit-id="testimonials:client:says:para">Separated they live in. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country</p>
        </div>
      </div>
      <div class="row ftco-animate justify-content-center">
        <div class="col-md-12">
          <div class="carousel-testimony owl-carousel">
            <?php echo renderTestimonials(); ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php }?>