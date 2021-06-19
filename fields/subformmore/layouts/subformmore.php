<?php defined('_JEXEC') or die;

/**
 * Make thing clear
 *
 * @var JForm   $tmpl             The Empty form for template
 * @var array   $forms            Array of JForm instances for render the rows
 * @var bool    $multiple         The multiple state for the form field
 * @var int     $min              Count of minimum repeating in multiple mode
 * @var int     $max              Count of maximum repeating in multiple mode
 * @var string  $fieldname        The field name
 * @var string  $control          The forms control
 * @var string  $label            The field label
 * @var string  $description      The field description
 * @var array   $buttons          Array of the buttons that will be rendered
 * @var bool    $groupByFieldset  Whether group the subform fields by it`s fieldset
 */
extract($displayData);

// Add script
if ($multiple)
{
	JHtml::_('jquery.ui', array('core', 'sortable'));
	JHtml::_('script', 'system/subform-repeatable.js', array('version' => 'auto', 'relative' => true));
}

// Build heading
$table_head = '';
$count = count($tmpl->getFieldset('default'));

foreach ($tmpl->getFieldset('default') as $field) {
    $table_head .= '<th>' . strip_tags($field->label);

    if ($field->description)
    {
        $table_head .= '<br /><small style="font-weight:normal">' . JText::_($field->description) . '</small>';
    }

    $table_head .= '</th>';
}

$sublayout = 'section';

?>
<div class="row-fluid">
	<div class="subform-subformmore-wrapper subform-subformmore-layout subform-subformmore-sublayout-<?php echo $sublayout; ?>">
		<div
			class="subform-repeatable"
			data-bt-add="a.group-add-<?php echo $unique_subform_id; ?>"
			data-bt-remove="a.group-remove-<?php echo $unique_subform_id; ?>"
			data-bt-move="a.group-move-<?php echo $unique_subform_id; ?>"
			data-repeatable-element="tr.subform-subformmore-group-<?php echo $unique_subform_id; ?>"
			data-rows-container="tbody.rows-container-<?php echo $unique_subform_id; ?>"
			data-minimum="<?php echo $min; ?>" data-maximum="<?php echo $max; ?>"
		>
			<table class="adminlist table table-striped table-bordered">
				<tbody class="rows-container-<?php echo $unique_subform_id; ?>">
					<?php foreach ($forms as $k => $form):
						echo $this->sublayout(
							$sublayout,
							array(
								'form' => $form,
								'basegroup' => $fieldname,
								'group' => $fieldname . $k,
								'buttons' => $buttons,
								'unique_subform_id' => $unique_subform_id,
							)
						);
					endforeach; ?>
				</tbody>
                <tfoot>
                    <tr>
                        <td colspan="<?php echo $count + 1 ?>">
                            <a
                                class="btn button btn-success group-add group-add-<?php echo $unique_subform_id; ?>"
                                aria-label="<?php echo JText::_('JGLOBAL_FIELD_ADD'); ?>"
                            >
                                <span class="icon-plus" aria-hidden="true"></span> <?php echo JText::_('JGLOBAL_FIELD_ADD'); ?>
                            </a>
                        </td>
                    </tr>
                </tfoot>
			</table>

			<?php if ($multiple) : ?>
				<template class="subform-repeatable-template-section" style="display: none;"><?php
					// Use str_replace to escape HTML in a simple way, it need for IE compatibility, and should be removed later
					echo str_replace(
							array('<', '>'),
							array('SUBFORMLT', 'SUBFORMGT'),
							trim(
								$this->sublayout(
									$sublayout,
									array(
										'form' => $tmpl,
										'basegroup' => $fieldname,
										'group' => $fieldname . 'X',
										'buttons' => $buttons,
										'unique_subform_id' => $unique_subform_id,
									)
								)
							)
					);
					?></template>
			<?php endif; ?>
		</div>
	</div>
</div>
