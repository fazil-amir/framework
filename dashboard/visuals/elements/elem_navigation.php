<?php include 'modules/routes.php'; ?>
<nav class="nav">
	<ul>
		<?php
			foreach ($panel['modules'] as $key => $moduleName) {
				// echo '<pre>';
				// print_r($moduleName);
				// if(!in_array($key, $panel['load']) ) {
				// 	continue;
				// }
				$moduleName = is_array($moduleName) ? $key : $moduleName;
				if(isset($panel['modules'][$key]['subMenuCaption'])) {
					echo '<li class="sub-menu"><a href="#" id="' . $panel['modules'][$key]['id'] . '">' . $panel['modules'][$key]['menuCaption'] . '</a>';
						echo '<ul>';
						foreach ($panel['modules'][$key]['subMenuCaption'] as $subMenuKey => $subMenuValue) {
							echo '<li><a href="' . baseURL($subMenuValue) . '">' .  $subMenuKey . '</a></li>';
						}
						echo '</ul>';
					echo '</li>';
				} else if (isset($panel['modules'][$key]['menuCaption'])){
					echo '<li><a href="' . baseURL(array_keys($panel['modules'][$key]['routes'])) . '" id="' . $panel['modules'][$key]['id'] . '">' . $panel['modules'][$key]['menuCaption'] . '</a>';
				}
			}
		?>
	</ul>
</nav>
