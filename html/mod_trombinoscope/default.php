<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;

HTMLHelper::_('bootstrap.tooltip');

jimport('joomla.filesystem.folder');
JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');

if ($remove_whitespaces) {
	ob_start(function($buffer) { return preg_replace('/\s+/', ' ', $buffer); });
}

$contactcount = count($list);
$previous_header = '';
$header = '';

$modal_needed = false;
?>
<!--[if lte IE 8]>
	<div id="te_<?php echo $class_suffix; ?>" class="te te_<?php echo $class_suffix; ?><?php echo $arrow_class; ?><?php echo $isMobile ? ' mobile' : ''; ?> ie8">
<![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<div id="te_<?php echo $class_suffix; ?>" class="te te_<?php echo $class_suffix; ?><?php echo $arrow_class; ?><?php echo $isMobile ? ' mobile' : ''; ?>">
<!--<![endif]-->

	<?php if (trim($params->get('pretext', ''))) : ?>
		<div class="pretext">
			<?php
				if ($params->get('allow_plugins_prepost', 0)) {
					echo HtmlHelper::_('content.prepare', $params->get('pretext'));
				} else {
					echo $params->get('pretext');
				}
			?>
		</div>
	<?php endif; ?>

	<?php if (empty($cat_order) && $show_category_header) : ?>
		<div class="alert <?php echo SYWUtilities::getBootstrapProperty('alert-warning', $bootstrap_version); ?><?php echo ($bootstrap_version > 2) ? ' alert-dismissible' : '' ?>"<?php echo ($bootstrap_version > 2) ? ' role="alert"' : '' ?>>
			<button type="button" class="close" data-dismiss="alert" aria-label="<?php echo Text::_('MOD_TROMBINOSCOPE_CLOSE'); ?>"><span aria-hidden="true">&times;</span></button>
		  	<?php echo Text::_('MOD_TROMBINOSCOPE_MESSAGE_ORDERFORCATEGORYHEADER'); ?>
		</div>
	<?php endif; ?>
	<?php if ($show_arrows && ($arrow_prev_left || $arrow_prev_top)) : ?>
		<div class="items_pagination top<?php echo $extra_pagination_classes; ?>">
			<ul<?php echo $extra_pagination_ul_class_attribute; ?>>
			<?php if ($arrow_prev_left) : ?>
				<li<?php echo $extra_pagination_li_class_attribute; ?>><a id="prev_<?php echo $class_suffix; ?>" class="previous<?php echo $extra_pagination_a_classes; ?>" href="#"><i class="SYWicon-arrow-left2"></i></a></li>
			<?php endif; ?>

			<?php if ($arrow_prev_top) : ?>
				<li<?php echo $extra_pagination_li_class_attribute; ?>><a id="prev_<?php echo $class_suffix; ?>" class="previous<?php echo $extra_pagination_a_classes; ?>" href="#"><i class="SYWicon-arrow-up2"></i></a></li>
			<?php endif; ?>
			</ul>
		</div>
	<?php endif; ?>

	<div class="personlist">

		<?php foreach ($list as $i => $item) : ?>

			<?php
				// header
				if ($cat_order && $show_category_header) {
					$header = $item->category;
					if ($previous_header == $header) {
						$header = 'no_show';
					} else {
						$previous_header = $header;
					}
				}

				// Convert parameter fields to objects.
				$itemparams = new Registry();
				$itemparams->loadString($item->params);

				// name format
				$formatted_name = modTrombinoscopeHelper::getFormattedName($item->name, $format_style, $uppercase);

				// link
				$link = '';
				$link_attributes = '';
				$link_classes = '';
				if (in_array($link_access, $groups)) {
				    switch ($contact_link) {
				        case 'standard' :
				            $link = Route::_(modTrombinoscopeHelper::getContactRoute('contact', $item->slug, $item->catid));
				            break;
				        case 'popup' :
				            $link = Route::_(modTrombinoscopeHelper::getContactRoute('contact', $item->slug, $item->catid).'&tmpl=component');
				            $link_attributes = ' onclick="return false;" data-modaltitle="'.htmlspecialchars($formatted_name, ENT_COMPAT, 'UTF-8').'" data-toggle="modal" data-target="#tcpmodal_'.$module->id.'"';
				            $link_classes = 'tcpmodal_'.$module->id;
				            $modal_needed = true;
				            break;
				        case 'linka' : $link_attributes = ' target="_blank"'; case 'linka_sw' : $link = $itemparams->get('linka'); break;
				        case 'linkb' : $link_attributes = ' target="_blank"'; case 'linkb_sw' : $link = $itemparams->get('linkb');	break;
				        case 'linkc' : $link_attributes = ' target="_blank"'; case 'linkc_sw' : $link = $itemparams->get('linkc');	break;
				        case 'linkd' : $link_attributes = ' target="_blank"'; case 'linkd_sw' : $link = $itemparams->get('linkd');	break;
				        case 'linke' : $link_attributes = ' target="_blank"'; case 'linke_sw' : $link = $itemparams->get('linke');	break;
				        case 'generic' : $link_attributes = ' target="_blank"'; case 'generic_sw' : $link = $generic_link; break;
				        default: $link = '';
				    }
				}

				// category links
				$link_category = '';
				$link_category_header = '';

				if ($link_to_category) {
					$link_category = Route::_(modTrombinoscopeHelper::getCategoryRoute($item->catid));
				} else if ($link_to_view_category) {
					if (empty($cat_view_id) || $cat_view_id == 'auto') {
						$link_category = Route::_('index.php?option=com_trombinoscopeextended&view=trombinoscope&category='.$item->catid.'&referer=module');
					} else {
						$link_category = Route::_('index.php?option=com_trombinoscopeextended&view=trombinoscope&Itemid='.$cat_view_id.'&category='.$item->catid);
					}
				}

				if ($link_to_category_header) {
					$link_category_header = Route::_(modTrombinoscopeHelper::getCategoryRoute($item->catid));
				} elseif ($link_to_view_category_header) {
					if (empty($header_view_id) || $header_view_id == 'auto') {
						$link_category_header = Route::_('index.php?option=com_trombinoscopeextended&view=trombinoscope&category='.$item->catid.'&referer=module');
					} else {
						$link_category_header = Route::_('index.php?option=com_trombinoscopeextended&view=trombinoscope&Itemid='.$header_view_id.'&category='.$item->catid);
					}
				}

				$extraclasses = " personid-".$item->id." catid-".$item->catid;

				if (isset($item->tags)) {
					foreach ($item->tags as $tag) {
						$extraclasses .= " tag-".$tag->id;
					}
				}

				$extraclasses .= ($i % 2) ? " even" : " odd";

				if ($item->featured && $show_featured) {
					$extraclasses .= " featured";
				}

				if ($style_social_icons) {
					$extraclasses .= " social";
				}

				if (!$show_picture) {
					$extraclasses .= " text_only";
				} else {
					$extraclasses .= " ";
					if (!$keep_picture_space && empty($item->image) && empty($default_picture) && $globalparams->get('default_image') == null) {
						$extraclasses .= "text_only ghost_";
					}
					switch ($photo_align) {
						case 'l': $extraclasses .= "picture_left"; break;
						case 'r': $extraclasses .= "picture_right"; break;
						case 't': $extraclasses .= "picture_top"; break;
						case 'lr': $extraclasses .= ($i % 2) ? "picture_right" : "picture_left"; break;
						case 'rl': $extraclasses .= ($i % 2) ? "picture_left" : "picture_right"; break;
						default : $extraclasses .= "picture_left";
					}
				}

				if ($show_picture && $crop_picture) {
					if (empty($item->image)) {
						if (empty($default_picture)) {
							if ($globalparams->get('default_image') != null) {
								$item->image = modTrombinoscopeHelper::getCroppedImage($class_suffix, 'global', $globalparams->get('default_image'), $tmp_path, $clear_cache, $picture_width, $picture_height, $crop_picture, $quality, $filter, $create_highres_images);
							} else {
								$item->image = '';
							}
						} else {
							$item->image = modTrombinoscopeHelper::getCroppedImage($class_suffix, 'default', $default_picture, $tmp_path, $clear_cache, $picture_width, $picture_height, $crop_picture, $quality, $filter, $create_highres_images);
						}
					} else {
						$item->image = modTrombinoscopeHelper::getCroppedImage($class_suffix, $item->id, $item->image, $tmp_path, $clear_cache, $picture_width, $picture_height, $crop_picture, $quality, $filter, $create_highres_images);
					}

					if ($item->image == 'error') {
						$item->error[] = Text::_('MOD_TROMBINOSCOPE_ERROR_CREATINGTHUMBNAIL');
						$item->image = '';
					}
				}
			?>

			<?php if ($header && $header != 'no_show') : ?>
				<?php if ($i > 1) : ?>
					</div>
				<?php endif; ?>
				<div class="groupheader">
					<?php if ($show_category_header) : ?>
						<?php echo '<h'.$header_html_tag.' class="header">'; ?>
							<?php if ($link_category_header) : ?>
								<a href="<?php echo $link_category_header; ?>">
									<span><?php echo $header ?></span>
								</a>
							<?php else : ?>
								<span><?php echo $header ?></span>
							<?php endif; ?>
						<?php echo '</h'.$header_html_tag.'>'; ?>
					<?php endif; ?>
				</div>
				<div class="contactgroup">
			<?php endif; ?>

			<div class="person<?php echo $extraclasses ?>">
				<div class="shell">
    				<div class="outerperson">

    					<?php if ($show_errors && !empty($item->error)) : ?>
    						<div class="alert <?php echo SYWUtilities::getBootstrapProperty('alert-error', $bootstrap_version); ?><?php echo ($bootstrap_version > 2) ? ' alert-dismissible' : '' ?>"<?php echo ($bootstrap_version > 2) ? ' role="alert"' : '' ?>>
                    			<button type="button" class="close" data-dismiss="alert" aria-label="<?php echo Text::_('MOD_TROMBINOSCOPE_CLOSE'); ?>"><span aria-hidden="true">&times;</span></button>
                    			<ul>
                    			<?php foreach ($item->error as $error) : ?>
                    		  		<li><?php echo $error; ?></li>
    							<?php endforeach; ?>
    							</ul>
                    		</div>
    					<?php endif; ?>

    					<?php if ($requested_links) : ?>
    						<?php $links_output = ''; ?>
    						<?php foreach ($requested_links as $index => $requested_link) : ?>
    							<?php $links_output .= modTrombinoscopeHelper::renderLink($params, $item, $index, $requested_link, $extraclasseslinkfields); ?>
    						<?php endforeach; ?>
    						<?php if ($links_output) : ?>
        						<div class="iconlinks">
        							<ul><?php echo $links_output; ?></ul>
        						</div>
    						<?php endif; ?>
    					<?php endif; ?>

    					<?php if ($show_vcard) : ?>
    						<div class="vcard">
    							<a href="<?php echo Route::_('index.php?option=com_contact&view=contact&id='.$item->id.'&format=vcf'); ?>" class="hasTooltip<?php echo $extraclasseslinkfields ? ' ' . $extraclasseslinkfields : ''; ?>" aria-label="<?php echo Text::_('MOD_TROMBINOSCOPE_VCARD');?>" title="<?php echo Text::_('MOD_TROMBINOSCOPE_DOWNLOAD_VCARD');?>">
    								<i class="icon SYWicon-vcard" aria-hidden="true"></i><span><?php echo Text::_('MOD_TROMBINOSCOPE_VCARD'); ?></span>
    							</a>
    						</div>
    					<?php endif; ?>

    					<div class="innerperson">
    						<div class="personpicture">

    							<?php if (isset($item->individual_bg) && !empty($item->individual_bg)) : ?>
    								<div class="individualbg">
    									<div class="innerindividualbg">
    										<?php echo HtmlHelper::_('image', $item->individual_bg, null); ?>
    									</div>
    								</div>
    							<?php endif; ?>

    							<div class="picture<?php echo ($picture_hover_type != 'none' && $link_picture && $link) ? ' '.$picture_hover_type : ''; ?>">
    								<div class="picture_veil">
    									<?php if ($item->featured && $show_featured) : ?>
    										<div class="feature">
    											<i class="icon SYWicon-<?php echo $featured_icon; ?>" aria-hidden="true"></i>
    										</div>
    									<?php endif; ?>
    								</div>
    								<?php if ($link_picture && $link) : ?>
    									<a href="<?php echo $link; ?>"<?php echo $link_attributes; ?><?php echo modTrombinoscopeHelper::getTitleAttribute($formatted_name, $picture_tooltip) ?><?php echo modTrombinoscopeHelper::getClassAttribute($picture_tooltip, $link_classes); ?>>
    								<?php endif; ?>
    								<?php if (!empty($item->image)) : ?>
    									<?php if ($create_highres_images) : ?>
    										<?php echo HtmlHelper::_('image', $item->image, $formatted_name, array('class' => 'lazyload', 'srcset' => 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==', 'data-srcset' => Uri::base(true).'/'.$item->image.' 1x, '.str_replace('.', '@2x.', Uri::base(true).'/'.$item->image).' 2x')); ?>
    									<?php else : ?>
    										<?php echo HtmlHelper::_('image', $item->image, $formatted_name); ?>
    									<?php endif; ?>
    								<?php elseif (!empty($default_picture)) : ?>
    									<?php echo HtmlHelper::_('image', $default_picture, $formatted_name); ?>
    								<?php elseif ($globalparams->get('default_image') != null) : ?>
    									<?php echo HtmlHelper::_('image', $globalparams->get('default_image'), $formatted_name); ?>
    								<?php else : ?>
    									<span class="nopicture">&nbsp;</span>
    								<?php endif; ?>
    								<?php if ($link_picture && $link) : ?>
    									</a>
    								<?php endif; ?>
    							</div>
    						</div>

    						<div class="personinfo">
    							<div class="text_veil">
    								<?php if ($item->featured && $show_featured) : ?>
    									<div class="feature">
    										<i class="icon SYWicon-<?php echo $featured_icon; ?>" aria-hidden="true"></i>
    									</div>
    								<?php endif; ?>
    							</div>

    							<?php if ($show_category) : ?>
    								<div class="category">
    									<?php if ($link_category) : ?>
    										<a href="<?php echo $link_category; ?>" class="hasTooltip" title="<?php echo Text::_('JCATEGORY'); ?>">
    											<span><?php echo $item->category; ?></span>
    										</a>
    									<?php else : ?>
    										<span><?php echo $item->category; ?></span>
    									<?php endif; ?>
    								</div>
    							<?php endif; ?>

    							<?php if ($show_tags) : ?>
    								<?php if (isset($item->tags)) : ?>
    									<div class="tags">
    										<?php $layout = new FileLayout('tcptag', JPATH_ROOT.'/modules/mod_trombinoscope/layouts'); // no overrides possible ?>
    										<?php foreach ($item->tags as $tag) :  ?>
    											<?php
    												$data = array('tag' => $tag);
    												if ($link_to_tags) {
    													$data['link'] = Route::_(TagsHelperRoute::getTagRoute($tag->id . ':' . $tag->alias));
    												} elseif ($link_to_view_tags && !empty($tags_view_id)) {
    													$data['link'] = Route::_('index.php?option=com_trombinoscopeextended&view=trombinoscope&Itemid='.$tags_view_id.'&tag='.$tag->id);
    												}
    												$data['bootstrap_version'] = $bootstrap_version;
    												$data['load_bootstrap'] = $load_bootstrap;

    												echo $layout->render($data);
    											?>
    										<?php endforeach; ?>
    									</div>
    								<?php endif; ?>
    							<?php endif; ?>

    							<?php
        							$title_attribute = modTrombinoscopeHelper::getTitleAttribute($name_label, $name_tooltip);
        							if (empty($link_label) && $link) {
        							    $name_value = '<a href="'.$link.'"'.$link_attributes.$title_attribute.modTrombinoscopeHelper::getClassAttribute($name_tooltip, $link_classes.' fieldvalue').' aria-label="'.$name_label.'"><span>'.$formatted_name.'</span></a>';
        							} else {
        							    $name_value = '<span class="fieldvalue'.modTrombinoscopeHelper::getTooltipClass($name_tooltip).'" aria-label="'.$name_label.'"'.$title_attribute.'>'.$formatted_name.'</span>';
        							}
    							?>
    							<?php echo modTrombinoscopeHelper::renderName($params, $name_value, $extraclassesfields); ?>

    							<?php if ($requested_infos) : ?>
        							<?php foreach ($requested_infos as $index => $requested_info) : ?>
        								<?php echo modTrombinoscopeHelper::renderInfo($params, $item, $index, $requested_info, $extraclassesfields); ?>
        							<?php endforeach; ?>
        						<?php endif; ?>

    							<?php if ($link_label && $link) : ?>
    								<div class="personlinks">
    									<div class="personlink go">
    										<a href="<?php echo $link; ?>" title="<?php echo $formatted_name; ?>"<?php echo $link_attributes; ?><?php echo modTrombinoscopeHelper::getClassAttribute(true, $link_classes); ?>>
    											<?php if ($doc->getDirection() == 'rtl') : ?>
    												<i class="icon SYWicon-arrow-left" aria-hidden="true"></i><span><?php echo $link_label; ?></span>
    											<?php else : ?>
    												<i class="icon SYWicon-arrow-right" aria-hidden="true"></i><span><?php echo $link_label; ?></span>
    											<?php endif; ?>
    										</a>
    									</div>
        							</div>
    							<?php endif; ?>
    						</div>
						</div>
					</div>
				</div>
			</div>

			<?php if ($i == $contactcount && $header) : ?>
				</div>
			<?php endif; ?>

		<?php endforeach; ?>
	</div>

	<?php if ($show_arrows && ($arrow_prevnext_bottom || $arrow_next_right || $arrow_next_bottom)) : ?>
		<div class="items_pagination bottom<?php echo $extra_pagination_classes; ?>">
			<ul<?php echo $extra_pagination_ul_class_attribute; ?>>
			<?php if ($arrow_prevnext_bottom) : ?>
				<li<?php echo $extra_pagination_li_class_attribute; ?>><a id="prev_<?php echo $class_suffix; ?>" class="previous<?php echo $extra_pagination_a_classes; ?>" href="#"><i class="SYWicon-arrow-left2"></i></a></li><!--
				 --><?php if ($show_pages && $arrow_prevnext_bottom) : ?><div id="pager_<?php echo $class_suffix; ?>" class="pagenumbers"></div><?php endif; ?><!--
				 --><li<?php echo $extra_pagination_li_class_attribute; ?>><a id="next_<?php echo $class_suffix; ?>" class="next<?php echo $extra_pagination_a_classes; ?>" href="#"><i class="SYWicon-arrow-right2"></i></a></li>
			<?php endif; ?>

			<?php if ($arrow_next_right) : ?>
				<li<?php echo $extra_pagination_li_class_attribute; ?>><a id="next_<?php echo $class_suffix; ?>" class="next<?php echo $extra_pagination_a_classes; ?>" href="#"><i class="SYWicon-arrow-right2"></i></a></li>
			<?php endif; ?>

			<?php if ($arrow_next_bottom) : ?>
				<li<?php echo $extra_pagination_li_class_attribute; ?>><a id="next_<?php echo $class_suffix; ?>" class="next<?php echo $extra_pagination_a_classes; ?>" href="#"><i class="SYWicon-arrow-down2"></i></a></li>
			<?php endif; ?>
			</ul>
		</div>
	<?php endif; ?>

	<?php if ($module_link) : ?>
		<div class="module_link">
			<a href="<?php echo $module_link; ?>" class="hasTooltip<?php echo empty($module_link_class) ? '' : ' '.$module_link_class; ?>" title="<?php echo $module_link_label ?>"<?php echo $module_link_isExternal ? ' target="_blank"' : ''; ?>><span><?php echo $module_link_label ?></span></a>
		</div>
	<?php endif; ?>
	<?php if (trim($params->get('posttext', ''))) : ?>
		<div class="posttext">
			<?php
				if ($params->get('allow_plugins_prepost', 0)) {
					echo HtmlHelper::_('content.prepare', $params->get('posttext'));
				} else {
					echo $params->get('posttext');
				}
			?>
		</div>
	<?php endif; ?>
</div>

<?php
    if ($modal_needed) {
		$layout = new FileLayout('tcpmodal', JPATH_ROOT.'/modules/mod_trombinoscope/layouts'); // no overrides possible

        $data = array('selector' => 'tcpmodal_'.$module->id, 'width' => $popup_x, 'height' => $popup_y);
        $data['bootstrap_version'] = $bootstrap_version;
        $data['load_bootstrap'] = $load_bootstrap;

        echo $layout->render($data);
    }
?>

<?php if ($remove_whitespaces) : ?>
	<?php ob_get_flush(); ?>
<?php endif; ?>