<?php 

function renderPageData($data) {
  $result = '';
  if(isset($data['pageData'])){
    $richData = $data['pageData']['page_data']; 
    foreach($richData as $key1 => $elements) {
      foreach($elements as $key2 => $element) {
        if ($key2 === 'USER_HTML') {
          $result .= getUserHTML($element);
        } 
        else if ($key2 === 'TEXT') {
          $result .= getTextBlock($element);
        }
      }
    }
  }
  return $result;
}


function getUserHTML($data) {
  return '<div class="container mb-5 mt-5">' . $data . '</div>';
}

function getTextBlock($cols) {
  $containerData    = '<div class="row">';
  $colData  = '';
  foreach($cols as $col) {
    foreach($col as $className => $htmlData) {
      $colData .= '
        <div class=' . $className . '>' . $htmlData . '</div>
      ';
    }
  }
  $containerData .= $colData; 
  $containerData .= '</div>';
  return '<div class="container mb-5 mt-5">' . $containerData . '</div>';
}

?>

<section class='service-page'>
  <?php echo renderPageData($data); ?>
</section>