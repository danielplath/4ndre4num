<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');
HTMLHelper::_('behavior.caption');
?>
<div class="category-list<?php echo $this->pageclass_sfx; ?>">

<?php
$this->subtemplatename = 'articles';
use Joomla\CMS\Layout\LayoutHelper;
echo LayoutHelper::render('joomla.content.category_default', $this);
?>

</div>
