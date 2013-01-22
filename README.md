kohana-resizer
==============

Image resize &amp; crop module for Kohana Framework. This module can be configured to use an image cache to prevent constant image regeneration.
It was tested with JPEG and PNG images.


Usage sample
------------
Syntax is: resizer/<type>/<width>/<height>/<file>

Where <type> could be c (crop) or r (resise)

<img src="<?php echo Kohana::$base_url; ?>resizer/c/150/150/images/sample.jpg" />

This would return a 150x150 px cropped JPEG.
