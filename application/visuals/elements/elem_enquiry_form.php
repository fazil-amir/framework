<section class="ftco-intro ftco-no-pb img" style="background-image: url(<?php echo baseURL('includes/images/bg_1.jpg'); ?>);">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9 col-md-8 d-flex align-items-center heading-section heading-section-white ftco-animate">
        <h2 class="mb-3 mb-md-0">Enquiry Now</h2>
      </div>
      <div class="col-lg-3 col-md-4 ftco-animate">
        <p class="mb-0">
          <a href="#enquiry-modal" data-toggle="modal" class="btn btn-white py-3 px-4" data-live-edit-id="request:quote:headline">Enquiry Now</a>
        </p>
      </div>
    </div>	
  </div>
</section>

<div class="modal fade" id="enquiry-modal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" data-live-edit-id="request:quote:headline-2">Send Your Enquiry</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="#" class="enquiry-form" id='enquiry-form'>
          <input type="hidden" value='<?php echo $data['pageData']['title']; ?>' id='service-name'>

          <div class="form-group">
            <input required="required" minlength="3" maxlength="30" type="text" class="form-control" placeholder="Your Name" id='name'>
          </div>
          <div class="form-group">
            <input required="required" type="email" class="form-control" placeholder="Your Email" id='email'>
          </div>
          <div class="form-group">
            <input required="required" minlength="3" maxlength="12" type="number" class="form-control" placeholder="Your Phone" id='phone'>
          </div>
          <div class="form-group">
            <textarea required="required" minlength="3" maxlength="1000" id="message" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
          </div>
          <div class="form-group">
            <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
          </div>
          <div class="alert alert-success" id="success-alert">
            <strong>Success!</strong> Your message is sent!
          </div>
          <div class="alert alert-danger" id="danger-alert">
            <strong>Ops!</strong> Something went wrong. Please try again
          </div>
        </form>
      </div>

    </div>
  </div>
</div>