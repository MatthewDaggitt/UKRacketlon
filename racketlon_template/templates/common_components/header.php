<header class=" bd-headerarea-1">
	<section class=" bd-section-1 bd-tagstyles" id="section1" data-section-title="">
		<div class="bd-vertical-align-section-wrapper">
			<div class=" bd-boxcontrol-1">
				<div class="bd-container-inner">
					<div class="bd-container-inner-wrapper">

						<form id="search-3" role="form" class=" bd-search-3 hidden-xs form-inline" name="search" <?php echo funcBuildRoute(JFactory::getDocument()->baseurl . '/index.php', 'action'); ?> method="post">
							<div class="bd-container-inner">
								<input type="hidden" name="task" value="search">
								<input type="hidden" name="option" value="com_search">

								<div class="bd-search-wrapper">
									<input type="text" name="searchword" class=" bd-bootstrapinput-9 form-control" placeholder="Search">
									<a href="#" class=" bd-icon-30" link-disable="true"></a>
								</div>

								<script>
									(function (jQuery, $) {
										jQuery('.bd-search-3 .bd-icon-30').on('click', function (e) {
											e.preventDefault();
											jQuery('#search-3').submit();
										});
									})(window._$, window._$);
								</script>
							</div>
						</form>
		
						<?php if ($allicon == 1) { ?>
							<div class=" bd-socialicons-1 hidden-xs">
								<?php if ($fc == 1) { ?>
									<a target="_blank" class=" bd-socialicon-1 bd-socialicon" href="<?php echo $document->params->get('facebook'); ?>">
									<span></span><span></span>
									</a>
								<?php } ?>
		
								<?php if ($tc == 1) { ?> 
									<a target="_blank" class=" bd-socialicon-2 bd-socialicon" href="<?php echo $document->params->get('twitter'); ?>">
									<span></span><span></span>
									</a>
								<?php } ?>
		
								<?php if ($gc == 1) { ?>
									<a target="_blank" class=" bd-socialicon-3 bd-socialicon" href="<?php echo $document->params->get('google'); ?>">
									<span></span><span></span>
									</a>
								<?php } ?>
				
								<?php if ($pc == 1) { ?>
										<a target="_blank" class=" bd-socialicon-4 bd-socialicon" href="<?php echo $document->params->get('pinterest'); ?>">
										<span></span><span></span>
										</a>
								<?php } ?>
							</div>
						<?php } ?>


						<div class="bd-animation-1">
							<?php
								$app = JFactory::getApplication();
								$themeParams = $app->getTemplate(true)->params;
								$sitename = $app->getCfg('sitename');
								$logoSrc = '';
								ob_start();
							?>

							<?php
								echo JURI::base() . 'templates/' . JFactory::getApplication()->getTemplate(); 
							?>

							/images/logo.png

							<?php
								$logoSrc = ob_get_clean();
								$logoLink = '';
								if ($themeParams->get('logoFile'))
								{
									$logoSrc = JURI::root() . $themeParams->get('logoFile');
								}
								if ($themeParams->get('logoLink'))
								{
									$logoLink = $themeParams->get('logoLink');
								}
							?>

							<a class=" bd-logo-1" href="<?php echo $logoLink; ?>">
								<img class=" bd-imagestyles" src="<?php echo $logoSrc; ?>" alt="<?php echo $sitename; ?>">
							</a>
						</div>

						<div class="bd-title">
							UK Racketlon
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php renderTemplateFromIncludes('hmenu_1', array());?>
</header>