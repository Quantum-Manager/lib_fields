<?php defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\FormHelper;
use Joomla\Filesystem\Folder;

FormHelper::loadFieldClass('list');

class JFormFieldLayouts extends JFormFieldList
{


	protected $paths = [];


	protected $cache_paths = [];


	public function getOptions()
	{
		$this->setPaths();
		$values  = $this->getAttribute('values', '');
		$target  = $this->getAttribute('target', '');
		$options = [];
		$this->addPath([
			'type' => 'joomla',
			'path' => JPATH_ROOT . '/layouts'
		]);
		$files_exist = [];
		$result      = [];
		$templates   = Folder::folders(JPATH_ROOT . '/templates');

		if (strpos($values, '::') !== false)
		{
			$executes = explode(',', $values);

			foreach ($executes as $execute)
			{
				list($class, $method) = explode('::', $execute);

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

					$option        = new stdClass();
					$option->value = ($path['type'] === 'template') ? ($path['name'] . '::' . $name) : $name;
					$option->text  = ($path['type'] === 'template') ? ($path['name'] . '::' . $name) : $name;
					$options[]     = $option;
				}
			}

		}

		return array_merge(parent::getOptions(), $options);
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