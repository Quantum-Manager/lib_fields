<?php
defined('_JEXEC') or die;

// Initialise related data.
JLoader::register('MenusHelper', JPATH_ADMINISTRATOR . '/components/com_menus/helpers/menus.php');
$menuTypes = MenusHelper::getMenuLinks();

JHtml::_('script', 'jui/treeselectmenu.jquery.min.js', array('version' => 'auto', 'relative' => true));

extract($displayData);

if(!is_array($value))
{
	$value = [];
}

?>
<div class="control-group">
	<div class="selectmenuitem" class="controls">
		<?php if (!empty($menuTypes)) : ?>
			<?php $id = 'jform_menuselect'; ?>

				<div class="form-inline">
                    <span class="small"><?php echo JText::_('JSELECT'); ?>:
                        <a class="checkAll" href="javascript://"><?php echo JText::_('JALL'); ?></a>,
                        <a class="uncheckAll" href="javascript://"><?php echo JText::_('JNONE'); ?></a>
                    </span>
                        <span class="width-20">|</span>
                        <span class="small"><?php echo JText::_('COM_MODULES_EXPAND'); ?>:
                        <a class="expandAll" href="javascript://"><?php echo JText::_('JALL'); ?></a>,
                        <a class="collapseAll" href="javascript://"><?php echo JText::_('JNONE'); ?></a>
                    </span>
				</div>

				<ul>
					<?php foreach ($menuTypes as &$type) : ?>
						<?php if (count($type->links)) : ?>
							<?php $prevlevel = 0; ?>
							<li>
                                <div class="selectmenuitem-label-wrap">
                                    <div class="selectmenuitem-carret"><span class="icon-plus large-icon"></span></div>
                                    <div class="selectmenuitem-label">
                                        <div class="selectmenuitem-heading"><?php echo $type->title; ?></div>
                                    </div>
                                </div>

							    <?php foreach ($type->links as $i => $link) : ?>
								<?php
								if ($prevlevel < $link->level)
								{
									echo '<ul class="hide">';
								} elseif ($prevlevel > $link->level)
								{
									echo str_repeat('</li></ul>', $prevlevel - $link->level);
								} else {
									echo '</li>';
								}

								// переписать выборку
								$selected = 0;
								if(in_array($link->value, $value))
								{
									$selected = 1;
								}

								?>
								<li>
                                    <div class="selectmenuitem-label-wrap">
                                        <div class="selectmenuitem-carret"><span class="icon-plus large-icon"></span></div>
                                        <div class="selectmenuitem-label">
		                                    <?php
		                                    $uselessMenuItem = in_array($link->type, array('separator', 'heading', 'alias', 'url'));
		                                    ?>
                                            <input type="checkbox" class="pull-left novalidate" name="<?php echo $name; ?>[]" id="<?php echo $id . $link->value; ?>" value="<?php echo (int) $link->value; ?>"<?php echo $selected ? ' checked="checked"' : ''; echo $uselessMenuItem ? ' disabled="disabled"' : ''; ?> />
                                            <label for="<?php echo $id . $link->value; ?>" class="pull-left">
			                                    <?php echo $link->text; ?> <span class="small"><?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($link->alias)); ?></span>
			                                    <?php if (JLanguageMultilang::isEnabled() && $link->language != '' && $link->language != '*') : ?>
				                                    <?php if ($link->language_image) : ?>
					                                    <?php echo JHtml::_('image', 'mod_languages/' . $link->language_image . '.gif', $link->language_title, array('title' => $link->language_title), true); ?>
				                                    <?php else : ?>
					                                    <?php echo '<span class="label" title="' . $link->language_title . '">' . $link->language_sef . '</span>'; ?>
				                                    <?php endif; ?>
			                                    <?php endif; ?>
			                                    <?php if ($link->published == 0) : ?>
				                                    <?php echo ' <span class="label">' . JText::_('JUNPUBLISHED') . '</span>'; ?>
			                                    <?php endif; ?>
			                                    <?php if ($uselessMenuItem) : ?>
				                                    <?php echo ' <span class="label">' . JText::_('COM_MODULES_MENU_ITEM_' . strtoupper($link->type)) . '</span>'; ?>
			                                    <?php endif; ?>
                                            </label>

                                            <div class="small">
                                                <a class="treeExpandAll" href="javascript://"><?php echo JText::_('JALL'); ?></a>,
                                                <a class="treeCollapseAll" href="javascript://"><?php echo JText::_('JNONE'); ?></a>
                                            </div>

                                        </div>
                                    </div>

								<?php

								if (!isset($type->links[$i + 1]))
								{
									echo str_repeat('</li></ul>', $link->level);
								}
								$prevlevel = $link->level;
								?>
							<?php endforeach; ?>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>


		<?php endif; ?>
	</div>
</div>