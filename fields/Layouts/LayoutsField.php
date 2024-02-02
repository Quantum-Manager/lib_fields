<?php namespace JPATHRU\Libraries\Fields\Layouts;

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\Filesystem\Folder;
use JPATHRU\Libraries\Fields\Layouts\Helper\LayoutPathsHelper;
use stdClass;

class LayoutsField extends ListField
{

	public function getInput()
	{
		$html        = [];
		$values      = $this->getAttribute('values', '');
		$target      = $this->getAttribute('target', '');
		$options     = [];
		$files_exist = [];
		$attr        = $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
		$attr        .= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
		$groups      = [];
		$paths       = new LayoutPathsHelper($target, $values);

		foreach ($paths->get() as $path)
		{
			if (file_exists($path['path']))
			{
				$files = Folder::files($path['path']);
				foreach ($files as $file)
				{
					$split = explode('.', $file);
					$ext   = array_pop($split);
					$name  = implode('.', $split);

					if ($ext !== 'php')
					{
						continue;
					}

					if (in_array($name, $files_exist))
					{
						continue;
					}

					$subgroup = $path['name'] ?? 'joomla';
					if (!isset($groups[$path['type']]))
					{
						$groups[$path['type']] = [];
					}

					if (!isset($groups[$path['type']][$subgroup]))
					{
						$groups[$path['type']][$subgroup] = [];
					}

					$option                             = new stdClass();
					$option->value                      = ($path['type'] === 'template') ? ($path['name'] . '::' . $name) : $name;
					$option->text                       = $name;
					$groups[$path['type']][$subgroup][] = $option;
				}
			}

		}

		foreach ($groups as $name => $options_c)
		{

			foreach ($options_c as $subgroup => $options_sub)
			{
				$options[$subgroup] = [
					'id'    => $name . '.' . $subgroup,
					'text'  => '',
					'items' => [],
				];

				if ($name === 'template')
				{
					$options[$subgroup]['text'] = Text::sprintf('JOPTION_FROM_TEMPLATE', $subgroup);
				}

				$options[$subgroup]['items'] = array_merge($options[$subgroup]['items'], $options_sub);
			}

		}

		$selected = [$this->value];
		$html[]   = HTMLHelper::_(
			'select.groupedlist', $options, $this->name,
			['id' => $this->id, 'group.id' => 'id', 'list.attr' => $attr, 'list.select' => $selected]
		);

		return implode($html);
	}

}