<?php defined('_JEXEC') or die;

use Joomla\Filesystem\Folder;
use Joomla\Filesystem\Path;

if (class_exists('Lib_fieldsInstallerScript'))
{
	return;
}

/**
 * Class Lib_fieldsInstallerScript
 */
class Lib_fieldsInstallerScript
{


	public function postflight($type, $parent)
	{

		if ($type === 'install' || $type === 'update')
		{
			$this->copyMedia($parent->getParent());
		}

		if ($type === 'uninstall')
		{
			$this->deleteMedia();
		}

		return true;
	}


	protected function copyMedia($installer)
	{
		$dest    = JPATH_ROOT . '/media/lib_fields';
		$path    = Path::clean(JPATH_ROOT . '/libraries/lib_fields/src/Field');

		if(!file_exists($path))
		{
			return;
		}

		$folders = Folder::folders($path);

		$copyFiles = [];

		if (!file_exists($dest))
		{
			Folder::create($dest);
		}

		foreach ($folders as $folder)
		{
			$path_current = $path . '/' . $folder . '/media';
			if (file_exists($path_current))
			{
				$copyFiles[] = [
					'src'  => $path_current,
					'dest' => $dest . '/' . strtolower($folder),
					'type' => 'folder'
				];
			}
		}

		return $installer->copyFiles($copyFiles, true);
	}


	protected function deleteMedia()
	{
		$dest = JPATH_ROOT . '/media/lib_fields';

		if (file_exists($dest))
		{
			try
			{
				return Folder::delete($dest);
			}
			catch (Exception $e)
			{
				return false;
			}
		}

		return true;
	}
}
