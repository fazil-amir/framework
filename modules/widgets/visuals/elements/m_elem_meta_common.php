<table width="100%" border="1" cellspacing="0" cellpadding="0" class="form-table">				

  <!-- ACCESSOR KEY -->
  <tr>
    <td class="td-label"><label for="accessor-name">Select Accessor Name:</label></td>
    <td class="input">
      <?php $accName = count($data['widgetData']) > 0 ? $data['widgetData']['accessor_name'] : ''; ?>
      <select class="form-control" id="accessor-name" name="accessor-name">
        <?php foreach($data['widgetAccessor'] as $key => $accessor){ ?>
          <option 
            <?php if ($accName === $accessor) { echo 'selected="selected"'; } ?>
            value="<?php echo $accessor; ?>">
              <?php echo str_replace('_', ' ', ucwords(strtolower($accessor))); ?>
          </option>
        <?php } ?>
      </select>
    </td>
  </tr>

  <!-- VISIBILITY  -->
  <tr>
    <td class="td-label"><label for="visibility">Visibility:</label></td>
    <td class="input">
      <label class="switch">
        <input type="checkbox" id="visibility" name="visibility"
          <?php 
            if(count($data['widgetData']) > 0) {
              if($data['widgetData']['visibility'] == 1) {
                echo 'checked="checked"';
              }
            } else {
              echo 'checked="checked"';
            }
          ?>
        >
        <div class="slider"></div>
      </label>
    </td>
  </tr>

  <!-- FEATURED  -->
  <tr>
    <td class="td-label"><label for="featured">Featured:</label></td>
    <td class="input">
      <label class="switch">
        <input type="checkbox" id="featured" name="featured"
          <?php 
          if (count($data['widgetData']) > 0) {
            if($data['widgetData']['featured'] == 1) {
              echo 'checked="checked"';
            }
          } else {
            echo 'checked="checked"';
          }
        ?>
        >
        <div class="slider"></div>
      </label>
    </td>
  </tr>

  <!-- LANGUAGE  -->
  <?php if (count($this -> language -> getLanguages()) > 1) { ?>
  <?php $selectedLang = count($data['widgetData']) > 0 ? $data['widgetData']['language'] : ''; ?>
    <tr>
      <td class="td-label"><label for="language">Languages Available</label></td>
      <td class="input">
        <select class="form-control" id="language" name="language">
          <?php foreach( $this -> language -> getLanguages() as $key => $language){ ?>
            <option 
              <?php if ($language === $selectedLang) { echo 'selected="selected"'; } ?>
              value="<?php echo $language; ?>">
              <?php echo strtolower($language); ?>
            </option>
          <?php } ?>
        </select>
      </td>
    </tr>
  <?php } ?>

</table>