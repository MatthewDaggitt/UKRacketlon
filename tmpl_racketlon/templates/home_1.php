<!DOCTYPE html>
<html dir="ltr">
	<head>
		<meta charset="utf-8" />

		<?php
			$base = $document->getBase();
			if (!empty($base)) {
				echo '<base href="' . $base . '" />';
				$document->setBase('');
			}
		?>

		<?php 
			$app = JFactory::getApplication();
			$tplparams	= $app->getTemplate(true)->params;
			$close_slideshow = htmlspecialchars($tplparams->get('close_slideshow'));
			$close_text = htmlspecialchars($tplparams->get('close_text'));
			$fc = htmlspecialchars($tplparams->get('fc'));
			$tc = htmlspecialchars($tplparams->get('tc'));
			$gc = htmlspecialchars($tplparams->get('gc'));
			$pc = htmlspecialchars($tplparams->get('pc'));
			$allicon = htmlspecialchars($tplparams->get('allicon'));
			$ac = htmlspecialchars($tplparams->get('ac'));
			$close_box = htmlspecialchars($tplparams->get('close_box'));
		?>

		<link href="<?php echo $document->params->get('fav'); ?>" rel="icon" type="image/x-icon" />
		
		<script>
			var themeHasJQuery = !!window.jQuery;
		</script>

		<script src="<?php echo addThemeVersion($document->templateUrl . '/jquery.js'); ?>"></script>
		
		<script>
			window._$ = jQuery.noConflict(themeHasJQuery);
		</script>


		

		<script>
			// Script to ensure gallery text-blocks are all the same size
			var win = jQuery(window);

			var calculateGalleryTextHeight = function() 
			{
  				var width = win.width() + 15;

  				jQuery(".bd-textblock-7").css("height", "auto");
  				jQuery(".bd-textblock-10").css("height", "auto");
  				jQuery(".bd-textblock-13").css("height", "auto");
  				jQuery(".bd-textblock-16").css("height", "auto");

  				var h1 = jQuery(".bd-textblock-7").height();
  				var h2 = jQuery(".bd-textblock-10").height();
  				var h3 = jQuery(".bd-textblock-13").height();
  				var h4 = jQuery(".bd-textblock-16").height();

  				if(width < 768)
  				{
  					h1 = "auto";
  					h3 = "auto";
  				}
  				else if(width < 1199)
  				{
  					h1 = Math.max(h1, h2);
  					h3 = Math.max(h3, h4);
  				}
  				else
  				{
  					h1 = Math.max(h1, h2, h3, h4);
  					h3 = h1;
  				}
  				h2 = h1;
  				h4 = h3;

				jQuery(".bd-textblock-7").css("height", h1)
				jQuery(".bd-textblock-10").css("height", h2)
				jQuery(".bd-textblock-13").css("height", h3)
				jQuery(".bd-textblock-16").css("height", h4)
			};

			jQuery(window).resize(calculateGalleryTextHeight);
			jQuery(document).ready(calculateGalleryTextHeight);
		</script>


		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="<?php echo addThemeVersion($document->templateUrl . '/bootstrap.min.js'); ?>"></script>

		<script src="<?php echo addThemeVersion($document->templateUrl . '/CloudZoom.js'); ?>" type="text/javascript"></script>
		
		<?php echo $document->head; ?>
		<?php if ($GLOBALS['theme_settings']['is_preview'] || !file_exists($themeDir . '/css/bootstrap.min.css')) : ?>
			<link rel="stylesheet" href="<?php echo addThemeVersion($document->templateUrl . '/css/bootstrap.css'); ?>" media="screen" />
		<?php else : ?>
			<link rel="stylesheet" href="<?php echo addThemeVersion($document->templateUrl . '/css/bootstrap.min.css'); ?>" media="screen" />
		<?php endif; ?>

		<?php if ($GLOBALS['theme_settings']['is_preview'] || !file_exists($themeDir . '/css/template.min.css')) : ?>
			<link rel="stylesheet" href="<?php echo addThemeVersion($document->templateUrl . '/css/template.css'); ?>" media="screen" />
		<?php else : ?>
			<link rel="stylesheet" href="<?php echo addThemeVersion($document->templateUrl . '/css/template.min.css'); ?>" media="screen" />
		<?php endif; ?>


		<?php if(('edit' == JRequest::getVar('layout') || 'form' == JRequest::getVar('view')) ||
			('com_config' == JRequest::getVar('option') || 'config.display.modules' == JRequest::getVar('controller'))) : ?>
			<link rel="stylesheet" href="<?php echo addThemeVersion($document->templateUrl . '/css/media.css'); ?>" media="screen" />
			<script src="<?php echo addThemeVersion($document->templateUrl . '/js/template.js'); ?>"></script>
		<?php endif; ?>

		<script src="<?php echo addThemeVersion($document->templateUrl . '/script.js'); ?>"></script>
	</head>

	<style>
		.bd-layoutbox-53{ background-image: url(<?php echo $document->params->get('bg'); ?>);}
		.bd-slide-1 {background-image: url(<?php echo $document->params->get('foto2'); ?>);}
		.bd-slide-5 {background-image: url(<?php echo $document->params->get('foto1'); ?>);}
		.bd-slide-2 {background-image: url(<?php echo $document->params->get('foto3'); ?>);}
	</style>

	<body class=" bootstrap bd-body-1 bd-pagebackground">
		
		<?php include 'common_components/header.php';?>

		<?php if ($close_slideshow == 1) { ?> 
			<div class=" bd-layoutbox-1 hidden-xs clearfix">
				<div class="bd-container-inner">
					<div id="carousel-2" class=" bd-slider-2 carousel slide">
						<div class="bd-container-inner">
							<div class="bd-slides carousel-inner">
								<div class=" bd-slide-5 item">
									<div class="bd-container-inner">
										<div class="bd-container-inner-wrapper">
			   								<?php if ($close_text == 1) { ?>

			   									<div class="bd-slide">
													<div class=" bd-animation-19 animated" data-animation-name="fadeInRightBig"
														data-animation-event="slidein"
														data-animation-duration="1000ms"
														data-animation-delay="300ms"
														data-animation-infinited="false"
														data-animation-display="none">

														<div class=" bd-animation-20 animated" data-animation-name="fadeOutRightBig"
															data-animation-event="slideout"
															data-animation-duration="1000ms"
															data-animation-delay="200ms"
															data-animation-infinited="false">

															<p class=" bd-textblock-1 bd-tagstyles">
																<?php echo $document->params->get('ts1'); ?>
															</p>
														</div>
													</div>
			
													<div class=" bd-animation-8 animated" data-animation-name="fadeInLeftBig"
														data-animation-event="slidein"
														data-animation-duration="1000ms"
														data-animation-delay="400ms"
														data-animation-infinited="false"
														data-animation-display="none">

														<div class=" bd-animation-10 animated" data-animation-name="fadeOutLeftBig"
															data-animation-event="slideout"
															data-animation-duration="1000ms"
															data-animation-delay="300ms"
															data-animation-infinited="false">

															<a href="<?php echo $document->params->get('l1'); ?>" class="bd-slide-button bd-linkbutton btn-primary btn btn-slideshow">
																<span> 
																	<?php echo $document->params->get('b1'); ?> 
																</span>
															</a>
														</div>
													</div>
												</div>
											<?php } ?>
												
										</div>
									</div>
								</div>
		
								<div class="bd-slide-1 item">
									<div class="bd-container-inner">
										<div class="bd-container-inner-wrapper">
										   <?php if ($close_text == 1) { ?>

										   		<div class="bd-slide">
													<div class=" bd-animation-19 animated" data-animation-name="fadeInRightBig"
														data-animation-event="slidein"
														data-animation-duration="1000ms"
														data-animation-delay="300ms"
														data-animation-infinited="false"
														data-animation-display="none">

														<div class=" bd-animation-20 animated" data-animation-name="fadeOutRightBig"
															data-animation-event="slideout"
															data-animation-duration="1000ms"
															data-animation-delay="200ms"
															data-animation-infinited="false">

															<p class=" bd-textblock-1 bd-tagstyles">
																<?php echo $document->params->get('ts2'); ?>
															</p>
														</div>
													</div>
											
													<div class=" bd-animation-8 animated" data-animation-name="fadeInLeftBig"
														data-animation-event="slidein"
														data-animation-duration="1000ms"
														data-animation-delay="400ms"
														data-animation-infinited="false"
														data-animation-display="none">

														<div class=" bd-animation-10 animated" data-animation-name="fadeOutLeftBig"
															data-animation-event="slideout"
															data-animation-duration="1000ms"
															data-animation-delay="300ms"
															data-animation-infinited="false">

															<a href="<?php echo $document->params->get('l2'); ?>" class="bd-slide-button bd-linkbutton btn-primary btn btn-slideshow">
																<span> 
																	<?php echo $document->params->get('b2'); ?> 
																</span>
															</a>
														</div>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
												
								<div class=" bd-slide-2 item">
									<div class="bd-container-inner">
										<div class="bd-container-inner-wrapper">
										   	<?php if ($close_text == 1) { ?> 

										   		<div class="bd-slide">
													<div class=" bd-animation-19 animated" data-animation-name="fadeInRightBig"
														data-animation-event="slidein"
														data-animation-duration="1000ms"
														data-animation-delay="300ms"
														data-animation-infinited="false"
														data-animation-display="none">

														<div class=" bd-animation-20 animated" data-animation-name="fadeOutRightBig"
															data-animation-event="slideout"
															data-animation-duration="1000ms"
															data-animation-delay="200ms"
															data-animation-infinited="false">
															
															<p class=" bd-textblock-1 bd-tagstyles">
																<?php echo $document->params->get('ts3'); ?>
															</p>
														</div>
													</div>
										
													<div class=" bd-animation-8 animated" data-animation-name="fadeInLeftBig"
														data-animation-event="slidein"
														data-animation-duration="1000ms"
														data-animation-delay="400ms"
														data-animation-infinited="false"
														data-animation-display="none">

														<div class=" bd-animation-10 animated" data-animation-name="fadeOutLeftBig"
															data-animation-event="slideout"
															data-animation-duration="1000ms"
															data-animation-delay="300ms"
															data-animation-infinited="false">

															<a href="<?php echo $document->params->get('l3'); ?>" class="bd-slide-button bd-linkbutton btn-primary btn btn-slideshow">
																<span> 
																	<?php echo $document->params->get('b3'); ?> 
																</span>
															</a>
														</div>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>

							<div class="left-button">
								<a class=" bd-carousel" href="#">
									<span class=" bd-icon-18"></span>
								</a>
							</div>

							<div class="right-button">
								<a class=" bd-carousel" href="#">
									<span class=" bd-icon-18"></span>
								</a>
							</div>

						</div>

						<script>
							if ('undefined' !== typeof initSlider){
								initSlider('.bd-slider-2', 'left-button', 'right-button', '.bd-carousel', '.bd-indicators', 6100, "hover", true, true);
							}
						</script>
					</div>
				</div>
			</div>
		<?php } ?>
			
		<?php if ($close_box == 1) { ?><section class=" bd-section-3 bd-tagstyles" id="section4" data-section-title="Architecture Four Steps">
			
			<div class="bd-vertical-align-section-wrapper">
				<div class=" bd-layoutcontainer-3">
					<div class="bd-container-inner">
						<div class="container-fluid">
							<div class="row bd-row-flex bd-row-align-top">
								
								<div class="col-lg-6 col-sm-12">
									<div class="bd-layoutcolumn-9">
										<div class="bd-vertical-align-wrapper">
											<h4 class=" bd-textblock-8 bd-tagstyles">
												<font color="#428bca">
													01.
												</font>
											</h4>
								
											<h3 class=" bd-textblock-6 bd-tagstyles">
							  					<?php echo $document->params->get('title1'); ?>
											</h3>
			
											<div class=" bd-imagescaling-1 bd-imagescaling-animated" data-imagescaling-target=" bd-imagelink-6">
												<img class="bd-imagestyles bd-imagelink-6   " src="<?php echo $document->params->get('image1'); ?>">
											</div>
			
											<p class=" bd-textblock-7 bd-tagstyles">
												<?php echo $document->params->get('text1'); ?>
											</p>
											
											<a href="<?php echo $document->params->get('link1'); ?>" class="bd-slide-button bd-linkbutton btn-primary btn">
												<span> <?php echo $document->params->get('button1'); ?> </span>
											</a>
										</div>
									</div>
								</div>
			
								<div class="col-lg-6 col-sm-12">
									<div class="bd-layoutcolumn-18">
										<div class="bd-vertical-align-wrapper">
											<h4 class=" bd-textblock-8 bd-tagstyles">
												<font color="#428bca">
													02.
												</font>
											</h4>

											<h3 class=" bd-textblock-9 bd-tagstyles">
												<?php echo $document->params->get('title2'); ?>
											</h3>
				
											<div class=" bd-imagescaling-2 bd-imagescaling-animated" data-imagescaling-target=" bd-imagelink-7">
												<img class="bd-imagestyles bd-imagelink-7   " src="<?php echo $document->params->get('image2'); ?>">
											</div>
									
											<p class=" bd-textblock-10 bd-tagstyles">
									   			<?php echo $document->params->get('text2'); ?>
											</p	>
			
											<a href="<?php echo $document->params->get('link2'); ?>" class="bd-slide-button bd-linkbutton btn-primary btn">
												<span> <?php echo $document->params->get('button2'); ?> </span>
											</a>
										</div>
									</div>
								</div>
			
								<div class="col-lg-6 col-sm-12">
									<div class="bd-layoutcolumn-20">
										<div class="bd-vertical-align-wrapper">
											<h4 class=" bd-textblock-8 bd-tagstyles">
												<font color="#428bca">
													03.
												</font>
											</h4>
									
											<h3 class=" bd-textblock-12 bd-tagstyles">
												<?php echo $document->params->get('title3'); ?>
											</h3>
									
											<div class=" bd-imagescaling-3 bd-imagescaling-animated" data-imagescaling-target=" bd-imagelink-8">
												<img class="bd-imagestyles bd-imagelink-8   " src="<?php echo $document->params->get('image3'); ?>">
											</div>
									
											<p class=" bd-textblock-13 bd-tagstyles">
												<?php echo $document->params->get('text3'); ?>
											</p>
									
											<a href="<?php echo $document->params->get('link3'); ?>" class="bd-slide-button bd-linkbutton btn-primary btn">
												<span> <?php echo $document->params->get('button3'); ?> </span>
											</a>
										</div>
									</div>
								</div>
			
								<div class="col-lg-6 col-sm-12">
									<div class="bd-layoutcolumn-22">
										<div class="bd-vertical-align-wrapper">
											<h4 class=" bd-textblock-8 bd-tagstyles">
												<font color="#428bca">
													04.
												</font>
											</h4>
							
											<h3 class=" bd-textblock-15 bd-tagstyles">
												<?php echo $document->params->get('title4'); ?>
											</h3>
									
											<div class=" bd-imagescaling-4 bd-imagescaling-animated" data-imagescaling-target=" bd-imagelink-9">
												<img class="bd-imagestyles bd-imagelink-9   " src="<?php echo $document->params->get('image4'); ?>">
											</div>
									
											<p class=" bd-textblock-16 bd-tagstyles">
												<?php echo $document->params->get('text4'); ?>
											</p>
									
											<a href="<?php echo $document->params->get('link4'); ?>" class="bd-slide-button bd-linkbutton btn-primary btn">
												<span> <?php echo $document->params->get('button4'); ?> </span>
											</a>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php } ?>

		<?php include 'common_components/footer.php';?>
		

		<?php if ($ac == 1) { ?>
			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				ga('create', '<?php echo $document->params->get('analytics'); ?>', 'auto');
				ga('send', 'pageview');
			</script>
		<?php } ?>
	</body>
</html>