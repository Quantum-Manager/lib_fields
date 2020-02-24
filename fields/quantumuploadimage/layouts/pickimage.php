<?php

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;
extract($displayData);

HTMLHelper::_('stylesheet','lib_fields/quantumuploadimage/field.css', [
	'version' => filemtime(__FILE__),
	'relative' => true
]);

HTMLHelper::_('script', 'lib_fields/quantumuploadimage/field.js', [
	'version' => filemtime(__FILE__),
	'relative' => true
]);

$app = Factory::getApplication();
$img = !empty($displayData['value']) ? '/' . $displayData['value'] : '/images/joomla_black.png';
$value = $displayData['value'];

$app->getSession()->set('quantummanageraddscripts', json_encode([
	'lib_fields/quantumuploadimage/modal.js'
]));

$quantumOptions = [
	'option' => 'com_quantummanager',
	'tmpl' => 'component',
	'layout' => 'modal',
	'fieldid' => $displayData['id'],
];
?>

<div class="quantumuploadimage-wrap">
	<input type="hidden" name="<?php echo $displayData['name'] ?>" id="<?php echo $displayData['id'] ?>" value="<?php echo $value ?>">
	<img src="<?php echo $img ?>">
	<div class="group-buttons">
		<a
			class="btn modal-button"
			href="index.php?<?php echo http_build_query($quantumOptions) ?>"
		   rel="{handler: 'iframe', size: {x: 1450, y: 700}, classWindow: 'quantummanager-modal-sbox-window'}">Выбрать</a>
		<button class="btn quantumuploadimage-upload-start">Загрузить</button>
	</div>
</div>
