<?php defined('JPATH_PLATFORM') or die;

use Joomla\Filesystem\Folder;
use Joomla\Filesystem\Path;

class LayoutPathsHelper
{

	protected $paths = [];


	protected $cache_paths = [];


	public function __construct($target = '', $other_paths = '', $template = '')
	{

		if (empty($template))
		{
			$templates = Folder::folders(JPATH_ROOT . '/templates');
		}
		else
		{
			$templates = [
				$template
			];
		}

		$result = [];

		if (empty($target))
		{
			$this->add([
				'type' => 'joomla',
				'path' => JPATH_ROOT . '/layouts'
			]);
		}

		if (strpos($other_paths, '::') !== false)
		{
			$executes = explode(',', $other_paths);

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
			if (empty($target))
			{
				$this->add([
					'type' => 'template',
					'name' => $template,
					'path' => JPATH_ROOT . '/templates/' . $template . '/html/layouts'
				]);
			}

			if (is_array($result))
			{
				foreach ($result as $value)
				{
					if (strpos($value, '{TEMPLATES}') !== false)
					{
						$this->add([
							'type' => 'template',
							'name' => $template,
							'path' => str_replace('{TEMPLATES}', JPATH_ROOT . '/templates/' . $template, $value)
						]);
						continue;
					}

					$this->add([
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
					$tmp = str_replace('.', '/', $target_c);
					$this->add([
						'type' => 'template',
						'name' => $template,
						'path' => JPATH_ROOT . '/templates/' . $template . '/html/layouts/' . $tmp
					]);

					$this->add([
						'type' => 'joomla',
						'name' => $template,
						'path' => JPATH_ROOT . '/layouts/' . $tmp
					]);
				}
			}
		}

	}


	public function get($type = '')
	{

		if ($type === 'paths')
		{
			$paths  = $this->paths;
			$output = [];
			foreach ($paths as $path)
			{
				$output[] = $path['path'];
			}

			return $output;
		}

		return $this->paths;
	}


	protected function set($paths = [])
	{
		$this->paths = $paths;
	}


	protected function add($path)
	{
		if (in_array($path['path'], $this->cache_paths))
		{
			return false;
		}

		$path['path']        = Path::clean($path['path']);
		$this->cache_paths[] = $path['path'];
		$this->paths[]       = $path;

		return true;
	}


}