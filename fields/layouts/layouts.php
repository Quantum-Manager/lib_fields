<?php defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Layout\FileLayout;
use Joomla\Filesystem\Folder;

FormHelper::loadFieldClass('list');

class JFormFieldLayouts extends JFormFieldList
{


	public function getOptions()
	{
		$layout      = new FileLayout('');
		$values      = $this->getAttribute('values', '');
		$options     = [];
		$paths       = $layout->getIncludePaths();
		$files_exist = [];

		if (strpos($values, '::') !== false)
		{
			$executes = explode(',', $values);

			foreach ($executes as $execute)
			{
				list($class, $method) = explode('::', $execute);

				if (class_exists($class) && method_exists($class, $method))
				{
					$result = forward_static_call([$class, $method]);

					if (is_array($result))
					{
						$paths = array_merge($paths, $result);
					}

				}
			}

		}

		foreach ($paths as $path)
		{
			if (file_exists($path))
			{
				$files = Folder::files($path);
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
					$option->value = $name;
					$option->text  = $name;
					$options[]     = $option;
				}
			}

		}

		return array_merge(parent::getOptions(), $options);
	}


}