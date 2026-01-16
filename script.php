<?php

defined('_JEXEC') or die;

use Joomla\CMS\Application\AdministratorApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\Database\DatabaseDriver;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Filesystem\Folder;
use Joomla\Filesystem\Path;

return new class () implements ServiceProviderInterface {
	public function register(Container $container)
	{
		$container->set(InstallerScriptInterface::class, new class ($container->get(AdministratorApplication::class)) implements InstallerScriptInterface {

			protected AdministratorApplication $app;

			protected DatabaseDriver $db;

			public function __construct(AdministratorApplication $app)
			{
				$this->app = $app;
				$this->db  = Factory::getContainer()->get('DatabaseDriver');
			}

			public function install(InstallerAdapter $adapter): bool
			{
				$this->copyMedia();

				return true;
			}

			public function update(InstallerAdapter $adapter): bool
			{
				$this->copyMedia();

				return true;
			}

			public function uninstall(InstallerAdapter $adapter): bool
			{
				$this->deleteMedia();

				return true;
			}

			public function preflight(string $type, InstallerAdapter $adapter): bool
			{
				return true;
			}

			public function postflight(string $type, InstallerAdapter $adapter): bool
			{
				return true;
			}

			protected function copyMedia()
			{
				$dest = JPATH_ROOT . '/media/lib_fields';
				$path = Path::clean(JPATH_ROOT . '/libraries/lib_fields/fields');

				if (!file_exists($path))
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

				foreach ($copyFiles as $copy)
				{
					if ($copy['type'] == 'folder')
					{
						Folder::copy($copy['src'], $copy['dest']);
					}
				}

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

		});
	}
};