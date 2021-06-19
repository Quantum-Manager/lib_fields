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
		$path      = JPATH_LIBRARIES . '/lib_fields';
		$folders   = Folder::folders($path);
		$copyFiles = [];

		foreach ($folders as $folder)
		{
			$path_current = $path . '/' . $folder . '/media';
			if (file_exists($path_current))
			{
				$copyFiles[] = [
					'src'  => $path_current,
					'dest' => JPATH_ROOT . '/media/lib_fields/' . $folder,
					'type' => 'folder'
				];
			}
		}

		return $installer->copyFiles($copyFiles, true);
	}

}
