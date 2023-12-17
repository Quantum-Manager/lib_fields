<?php namespace JPATHRU\Libraries\Fields\Field\QuantumAccessibleMedia;

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\Field\AccessiblemediaField;

class QuantumAccessibleMediaField extends AccessiblemediaField
{

	protected $type = 'QuantumAccessibleMedia';

	protected $dropAreaHidden;

	public function setup(\SimpleXMLElement $element, $value, $group = null)
	{
		/**
		 * When you have subforms which are not repeatable (i.e. a subform custom field with the
		 * repeat attribute set to 0) you get an array here since the data comes from decoding the
		 * JSON into an associative array, including the media subfield's data.
		 *
		 * However, this method expects an object or a string, not an array. Typecasting the array
		 * to an object solves the data format discrepancy.
		 */
		$value = is_array($value) ? (object) $value : $value;

		/**
		 * If the value is not a string, it is
		 * most likely within a custom field of type subform
		 * and the value is a stdClass with properties
		 * imagefile and alt_text. So it is fine.
		 */
		if (\is_string($value)) {
			json_decode($value);

			// Check if value is a valid JSON string.
			if ($value !== '' && json_last_error() !== JSON_ERROR_NONE) {
				/**
				 * If the value is not empty and is not a valid JSON string,
				 * it is most likely a custom field created in Joomla 3 and
				 * the value is a string that contains the file name.
				 */
				if (is_file(JPATH_ROOT . '/' . $value)) {
					$value = '{"imagefile":"' . $value . '","alt_text":""}';
				} else {
					$value = '';
				}
			}
		} elseif (
			!is_object($value)
			|| !property_exists($value, 'imagefile')
			|| !property_exists($value, 'alt_text')
		) {
			return false;
		}

		if (!parent::setup($element, $value, $group)) {
			return false;
		}

		$this->directory = (string) $this->element['directory'];
		$this->preview = (string) $this->element['preview'];
		$this->previewHeight = isset($this->element['preview_height']) ? (int) $this->element['preview_height'] : 200;
		$this->previewWidth = isset($this->element['preview_width']) ? (int) $this->element['preview_width'] : 200;
		$this->dropAreaHidden = (string) $this->element['dropAreaHidden'] ?? '0';

		$xml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<form>
	<fieldset
		name="quantumaccessiblemedia"
		label="JLIB_FORM_FIELD_PARAM_ACCESSIBLEMEDIA_LABEL"
	>
		<field
			name="imagefile"
			type="quantumuploadimage"
			label="JLIB_FORM_FIELD_PARAM_ACCESSIBLEMEDIA_PARAMS_IMAGEFILE_LABEL"
			directory="$this->directory"
			dropAreaHidden="$this->dropAreaHidden"
			preview="$this->preview"
			preview_width="$this->previewWidth"
			preview_height="$this->previewHeight"
		/>

		<field
			name="alt_text"
			type="text"
			label="JLIB_FORM_FIELD_PARAM_ACCESSIBLEMEDIA_PARAMS_ALT_TEXT_LABEL"
		/>

		<field
			name="alt_empty"
			type="checkbox"
			label="JLIB_FORM_FIELD_PARAM_ACCESSIBLEMEDIA_PARAMS_ALT_EMPTY_LABEL"
			description="JLIB_FORM_FIELD_PARAM_ACCESSIBLEMEDIA_PARAMS_ALT_EMPTY_DESC"
		/>
	</fieldset>
</form>
XML;
		$this->formsource = $xml;

		$this->layout = 'joomla.form.field.media.accessiblemedia';

		return true;
	}

}