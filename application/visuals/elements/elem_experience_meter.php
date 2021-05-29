<?php 

function getSkillMeterData() {
  $ci = & get_instance();
  $ci -> load -> library('../../modules/block_cms/library/Block_cms');
  return $ci -> widgets -> getWidget('Skill Meter', 'COMMON_UI');
}

function renderSkillMeter() {
  $data = getSkillMeterData();
  $temp = '';
  $data = count($data) ? json_decode($data['richData'], true) : [];
  foreach($data as $d) {
    if ($d['visibility'] === 'on') {
      $temp .= '
        <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
          <div class="block-18">
            <div class="icon"><span class="flaticon-doctor"></span></div>
            <div class="text">
              <strong class="number" data-number="' . $d['message'] . '"></strong>
              <span>' . $d['headline'] . '</span>
            </div>
          </div>
        </div>
      ';
    }
  }
  return $temp;
}

?>
<section class="ftco-intro ftco-no-pb img" style="background-image: url(<?php echo baseURL('includes/images/bg_3.jpg'); ?>);">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-md-10 text-center heading-section heading-section-white ftco-animate">
        <h2 class="mb-0" data-live-edit-id="our:experience:meter:headline">You Always Get the Best Guidance</h2>
      </div>
    </div>	
  </div>
</section>
<section class="ftco-counter" id="section-counter">
  <div class="container">
    <div class="row d-md-flex align-items-center justify-content-center">
      <div class="wrapper">
        <div class="row d-md-flex align-items-center">
          
          <?php echo renderSkillMeter(); ?>

        </div>
      </div>
    </div>
  </div>
</section>