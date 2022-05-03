<?php defined('_JEXEC') or die;

use Joomla\Filesystem\Folder;

/**
 * Class Lib_fieldsInstallerScript
 */
class Lib_fieldsInstallerScript
{


	public function postflight($type, $parent)
	{
		$this->copyMedia($parent->getParent());

		return true;
	}


	protected function copyMedia($installer)
	{
		$dest      = JPATH_ROOT . '/media/lib_fields';
		$path      = JPATH_ROOT . '/libraries/lib_fields/fields';
		$folders   = Folder::folders($path);
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
					'dest' => $dest . '/' . $folder,
					'type' => 'folder'
				];
			}
		}

		return $installer->copyFiles($copyFiles, true);
	}

}
