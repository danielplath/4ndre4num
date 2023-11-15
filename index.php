<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;

HTMLHelper::_('stylesheet', 'template.css', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('stylesheet', 'panorama_viewer.css', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('script', 'imagesloaded.pkgd.min.js', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('script', 'detect-it.umd.production.js', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('script', 'template.js', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('script', 'jquery.panorama_viewer.js', array('version' => 'auto', 'relative' => true));

$doc = Factory::getDocument();
$doc->addScript('/templates/' . $this->template . '/script/detect-it.umd.production.js', 'text/javascript');
$doc->addScript('/templates/' . $this->template . '/script/imagesloaded.pkgd.min.js', 'text/javascript');
$doc->addScript('/templates/' . $this->template . '/script/template.js', 'text/javascript');
$doc->addScript('/templates/' . $this->template . '/script/jquery.panorama_viewer.js', 'text/javascript');
?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://use.typekit.net/yai0bkg.css">
        <jdoc:include type="head" />
    </head>
	<body>
		<header>
			<div class="blue-overlay"></div>
			<div class="image-wrapper">
				<div class="grid max-width logo-wrapper">
					<a href="index.php" class="logo">
						<img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/andreanum-logo.svg" />
					</a>
					<div class="subnavigation">
						<jdoc:include type="modules" name="submenu" style="xhtml"/>
					</div>
				</div>
				<div class="image-slider 1" id="1" style="background-image: url('/templates/andreanum/images/blueoverlay-min920px.svg'), url('https://www.andreanum.de/images/headers/intro-pic-01.jpg'); display: block;"></div>
			</div>

			<!-- Einbindung des Navigationsmoduls "menu" -->
			<div class="bigScreenMenu">
				<jdoc:include type="modules" name="menu" style="xhtml" class="bigScreenMenu"/>
			</div>

			<div class="mobileMenu">
				<label>Menü</label>
				<div class="mobileMenuWrapper">
					<div class="shortcutButtons">
						<jdoc:include type="modules" name="shortcutbtn" style="xhtml" />
					</div>
					<jdoc:include type="modules" name="menu" style="xhtml" />
					<div class="subnavigation">
						<jdoc:include type="modules" name="submenu" style="xhtml"/>
					</div>
				</div>
			</div>

		</header>

		<div class="container">
			<div class="content-wrapper grid max-width margin-auto">
				<div class="sidebar">
					<span>
						<jdoc:include type="modules" name="aside" style="xhtml"/>
					</span>
				</div>

				<main role="main">
					<!-- Einbindung Breadcrumbs -->
					<div class="breadcrumbs">
						<jdoc:include type="modules" name="breadcrumbs" style="xhtml"/>
					</div>
					<!-- Einbindung Inhalt -->
					<jdoc:include type="modules" name="intro" style="xhtml"/>


					<jdoc:include type="component" />
				</main>
			</div>




		</div>
		<div class="partnerlogo-wrapper">
			<div class="partnergrid max-width">
				<div class="sponsor">
					<label>Schulträger:</label>
					<div>
						<a href="https://www.schulwerk-hannover.de" target="_blank"><img class="schulwerk" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/partner/evangelisches-schulwerk.svg" /></a>
					</div>
				</div>
				<div class="partner">
					<label>Partner des Andreanum:</label>
					<div>
						<a href="/index.php/dies-sind-wir/freundeskreis"><img class="freundeskreis" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/partner/Andreanum-Freundeskreis.svg" /></a>
						<a href="https://www.kk-hs.de" target="_blank"><img class="kkhs" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/partner/Kirchenkreis-Hildesheim-Sarstedt.svg" /></a>
						<a href="http://www.nampu.de" target="_blank"><img class="nampu" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/partner/Nampu.svg" /></a>
						<a href="https://oekofair-hildesheim.de" target="_blank"><img class="oekofair" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/partner/Netzwerkgruppe-Oeko-Fair.svg" /></a>
						<a href="https://www.eihi.de" target="_blank"><img class="eintracht" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/partner/Eintracht.svg" /></a>
                        <a href="https://www.schulstiftung-ekd.de/" target="_blank"><img class="ekd" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/partner/ESS_Logo.jpg" /></a>
					</div>
				</div>
			</div>
		</div>
		<footer role="contentinfo" aria-label="CopyrightInformation">
			<div class="nav-wrapper max-width">
				<jdoc:include type="modules" name="menu" style="xhtml" class="grid" />
				<div class="sub-wrapper">
					<div class="subnavigation">
						<jdoc:include type="modules" name="submenu" style="xhtml"/>
					</div>
					<div class="legalnavigation">
						<!-- <jdoc:include type="modules" name="legalmenu" style="xhtml"/> -->
					</div>
				</div>
			</div>
		</footer>
		<!-- Einbindung Cookiebanner -->
		<jdoc:include type="modules" name="cookieconsent" style="xhtml"/>
		<jdoc:include type="modules" name="debug" />

		<!-- Einbindung der Slidergrafiken -->
		<div class="hidden-helper-container">
			<?php
				$dirname = "./images/headers/";
				$images = glob($dirname."*.jpg");
				$counter = 1;

				foreach($images as $image) {
					if($counter != 1){
						$imagepath = substr($image, 2);
						echo '<div class="image-slider '.$counter.'" id="'.$counter.'" style="background-image: url(/templates/andreanum/images/blueoverlay-min920px.svg),url(https://www.andreanum.de/'.$imagepath.');"></div>';
					}

					$counter++;
				} ?>
		</div>

		<!-- Menuwidget -->
		<jdoc:include type="modules" name="menu-widget" style="xhtml"/>
	</body>
</html>
