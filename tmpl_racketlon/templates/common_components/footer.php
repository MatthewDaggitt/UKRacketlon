
<footer class=" bd-footerarea-1">
	<section class="bd-section-4 bd-tagstyles" id="section3" data-section-title="Simple Footer BG Image Dark">
		<div class="bd-vertical-align-section-wrapper">
			<div class=" bd-layoutbox-2 clearfix">
				<div id="bd-footer-container" class="bd-container-inner">

					<div id="bd-footer-icons" class="bd-layoutbox-9 clearfix">
						<div class="bd-container-inner">
							<?php if ($allicon == 1) { ?>
								<div class=" bd-socialicons-2">
									<a target="_blank" class="bd-round-icon bd-footer-icon bd-login-icon">
										<span></span>
									</a>
									<?php if ($fc == 1) { ?>
										<a target="_blank" class="bd-round-icon bd-footer-icon bd-socialicon-5" href="<?php echo $document->params->get('facebook');?>">
											<span></span>
										</a>
									<?php } ?>
							
									<?php if ($tc == 1) { ?>
										<a target="_blank" class="bd-round-icon bd-footer-icon bd-socialicon-6" href="<?php echo $document->params->get('twitter'); ?>">
											<span></span>
										</a>
									<?php } ?>
							
									<?php if ($gc == 1) { ?>
										<a target="_blank" class="bd-round-icon bd-footer-icon bd-socialicon-7" href="<?php echo $document->params->get('google'); ?>">
											<span></span>
										</a>
									<?php } ?>
							
									<?php if ($pc == 1) { ?>
										<a target="_blank" class="bd-round-icon bd-footer-icon bd-socialicon-8" href="<?php echo $document->params->get('pinterest'); ?>">
											<span></span>
										</a>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>

					<div id="bd-footer-copyright" class=" bd-layoutbox-4 clearfix">
						<div class="bd-container-inner">
							<p class=" bd-textblock-2 bd-tagstyles">
								Copyright © <?php echo date("Y");?>, <?php echo $document->params->get('footer1'); ?>
							</p>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
</footer>

<script>
	var name = ".bd-sidebararea-3-column";
	jQuery(name).toggle();

	// Script to make login box appear
	jQuery(".bd-login-icon").click(function(e)
	{
		jQuery(name).toggle("slow");
		jQuery(window).scrollTop(0);
	});
</script>