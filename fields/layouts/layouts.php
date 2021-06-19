<?php defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\Filesystem\Folder;

FormHelper::loadFieldClass('list');

class JFormFieldLayouts extends JFormFieldList
{


	protected $paths = [];


	protected $cache_paths = [];


	public function getInput()
	{
		$html        = [];
		$values      = $this->getAttribute('values', '');
		$target      = $this->getAttribute('target', '');
		$options     = [];
		$files_exist = [];
		$result      = [];
		$templates   = Folder::folders(JPATH_ROOT . '/templates');
		$attr        = $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
		$attr        .= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';

		$this->setPaths();
		$this->addPath([
			'type' => 'joomla',
			'path' => JPATH_ROOT . '/layouts'
		]);

		if (strpos($values, '::') !== false)
		{
			$executes = explode(',', $values);

			foreach ($executes as $execute)
			{
				[$class, $method] = explode('::', $execute);

				if (class_exists($class) && method_exists($class, $method))
				{
					$result = forward_static_call([$class, $method]);
				}
			}

		}

		foreach ($templates as $template)
		{
			$this->addPath([
				'type' => 'template',
				'name' => $template,
				'path' => JPATH_ROOT . '/templates/' . $template . '/html/layouts'
			]);

			if (is_array($result))
			{
				foreach ($result as $value)
				{
					if (strpos($value, '{TEMPLATES}') !== false)
					{
						$this->addPath([
							'type' => 'template',
							'name' => $template,
							'path' => str_replace('{TEMPLATES}', JPATH_ROOT . '/templates/' . $template, $value)
						]);
						continue;
					}

					$this->addPath([
						'type' => 'joomla',
						'path' => $value
					]);
				}
			}

			if (!empty($target))
			{
				$targets = explode(',', $target);
				foreach ($targets as $target_c)
				{
					$this->addPath([
						'type' => 'template',
						'name' => $template,
						'path' => JPATH_ROOT . '/templates/' . $template . '/html/layouts/' . $target_c
					]);
				}
			}
		}

		$groups = [];

		foreach ($this->getPaths() as $path)
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


	protected function setPaths($paths = [])
	{
		$this->paths = $paths;
	}


	protected function getPaths()
	{
		return $this->paths;
	}


	protected function addPath($path)
	{
		if (in_array($path['path'], $this->cache_paths))
		{
			return false;
		}

		$this->cache_paths[] = $path['path'];
		$this->paths[]       = $path;

		return true;
	}

}