<?php 

function getClientData() {
  $ci = & get_instance();
  $ci -> load -> library('../../modules/block_cms/library/Block_cms');
  return $ci -> widgets -> getWidget('Clientele', 'COMMON_UI');
}

function renderOurClients() {
  $data = getClientData();
  $temp = '';
  $data = count($data) ? json_decode($data['richData'], true) : [];
  foreach($data as $d) {
    if ($d['visibility'] === 'on') {
      $temp .= '
        <div class="client-item">
          <img src="' . $d['icon']. '">
        </div>
      ';
    }
  }
  return $temp;
}

?>

<div class="container ftco-section" style="margin-top: -7em">
  <div class='row justify-content-center'>
    <div class="col-md-8 text-center heading-section ftco-animate mb-5">
      <h2 class="mb-4" data-live-edit-id="our:clients:logo:header">Our Clients</h2>
      <p data-live-edit-id="our:clients:logo:para">Separated they live in. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country</p>
    </div>
    <div class='col-sm-12'>
      <section class="our-client-slider owl-carousel">
        <?php echo renderOurClients(); ?>
      </section>
    </div>
  </div>
</div>