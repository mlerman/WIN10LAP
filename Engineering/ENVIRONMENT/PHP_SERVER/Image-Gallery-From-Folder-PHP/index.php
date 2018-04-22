<!DOCTYPE html>
<html lang="en-GB">
	<head>

		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<link href="_assets/magnifix-popup/magnific-popup.css" rel="stylesheet" type="text/css"/>
		<link href="_assets/css/main.css" rel="stylesheet" type="text/css"/>

		<title>Images Gallery</title>

  </head>
  <body>


		<section class="qt-photo-gallery">


			<?php

/* ========================================================================== */

			$qt_folder_name = 'images'; // change this to a folder of your choice for images
			$qt_handle = opendir( dirname( realpath( __FILE__ ) ) . '/' . $qt_folder_name . '/' );

/* ========================================================================== */

			$qt_counter = 0;

			while( $qt_file = readdir( $qt_handle ) ) :

				if( $qt_file !== '.' && $qt_file !== '..' ) :

					$qt_counter++;

					$qt_file_path = $qt_folder_name . '/' . $qt_file;

					?>

<!-- ======================================================================= -->

					<div class="qt-photo-gallery-item qt-image-no-<?php echo $qt_counter; ?>">
						<a class="qt-photo-gallery-item-link" href="<?php echo $qt_file_path; ?>" title="File name: <?php echo $qt_file; ?>">

							<div class="qt-photo-gallery-item-image-wrapper">

								<img src="<?php echo $qt_file_path; ?>" class="qt-photo-gallery-item-image" />

							</div>

						</a>
					</div>

<!-- ======================================================================= -->

					<?php

					if( $qt_counter == 5 ) {
						$qt_counter = 0;
					}

				endif;

			endwhile;

/* ========================================================================== */

			?>

		</section>

		<script src="_assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
		<script src="_assets/magnifix-popup/jquery.magnific-popup.min.js" type="text/javascript"></script>
		<script src="_assets/js/main.js" type="text/javascript"></script>

  </body>
</html>
