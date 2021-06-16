<?php defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/**
 * Make thing clear
 *
 * @var JForm   $form       The form instance for render the section
 * @var string  $basegroup  The base group name
 * @var string  $group      Current group name
 * @var array   $buttons    Array of the buttons that will be rendered
 */
extract($displayData);
$count = count($form->getFieldset('default'));

$table_head = '';


foreach ($form->getFieldset('default') as $field) {
    $table_head .= '<th>' . strip_tags($field->label);

    if ($field->description)
    {
        $table_head .= '<br /><small style="font-weight:normal">' . JText::_($field->description) . '</small>';
    }

    $table_head .= '</th>';
}


?>

<tr
	class="subform-subformmore-group subform-subformmore-group-<?php echo $unique_subform_id; ?>"
	data-base-name="<?php echo $basegroup; ?>"
	data-group="<?php echo $group; ?>"
>
    <td colspan="<?php echo $count + 1 ?>">
        <table class="adminlist table table-striped table-bordered" style="border: none;margin: -8px">
            <thead>
            <tr>
		        <?php echo $table_head; ?>
		        <?php if (!empty($buttons)) : ?>
                    <th style="width:8%;">
				        <?php if (!empty($buttons['add'])) : ?>
                            <div class="btn-group">
                                <a
                                    class="btn btn-mini button btn-success group-add group-add-<?php echo $unique_subform_id; ?>"
                                    aria-label="<?php echo JText::_('JGLOBAL_FIELD_ADD'); ?>"
                                >
                                    <span class="icon-plus" aria-hidden="true"></span>
                                </a>
                            </div>
				        <?php endif; ?>
                    </th>
		        <?php endif; ?>
            </tr>
            </thead>
            <tbody>
                <tr class="form-vertical">
                    <?php foreach ($form->getFieldset('default') as $field) : ?>
                        <td data-column="<?php echo strip_tags($field->label); ?>">
                            <?php echo $field->renderField(array('hiddenLabel' => true)); ?>
                        </td>
                    <?php endforeach; ?>
                    <?php if (!empty($buttons)) : ?>
                        <td>
                            <div class="btn-group">
                                <?php if (!empty($buttons['add'])) : ?>
                                    <a class="btn btn-mini button btn-success group-add group-add-<?php echo $unique_subform_id; ?>" aria-label="<?php echo JText::_('JGLOBAL_FIELD_ADD'); ?>">
                                        <span class="icon-plus" aria-hidden="true"></span>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($buttons['remove'])) : ?>
                                    <a class="btn btn-mini button btn-danger group-remove group-remove-<?php echo $unique_subform_id; ?>" aria-label="<?php echo JText::_('JGLOBAL_FIELD_REMOVE'); ?>">
                                        <span class="icon-minus" aria-hidden="true"></span>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($buttons['move'])) : ?>
                                    <a class="btn btn-mini button btn-primary group-move group-move-<?php echo $unique_subform_id; ?>" aria-label="<?php echo JText::_('JGLOBAL_FIELD_MOVE'); ?>">
                                        <span class="icon-move" aria-hidden="true"></span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <td colspan="<?php echo $count?>">
                        <button class="subformmore-accordion" type="button"><?php echo Text::_('PLG_SYSTEM_REVO_OPTIMIZER_CONFIG_SUBFORMMORE_MORE'); ?></button>
                        <div class="subformmore-panel">
                            <div class="form-horizontal">
	                            <?php foreach ($form->getFieldset('more') as $field) : ?>
                                    <?php echo $field->renderField(); ?>
	                            <?php endforeach; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
