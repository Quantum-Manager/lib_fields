<?php namespace Joomla\CMS\Form\Field;
defined('_JEXEC') or die;
// TODO отрефакторить
/**------------------------------------------------------------------------
 * @name		Field - Table Conatinier data fields
 * ------------------------------------------------------------------------
 * @author		Sergei Borisovich Korenevskiy
 * @copyright	(C) 2021 //explorer-office.ru. All Rights Reserved.
 * @license		GPL   GNU General Public License version 2 or later;
 * @creationDate	2022-03-25
 * @modifed			2022-04-13
 * @introduced		2022-04-13
 * @created
 * @package     Joomla Fields
 * @subpackage  GridFields
 * @version  4
 * Websites: http://explorer-office.ru/download/
 * Technical Support:  Forum - http://vk.com/korenevskiys
 */ 

// Tasks:
// 1: Fix selected radiobutton with drag line in table
 
use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Document\Document as JDocument;
use Joomla\CMS\Language\Text as JText;
use Joomla\CMS\HTML\HTMLHelper as JHtml;
use Joomla\CMS\Form\FormHelper as JFormHelper;
use Joomla\CMS\Form\Field\ListField as JFormFieldList;
use Joomla\CMS\Form\Field\SqlField as JFormFieldSql;
use Joomla\CMS\Form\FormField as JFormField;
use Joomla\CMS\Helper\ModuleHelper as JModuleHelper;
use Joomla\CMS\Layout\LayoutHelper as JLayoutHelper;
use Joomla\CMS\Layout\FileLayout as JLayoutFile;
use \Joomla\CMS\Version as JVersion;
//use Joomla\CMS\Layout\BaseLayout as JLayoutBase;

use Joomla\CMS\Layout\FileLayout;
use  Joomla\Database\Exception;
//use Joomla\CMS\Helper\ModuleHelper as JModuleHelper;
 

//if(file_exists(__DIR__ . '/../functions.php'))
//	require_once  __DIR__ . '/../functions.php';
 
//toPrint(1234,'1234',0,'pre',true);
//echo "<pre>";
//print_r('Какрена', true);
//echo "</pre>";

//toPrint('abraCadabra','$this',0,'message',true);
//return;

JHtml::_('jquery.framework');
JHtml::_('bootstrap.framework');

//JFormHelper::addFieldPath(__DIR__.DIRECTORY_SEPARATOR.'');

JFormHelper::loadFieldClass('field');
JFormHelper::loadFieldClass('list');
JFormHelper::loadFieldClass('sql');

//namespace Joomla\CMS\Form\Field;

//   \Joomla\CMS\Form\FormField
//JFormHelper::loadFieldClass('filelist');
//use Joomla\CMS\Form\Field\FilelistField as JFormFieldFileList; 

class GridFieldsField extends JFormFieldSql  {//JFormField  //JFormFieldList //JFormFieldSql 
//JFormFieldGridFields  -- class for custom uses -- имя класса для испльзования в своих компонентах и модулях
//GridFieldsField -- class for system location path -- имя класса для размещения в системной папке полей, 
//
//Joomla\CMS\Form\Field\TableFieldsField/
//JFormFieldGridFields

// for "table_Fields"    class Joomla\CMS\Form\Field\Table\FieldsField/ 
// for "table_Fields"    class JFormFieldTable_Fields 
// for "table_Fields"    path  /modules/mod_multi_form/fields/table/
// for "table_Fields"    path  /modules/mod_multi_form/field/table/

//C:\Servers\OSPanel\domains\joomla/administrator/components/com_content/models/fields/modal/
//C:\Servers\OSPanel\domains\joomla/modules/mod_multi_form/fields/
//C:\Servers\OSPanel\domains\joomla/modules/mod_multi_form/fields
//C:\Servers\OSPanel\domains\joomla\administrator/components/com_modules/model/field
//C:\Servers\OSPanel\domains\joomla\administrator/components/com_modules/models/fields
//C:\Servers\OSPanel\domains\joomla/modules/mod_multi_form/field
//C:\Servers\OSPanel\domains\joomla\libraries/cms/form/field
//C:\Servers\OSPanel\domains\joomla\libraries/joomla/form/fields
//C:\Servers\OSPanel\domains\joomla\libraries\src\Form/fields
    
    /**
     * Use icon style for column counter and column Delete&New
     * 
     * please will be including one from it style fonts
     * <link rel="stylesheet" href="/media/jui/css/icomoon.css"> <br>
     * <link rel="stylesheet" href="/media/vendor/font-awesome/css/font-awesome.min.css">  <br>
     * <link rel="stylesheet" href="/media/vendor/fontawesome-free/css/fontawesome.min.css">
     * 
     * 
     * @var string IcoMoon | FontAwesome
     */
    public $fontIcon = 'IcoMoon';//IcoMoon || FontAwesome
    
    public $creatableClass = '';
    
    public $movableClass = '';
    
    public $removableClass = '';
	
    public $buttonClass = ' btn-sm ';
    
    
    public $script = '';
    
	/**
	 * CSS style code adding after table in < style / > tag
	 * @var string
	 */
    public $css = '';
    
	/**
	 * Style DIV parent table
	 * @var string
	 */
    public $style = '';
	
	/**
	 * 
	 * @var string
	 */
	public $defaultSql = '';
	/**
	 * 
	 * @var string
	 */
	public $sql = '';
	
	/**
	 * The translate.
	 *
	 * @var    boolean
	 * @since  3.2
	 */
	public $translate = false;

	/**
	 * The query.
	 *
	 * @var    string|DatabaseQuery
	 * @since  3.2
	 */
	public $query;
    
    /**
	 * Данные таблицы
	 *
	 * @var    array
	 * @since  3.2
	 */
    public $value = [];
    
    /**
	 * Значения дынных по умолчанию для таблицы в JSON
	 * <pre>
	 *	{
	 *		"first_name_column":["Madonna","Bred"],
	 *		"second_name_column":["Chikone","Pit"],
	 * 		"last_name_column":["Super","Star"]
	 * 	}</pre>
	 * @var    string
	 * @since  3.2
	 */
    public $default = '';
    
    /**
	 * Строка описания таблицы.
	 *
	 * @var    bool
	 * @since  3.2
	 */
    public $hiddenLabel = true; 
	
    /**
	 * Строка описания таблицы.
	 *
	 * @var    string
	 * @since  3.2
	 */
    public $hiddenDescription = true; 
	    
    /**
	 * Строка описания таблицы.
	 *
	 * @var    string
	 * @since  3.2
	 */
    public $caption = '';
    /**
	 * Перевод Caption
	 *
	 * @var    string
	 * @since  3.2
	 */
    public $translateCaption = true;
    
    /**
	 * Строка описания развертывание
	 *
	 * @var    bool
	 * @since  3.2
	 */
    public $captionExpander = true;
    
    /**
	 * Строка описания развернуто
	 *
	 * @var    bool
	 * @since  3.2
	 */
    public $captionExpanded = false;

    /**
	 * Строка вывода ошибок.
	 *
	 * @var    string
	 * @since  3.2
	 */
    public $error = '';

//    /**
//	 * Строки данных.
//	 *
//	 * @var    array
//	 * @since  3.2
//	 */
//	public $rowsLayoutData = [];
    
	/**
	 * Поля
	 *
	 * @var    array
	 * @since  3.2
	 */
//	public $fields = [];
    
	/**
	 * Колонки с полями XML SimpleXMLElement.
     * array SimpleXMLElement
	 *
	 * @var    array
	 * @since  3.2
	 */
	protected $columnsXML = [];
    
	/**
	 * Данные колонок.
     * array FormField  
	 *
	 * @var    array
	 * @since  3.2
	 */
	public $columns = [];
    
	/**
	 * Ручная сортировка строк перетаскиванием
	 *
	 * @var    true
	 * @since  3.2
	 */
	public $movable = true;
    
	/**
	 * Добавление строк
	 *
	 * @var    true
	 * @since  3.2
	 */
	public $creatable = true;
    
	/**
	 * Удаление строк
	 *
	 * @var    true
	 * @since  3.2
	 */
	public $removable = true;

	/**
	 * Allows extensions to create repeat elements
	 *
	 * @var    true
	 * @since  3.2
	 */
	public $repeat = true;
    
    /**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.7.0
	 */
	public $type = 'GridFields'; //table tableFields
    
	/**
	 * Name of the layout being used to render the field
	 *
	 * @var    string
	 * @since  4.0.0
	 */
	protected $layout = 'fields.gridfields';//'joomla.form.field.gridfields';//GridFields
	/**
	 * Layout to render the form field
	 *
	 * @var  string
	 */
//	protected $renderLayout = 'tablefields';

	/**
	 * Layout to render the label
	 *
	 * @var  string
	 */
	protected $renderLabelLayout = 'joomla.form.renderlabel';
	/**
	 * Method to instantiate the form field object.
	 *
	 * @param   Form  $form  The form to attach to the form field object.
	 *
	 * @since   1.7.0
	 */
    public function __construct($form = null){
//        $this->default;
//        $script = "jQuery(function(){
//            
//            });";
        $this->moduleid = $mod_id = JFactory::getApplication()->input->getCmd('id');
//        $this->moduleid = $mod_id = $this->form->getValue('id',null,0); 
        $this->fontIcon = JVersion::MAJOR_VERSION > 3 ? 'FontAwesome' : 'IcoMoon';
        
        $this->isJ4 = JVersion::MAJOR_VERSION > 3; 
        
        
        $this->hiddenLabel = true;
		$this->hiddenDescription = true;
        
//toPrint($this,'$this',0,'pre');
//        JDocument::getInstance()->addScriptDeclaration("console.log('🚀 Captcha_type-$mod_id:')");
        
        parent::__construct($form);
    }
    
	/**
	 * Method to attach a JForm object to the field.
	 *
	 * @param   \SimpleXMLElement  $element  The SimpleXMLElement object representing the `<field>` tag for the form field object.
	 * @param   mixed              $value    The form field value to validate.
	 * @param   string             $group    The field name group control value. This acts as as an array container for the field.
	 *                                       For example if the field has name="foo" and the group value is set to "bar" then the
	 *                                       full field name would end up being "bar[foo]".
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.7.0
	 */
	public function setup(\SimpleXMLElement $element, $value, $group = null)
	{
//toPrint($this,'$this',0,'pre');
		 
    
//        $element['multiple'] = true;


//        $this->getLabel();
        
//toPrint($element,                   '$element'              ,0,'message',true);
        $result = parent::setup($element, $value, $group);
        
//if($this->fieldname== 'list_currencies')
//toPrint($value,'$value',0,'pre');
//toPrint($this->name,'Name',0,'pre');//jform[params][list_units]		jform[params][list_currencies]/
//toPrint($this->fieldname,'Fieldname',0,'pre');//list_units			list_currencies

        if(empty($result))
            return false;
        
//toPrint((string)$this->label,                   '$this->label'              ,0,'message',true);
//toPrint((string)$this->label,                   '$this->label'              ,0,'message',true);
//toPrint($element,                   '$element'              ,0,'message',true);
        $element = $this->element;
//toPrint($element,                   '$element'              ,0,'message',true);
        
        $this->id = str_replace('-', '_', $this->id);
        
//toPrint($this->id); 
//toPrint($element,'Setup: $element',0,'pre'); 

        //JDocument::getInstance()->addScriptDeclaration();
        
//toPrint($this);
        
//default="{       &quot;namefield&quot;:[&quot;Name&quot;,&quot;Phone&quot;],       &quot;nameforpost&quot;:[&quot;Name&quot;,&quot;Phone&quot;],       &quot;typefield&quot;:[&quot;text&quot;,&quot;text&quot;],         &quot;paramsfield&quot;:[&quot;&quot;,&quot;&quot;],      &quot;art_id&quot;:[&quot;&quot;,&quot;&quot;],        &quot;onoff&quot;:[&quot;2&quot;,&quot;2&quot;]       }
//value="{"namefield":["Nickname","Name","Phone","Email"],"nameforpost":["Nickname","Name","Phone","Email"],"typefield":["text","text","tel","email"],"paramsfield":["","","+9 (999) 999-99-99",""],"art_id":["","","",""],"onoff":["2","2","2","2"]}"
        
		// Set the group of the field.
		$this->group = $group;
        
        $attributes = $attributesString = [
            'movable','creatable','removable', 'default', 'fontIcon',
            'movableClass','creatableClass','removableClass','style','buttonClass']; 
     
		$children = [
			'default', 'field', 'template', 'newLine', 'sql', 'caption', 'css','script' ];
        
        $default = '';
        
        foreach($element->attributes() as $attr => $val){//$XMLElement
            $attr = static::attributeToHungarianNotation($attr);
            if(in_array($attr, $attributesString))
                $this->$attr = (string)$val;
        }
        
        
        if($element->script){
            $this->script = (string)$element->script;
        }
		
        $this->css = '';
		
        if($element->style){
            $this->style = (string)$element->style;
        }
        if($element->css){
            $this->css = (string)$element->css;
        }
        if($element->defaultSql){
            $this->defaultSql = trim($element->defaultSql);
        }
        if($element->sql){
            $this->sql = trim($element->sql);
        }
        
            
//        foreach($element->attributes() as $attr => $val){//$XMLElement
//            $attr = static::attributeToHungarianNotation($attr);
//            if(in_array($attr, $attributesBool))
//                $this->$attr = (bool)$val;
//        }
         
        
//echo "<pre>";
//print_r($this->caption, true);
//echo "</pre>";
        
//toPrint($this->caption,'$this->caption',0,'message',true);
        ;
//toPrint((string)$this->element->caption,        '$this->element->caption'   ,0,'message',true); 
//toPrint((string)$element->caption,        '$element->caption'   ,0,'message',true); 
//toPrint((string)$this->label,                   '$this->label'              ,0,'message',true);
//toPrint((string)$this->getAttribute('caption'), '$element[caption]'         ,0,'message',true);

        $this->caption = (string)$element['caption'] ?: (string)$element->caption ?: $this->label ?: '';// (string)$this->element['name'] ?: $this->fieldname ?:
        
        
            if(isset($element['translate_label']))
                $this->translateLabel = (bool)$element['translate_label'];
            if(isset($element['translateLabel']))
                $this->translateLabel = (bool)$element['translateLabel'];
        
        if(isset($element['translate_caption']))
            $this->translateCaption = (bool)$element['translate_caption'];
        if(isset($element->caption['translate_caption']))
            $this->translateCaption = (bool)$element->caption['translate_caption'];
        if(isset($element->caption['translate']))
            $this->translateCaption = (bool)$element->caption['translate'];
        if(isset($element['translateCaption']))
            $this->translateCaption = (bool)$element['translateCaption'];
        if(isset($element->caption['translateCaption']))
            $this->translateCaption = (bool)$element->caption['translateCaption'];
        if(isset($element->caption['translate']))
            $this->translateCaption = (bool)$element->caption['translate'];
             
         
//        $this->getAttribute('translate_caption');
        
//        $this->label = '';
//        $this->hiddenLabel = true;
        
        if(isset($element->caption['expander'])){
            $this->captionExpander = (bool)$element->caption['expander'];
        }
        if($element->caption['expanded']){
            $this->captionExpanded = (bool)$element->caption['expanded'];
        } 
        
        
//		$this->default = isset($element['value']) ? (string) $element['value'] : $this->default;
        if($element->default){
            $this->default = (string)$element->default;
        }
        if($element->value){
            $this->default = (string)$element->value;
        }
		
		if(is_string($this->default) && (static::isTrue($element['translateDefault']) || static::isTrue($element['translate_default'])
				|| static::isTrue($element->default['translateDefault']) || static::isTrue($element->default['translate_default'])
				|| static::isTrue($element->default['translate']))){
			$this->default = JText::_($element->default);
		}
        
//toPrint($this->default,'$this->default',0,'message');
//toPrint($element,'$element',0,'message');
//toPrint($value,'$value',0,'pre');

		// Set the field default value.
		if (is_string($value))
		{
			$this->value = (array) json_decode($value);
		}
		else
		{
			$this->value = (array) $value;
		}
        
        if(empty($this->value) && $this->default && is_string($this->default)){
			$this->value = (array) json_decode($this->default);
        }
//        if($this->value && is_string($this->value)){
//			$this->value = (array) json_decode($this->value);
//        }
//toPrint($this->default,'$this->default',0,'pre');
         
//toPrint($this->value,'$this->value',0,'pre');
        $this->movable   = (bool) ($element['movable']  ?? true); 
        $this->creatable = (bool) ($element['creatable'] ?? true);
        $this->removable = (bool) ($element['removable'] ?? true);
        
//toPrint($this->value,'Value',0,'pre');
        $columnsXML = $element->xpath('field');//->children(); 
        
        foreach ($columnsXML as $k => $xml){ 
//if((string)$xml['name'] == 'default_cur'){
//toPrint((string)$xml['name']);
//toPrint(($xml ),(string)$xml['name']);//(string) ->asXML();
			$name = $k;
//}

            if((string)$xml['name']){
                $this->columnsXML[(string)$xml['name']] = $xml;
				$name = (string)$xml['name'];
            }
//			static::getDefaultData($xml);
			$value = isset($xml['value'])? (string)$xml['value'] : '';
			$default = isset($xml['default']) && empty($value)? (string)$xml['default'] : '';
             
            $column = static::createField($xml, $default);
//toPrint( $column->class,' $xml->class '.$this->name);
//toPrint($column->label);
//toPrint($column->class,$this->name);
//toPrint((string)$xml['class'],$this->name);
			$key = $this->addColumn($column, $name);
			
            $this->columns[$key]->element = $xml;
//            $this->columns[$column->name] = $column;
			
			 
//			$this->value[$key] = (array) $this->value[$key]; 
        }
		
		foreach((array)$this->value as $i => $colData){
			if(is_object($colData))
				$this->value[$i] = (array) $colData;
		}
//toPrint($this->columnsXML,'',0);
//toPrint($this->columns);
        
		return true;
	}
//toPrint($field,'$field',0,'pre'); //->children()
//toPrint($fieldXML,'$fieldXML',0,'pre'); //->children()
//toPrint($this->rowsLayoutData,'$this->rowsLayoutData',0,'pre'); 
//        $fieldText = new Joomla\CMS\Form\Field\TextField;
//toPrint((array)$element->xpath('field'),'$element',0,'pre'); //->children()
//toPrint($this->columns,'$element',0,'pre'); //->children()
//toPrint($this->columnsXML,'$element',0,'pre'); //->children()
        
//toPrint((string)$element->default,'Default: $element',0,'pre');
//toPrint($element,'Setup: $element',0,'pre');
//toPrint($this->columnsLayoutData,'Setup: $element',0,'pre');
        


    
//	protected $layout = 'joomla.form.field.table';


     
    
	 
    /**
     * 
     * @param JFormField|array $dataColumn object created static::createField($xml, $k); without values
     * @param string|int $name key int or string for column fields in table 
	 * @return  int return index in array columns
     */
    public function addColumn($dataColumn, $name = -1) { 
        
        if(empty($dataColumn)){
            unset($this->columns[$name]);
			return $name;
		}
		
//toPrint($dataColumn->hiddenLabel,'$dataColumn->hiddenLabel');		
//toPrint($dataColumn->text,'$dataColumn->text');		
		
        $attributes = [
            'autocomplete','autofocus','class','description','default','disabled',
            'element','field','group','hidden','hint',
            'id','label','labelclass','multiple','showon',
            'name','onchange','onclick','pattern','validationtext','readonly','repeat','required','size','spellcheck',
            'type','validate','dataAttribute','dataAttributes',//'value',
            'text','for','classes','classCell','classHeader','position', 'parentclass',
            'fieldname','translateLabel','translateDescription','translateHint', 'translateDefault',  'translateValue',
            'sortable', 'norender',
            'creatable','movable','removable',
            'style','styleHeader','styleCell',
            'translate_label', 'translate_description', // 'translate_default', 
			'input', 'countOptions', 'format', 'printf',
            ]; 
        
        $data = (object)array_fill_keys($attributes, '');//
        
//        $data->hidden = true;
        $data->hidden = false;
        $data->norender = false;
        $data->translateLabel = true;
        $data->translateDescription = true;
        $data->translateDefault = false;
        $data->field = NULL;
        $data->default = NULL;
		$data->rows = 1; // for type "textarea"
		$data->countOptions = false;
        
		foreach ($attributes as $attr){
			if(! isset($dataColumn->$attr)){
				$dataColumn->$attr = $data->$attr;
			}
		}
		
		unset($data);
        
		$dataColumn->class = empty($dataColumn->class) && ucwords($dataColumn->type) == 'Radio' ? ' btn-group-sm ' : $dataColumn->class; 
        $dataColumn->class = $dataColumn->class ?: ' form-control-sm form-select-sm '; //classCell
		$dataColumn->type  = $dataColumn->type ?: 'text';
//toPrint(strlen($dataColumn->class),' $dataColumn->class '.$this->name);
//toPrint( $dataColumn->class,' $dataColumn->class '.$this->name);
//toPrint( $dataColumn->class,' $dataColumn->class '.$this->name);
        $dataColumn->position = $dataColumn->name == 'alias' ? ' data-placement="bottom" ' : ''; 
        $dataColumn->required = self::isTrue($dataColumn->required);
        $dataColumn->classes = explode(' ', $dataColumn->class);
//        $dataColumn->hidden = false;
//        $dataColumn->hiddenLabel = true;
        $dataColumn->text = $dataColumn->text ?? $dataColumn->label;
//toPrint($dataColumn->hiddenLabel,'$dataColumn->hiddenLabel');		
//toPrint($dataColumn->text,'$dataColumn->text');	
//toPrint( $dataColumn->class,' $dataColumn->class '.$this->name);
//        $dataColumn->hidden = false;
        $dataColumn->for = $dataColumn->for ?? $dataColumn->id;
        $dataColumn->dataAttributes = [];
        $dataColumn->dataAttribute = '';
		
		
		$dataColumn->default = empty($dataColumn->value) && $dataColumn->default && $dataColumn->translateDefault ? JText::_($dataColumn->default) : $dataColumn->default;
        $dataColumn->html = $dataColumn->value ?: $dataColumn->default;
        
        $alt = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $dataColumn->fieldname);
        
        $dataColumn->hint = self::isTrue($dataColumn->translateHint) ? JText::alt($dataColumn->hint, $alt) : $dataColumn->hint;
		
        if($name != -1){
            $this->columns[$name] = $dataColumn;
			$dataColumn->name = $name;
			$dataColumn->fieldname = $name;
		}
        elseif($dataColumn->name){
            $this->columns[$dataColumn->name] = $dataColumn;
			$name = $dataColumn->name;
		}
        else{
			$dataColumn->rand = rand();
            $this->columns[] = $dataColumn;
			$name = array_search($dataColumn, $this->columns);
//			$dataColumn->fieldname = $name;
			$dataColumn->name = $name;
			$dataColumn->fieldname = $name;
		}
		

		$dataColumn->fieldname = $name;
        $dataColumn->label = $dataColumn->label ?: ucwords($dataColumn->fieldname) ?? '';
		
		
        $dataColumn->translateLabel = isset($dataColumn->translateLabel) ? 
				self::isTrue($dataColumn->translateLabel) : self::isTrue($dataColumn->translate_label);
 
        
		$dataColumn->label = $dataColumn->translateLabel ? JText::_($dataColumn->label) : $dataColumn->label;
//		$dataColumn->label .= (JFactory::getApplication()->getLanguage()->hasKey($dataColumn->label)?' Есть':' Нет');
        
        $dataColumn->translateDescription = isset($dataColumn->translateDescription) ? 
				self::isTrue($dataColumn->translateDescription) : self::isTrue($dataColumn->translate_description);
		
        if($dataColumn->description && $dataColumn->translateDescription)
            $dataColumn->description = \JText::_($dataColumn->description);
		
        $dataColumn->translateDefault = isset($dataColumn->translateDefault) ?
				self::isTrue($dataColumn->translateDefault) : self::isTrue($dataColumn->translate_default);
		
//toPrint('getControl();   key:'.$name.'; col->name:'.$dataColumn->fieldname);
//var_dump($name);
//toPrint($dataColumn,'$dataColumn');
//toPrint($name,(string)count($this->columns));
//toPrint($name);
//toPrint(array_keys($this->columns));
//toPrint($dataColumn->name);
		
		
        return $name;
    }

    /**
     * 
     * @param object|array $dataRow object with data rows, where property is names columns
     * @param string|int|bool $key key for position in array data values, Default -1 where element will be last position
	 * @return  int return index in array columns
     */
    public function addRow($dataRow, $key = true) {
		
		if(is_object($dataRow))
			$dataRow = get_object_vars($dataRow);
		
        if($key === true){ //Определение максимального ключа массивов из всех колонок
//            foreach ($this->columns as $column){
//                foreach (array_keys($column) as $k){
//                    if(is_int($k) && $max_count < $k){						
//                        $key = $k;
//                    }
//                }
//            }
//toPrint($this->value);
//toPrint($this->columns);
//toPrint($dataRow,'',0);
			
            foreach (array_keys($this->columns) as  $column){
				if(! isset($this->value[$column]))
					$this->value[$column] = [];
				$keys = array_keys(($this->value[$column]?:[]));
				$keys[] = -1;
//toPrint($keys,'$keys',0);
				$max_key = max($keys);
				$key = $max_key;
//toPrint(($this->value[$column]),'array_keys($this->value[$column]',0);
//toPrint('$max_key:'.$max_key.' $key:'.$key);
                foreach (array_keys($this->value[$column]) as $k){
                    if(is_int($k) && $key == $k){
                        $key = $k + 1;
                    }
                    if(is_int($k) && $key < $k){						
                        $key = $k;
                    }
                }
				if($key == $max_key)
					$key ++;
            }
        }
        
        foreach($this->columns as $column){
            $name = $column->name;
            if(empty($dataRow))
                unset ($this->value[$name][$key]);
//            if(isset($dataRow[$column->name]))
			else
                $this->value[$name][$key] = $dataRow[$column->name] ?? '';
        }
        
        return $key;
    }
	
	
	/**
	 * <strike>In development</strike>
	 * @param type $name 
	 * @deprecated 4.0 In development
	 */
	public function getColumn($name) {
	} 
	
	/**
	 * <strike>In development</strike>
	 * @param type $index
	 * @param type $onlyValue
	 * @deprecated 4.0 In development
	 */
	public function getRow($index, $onlyValue) {
	}
	
	
	/**
	 *  <strike>In development</strike>
	 * @param type $rows
	 * @deprecated 4.0 In development
	 */
	public function addRows($rows) {
	} 
	
    /**
     * Remove Column 
     * @param string $namefield  
     */
    public function removeColumn($namefield) { 
        unset($this->columns[$namefield]); 
    }
    /**
     * Remove Row 
     * @param string $namefield  
     */
    public function removeRow($rowIndex) { 
        
        foreach($this->value as $name => $column){
			unset ($this->value[$name][$rowIndex]);
        }
    }
     
	
    /**
     *  Return array field names
	 * @return  array Array string name field columns
     */
	public function getNamesColumns(){
		return array_keys($this->columns);
	}
	
    /**
	 * Метод получения данных FIELD для  макета для рендеринга. 
	 * @param   string|SimpleXMLElement  $Element Type field or Load data from $Element.
	 * <pre>
	 * <b> <field name="fieldname" label="Label" type="text" />  </b>
	 * </pre>
	 * @param   mixed  $value  The form to attach to the form field object.
	 * @param   object|array  $data  The form to attach to the form field object.
	 * <pre> 
	 * <b>['name'=>'fieldname', 'label'=>'', 'type'=>'text',]</b>
	 * </pre>
	 *
	 * @return  JFormField
	 */
	public static function createField( $Element = null, $value = null, $data = [],$deb = false){
//		  $data->value = $data->value ?: (string)$XMLElement['value'];
//        $data->default = $data->default ?: (string)$XMLElement['default'];
//        $data->translateLabel = (bool) ($XMLElement['translateLabel'] ??  true);
//        $data->translateDescription = (bool) ($XMLElement['translateDescription'] ??  true);
		
//toPrint($Element ,'$Element ',0 ); return null;
		
//toPrint($Element,'$Element');
//toPrint($value,'$value');
//return null;
		
//toPrint($value);
//toPrint($column);
//toPrint($Element,'$type');
//return null;
//toPrint(get_class($data),'$data',0,'pre'); 
		$data = $data ?? [] ;
		$data = is_array($data) ? $data : get_object_vars($data);
		
		$type = '';
		$translateDefault = false;
		$default = ''; 
		

		
		if(is_string($Element)){
//if($deb)toPrint(htmlspecialchars($Element));
			$Element = trim($Element);
			if(str_starts_with($Element, '<') && str_ends_with($Element, '>')){ //strpos($Element, '<') === 0
				$xml = simplexml_load_string($Element); //addslashes htmlspecialchars 
				if(empty($xml))
					JFactory::getApplication ()->enqueueMessage ('Error XML in Field GridFields::createField($xml):<pre>'.htmlspecialchars($Element).'</pre>'
							,Joomla\CMS\Application\CMSApplicationInterface::MSG_ERROR);
				$Element = $xml; 

//if($deb)toPrint(htmlspecialchars($Element));
			}else{
				$type = $Element;
				$Element = simplexml_load_string("<field type=\"$type\"/>");
				if(empty($Element))
					JFactory::getApplication ()->enqueueMessage ('Error TYPE in Field GridFields::createField($type):<pre>'.htmlspecialchars($type).'</pre>'
							, Joomla\CMS\Application\CMSApplicationInterface::MSG_ERROR);
//if($deb)toPrint(htmlspecialchars($Element));
			}
				
//			$Element = new SimpleXMLElement($Element);
//			$xml = new \DOMDocument('1.0', 'UTF-8'); 
//			$xml->loadXML($source);
//			$xml->saveXML();
		}
//toPrint($Element ,'$Element ',0 ); return null;
		if($Element instanceof \SimpleXMLElement){
			$type = (string)$Element['type'] ?: 'text';
			$translateDefault = static::isTrue($Element['translateDefault']?: false);
			$default = $Element['default'] ?: '';
			$value = $value ?? $data['value'] ?? (string)$Element['value'] ?? null;
		} 
		

		if(empty($Element))
			return false;
		
//toPrint($type ,'$type ',0,'pre'); return null;
//		if(empty($Element)){
//            return null;
//        }
		if(empty($type) && isset($data['type']) && $data['type'])
			$type = $data['type'];
			
		if($type)
			$field = JFormHelper::loadFieldType($type);				// <<<<<<<<<<<<<<<<<<<<<<<
		else
			$field = JFormHelper::loadFieldType('text');			// <<<<<<<<<<<<<<<<<<<<<<<
		
		if(empty($field))
			$field = JFormHelper::loadFieldType('text');			// <<<<<<<<<<<<<<<<<<<<<<<
		
		
//toPrint( $field->name);
		$field = static::getDefaultData($field);
//toPrint( $field);
		
		
		$field->translateDefault = isset($data['translateDefault']) ? static::isTrue($data['translateDefault']) :  $field->translateDefault; 
		if(is_null($value))
			$value = $field->translateDefault && $default ? JText::_($default) : (string)$default;
		
		
		
//toPrint($value ,'$value ',0,'pre');
//toPrint($Element ,'$Element ',0,'pre');
        if($Element){
			if(ucfirst($type) == 'Checkbox'){
				$default = (string)$Element['default'] ?? '';//Костыль для Checkbox
				unset($Element['default']);
				$value = $default;
			}
//			$field->setForm($this->form);
            $field->setup($Element, $value);
//				$field->default = $default;
//toPrint( $Element);
//toPrint((string)$Element['class'],$field->fieldname,0,$field->fieldname=='idField');
//toPrint($field->class,$field->fieldname,0,$field->fieldname=='idField');
//toPrint($dataColumn->hiddenLabel,'$dataColumn->hiddenLabel');		
//toPrint($field->label,'$field->label');
//toPrint($Element['label'],'$field->label');

			if($Element['format'])
				$field->format = (string)$Element['format'];
			if($Element->format)
				$field->format = (string)$Element->printf;
			if($Element['printf'])
				$field->printf = (string)$Element['printf'];
			if($Element->printf)
				$field->printf = (string)$Element->printf;
//			$options = $Element->xpath('option');
//			$field->countOptions = $options ? count($Element->xpath('option')) : 0;
//			$field->countOptions = count($Element->xpath('option'));
			
        } 
//        $field->html = $field->value ?: $value;
		
//toPrint($dataColumn->hiddenLabel,'$dataColumn->hiddenLabel');		
//toPrint($field->label,'$field->label');
//toPrint($value ,'$value ',0,'pre');
//toPrint($field ,'$field ',0,'pre');
		
		if($Element instanceof SimpleXMLElement){
        foreach($Element->attributes() as $attr => $val){
            $field->$attr = (string)$val;
            $attr = static::attributeToHungarianNotation($attr);
			$field->$attr = (string)$val;
		}}
		if(is_array($Element)){
        foreach($Element as $attr => $val){
            $attr = static::attributeToHungarianNotation($attr);
            $field->$attr = (string)$val;
		}}
//toPrint($field->rows,'$field->rows',0,'pre'); 
        foreach ((array)$data as $attr => $val) {
			if($attr == 'value')
				continue;
            $attr = static::attributeToHungarianNotation($attr);
				$field->__set($attr, $val);// Перепроверить.!!!
//			toPrint($val,$prop);
//            if(in_array($prop, ['classes','labelclasses']))
//                continue;
//			if($prop == 'value') 
//				continue;
//            $attr = static::attributeToHungarianNotation($attr);
//            $field->$prop = $val;   // Перепроверить.!!!
        }
		
		if(isset($data['name']))
			$field->name = $data['name'];
		
//toPrint($field->value, '$field->value:'.$field->name, 0);
//toPrint($field->checked, '$field->checked:'.$field->name, 0);
		
		$field->translateLabel = isset($data['translateLabel']) ? static::isTrue($data['translateLabel']) :  $field->translateLabel; 
		$field->label = $field->translateLabel && $field->label ? JText::_($field->label) : $field->label;
		
		$field->translateDescription = isset($data['translateDescription']) ? static::isTrue($data['translateDescription']) :  $field->translateDescription; 
		$field->description = $field->translateDescription && $field->description ? JText::_($field->description) : $field->description;
//toPrint($data['rows'],'$data[rows]',0,'pre'); 
		
//		$field->translateLabel = isset($data['translateLabel']) ? static::isTrue($data['translateLabel']) :  $field->translateLabel; 
//		$field->translateLabel = $data['translate_label'] ? static::isTrue($data['translate_label']) :  $field->translateLabel; 
		
//		$field->translateDescription = isset($data['translateDescription']) ? static::isTrue($data['translateDescription']) :  $field->translateDescription; 
//		$field->translateDescription = $data['translate_description'] ? static::isTrue($data['translate_description']) :  $field->translateDescription; 
        
		$field->classes = explode(' ', $field->class);
        $field->text = $field->label;
        $field->for = $field->id; 
        $alt = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $field->fieldname); 
        $field->hint = $field->translateHint ? JText::alt($field->hint, $alt) : $field->hint;
 
//return null; 
		
//toPrint($Element);
//toPrint($field);
//return null;
         
		
		
//toPrint($field,'$data',0,'pre',true);
//if($type=='radio')
//toPrint($data['id'],'FIELD data-id',0,'pre');
//toPrint((array)$data,'$data',0,'pre');
//try {
		
        return $field;  
            [ 'element','field','group','repeat','type','value','dataAttribute','dataAttributes','text','for','classes','classCell','classHeader','position',
            'fieldname','sortable', ];
            [ 'element','field','group','repeat',                                               'text','for','classes','classCell','classHeader','position',
            'fieldname','sortable',  ];
	} 
 
    
    public static function attributeToHungarianNotation($attributeName) {
        
        $pos1 = strpos($attributeName, '_');
        $pos2 = strpos($attributeName, '-');
        if(empty($pos1) && empty($pos2))
            return $attributeName;
        
        if($pos1){ 
            $as = explode('_', $attributeName);
            $as = array_map(function($a){return ucfirst(strtolower($a));},$as);
            $attributeName = join('', $as);
        }
        if($pos2){ 
            $as = explode('-', $attributeName);
            $as = array_map(function($a){return ucfirst(strtolower($a));},$as);
            $attributeName = join('', $as);
        }
        return lcfirst($attributeName);
    }
	
	/**
	 * 
	 * @param bool|string|int $var
	 * @return bool
	 */
	public static function isTrue($var = ''):bool{
//		return false == in_array($var, ['0', '', false, 'false', 'FALSE', ' ', 'off', null]);
		return ($var === ''				|| $var === '0' || $var === 0 || $var === null || //|| $var === ' '	
				$var === 'false'	|| $var === 'False' || $var === 'FALSE' || 
				$var === 'off'		|| $var === 'Off'	|| $var === 'OFF'	||
				$var === 'disabled'	|| $var === 'Disabled'|| $var === 'DISABLED'||
				$var === 'disable'	|| $var === 'Disable'|| $var === 'DISABLE'||
				$var === 'none'		|| $var === 'None'	|| $var === 'NONE'||
				$var === 'no'		|| $var === 'No'	|| $var === 'NO'
				) == false;
	}
	
	public static function getDefaultData($data = []){
		      
        $atributes = [
            'autocomplete','autofocus','class','description','default','disabled',
            'element','field','group','hidden','hint',
            'id','label','labelclass','multiple','showon','rows',
            'name','onchange','onclick','pattern','validationtext','readonly','repeat','required','size','spellcheck',
            'type','validate', 'text','dataAttribute','dataAttributes', // 'value',
            'text','for','classes','classCell','classHeader','position', 'parentclass',
            'fieldname','translateLabel','translateDescription','translateHint', 'translateDefault',
            'sortable', 'norender',
            'creatable','movable','removable',
            'style','styleHeader','styleCell', 
			'input',
//            'translate_label', 'translate_description', 'translate_default', 
            ];
		
		
        $d = (object)array_fill_keys($atributes, '');
		
        $d->hidden = true;
        $d->norender = false;
        $d->translateLabel = true;
        $d->translateDescription = true;
        $d->translateDefault = false; 
        $d->class = ' form-control-sm form-select-sm ';
        $d->type = 'text';
		$d->rows = 1;
        $d->renderLabelLayout = 'joomla.form.renderlabel';
        $d->dataAttributes = [];
        $d->dataAttribute = ''; 
		
		
		if($data && is_array($data)){
			foreach ($atributes as $attr){
				if(isset($data[$attr]))
					$d->$attr = $data[$attr];
			}
			$data = $d;
		}elseif($data && $data instanceof SimpleXMLElement){
			foreach ($atributes as $attr){
				if(isset($data[$attr]))
					$d->$attr = (string)$data[$attr];
			}
			$data = $d;
		}elseif($data && is_object ($data)){
			foreach ($atributes as $attr){
				if(! isset($data->$attr))
					$data->$attr = $d->$attr;
			}
		}else{
			$data = $d;
		}
		
        if(empty($data->label))
            $data->label = $data->name;
		
		
		$data->class .= ucwords($data->type)  == 'Radio' ? ' btn-group-sm ' : '';
        $data->position = $data->name == 'alias' ? ' data-placement="bottom" ' : '';
		
		$data->translateLabel = static::isTrue($data->translateLabel);
		$translate_label =  isset($data->translate_label) ? static::isTrue($data->translate_label): false;
		$data->translateLabel = $data->translateLabel || $translate_label;
        
		$data->translateDescription = static::isTrue($data->translateDescription);
		$translate_description =  isset($data->translate_description) ? static::isTrue($data->translate_description): false;
		$data->translateDescription = $data->translateDescription || $translate_description;
		
		
		return $data;
	}
	
	/**
	 * Метод для рендеринга атрибутов данных в html.
	 *
	 * @return  string  A HTML Tag Attribute string of data attribute(s)
	 *
	 * @since  4.0.0
	 */
	public function renderDataAttributes(){
        
        $dataAttributes = [];
        if(method_exists($this, 'getDataAttributes')){
            $dataAttributes = $this->getDataAttributes();
        }
        
		$dataAttribute  = '';

		if (!empty($dataAttributes))
		{
			foreach ($dataAttributes as $key => $attrValue)
			{
				$dataAttribute .= ' ' . $key . '="' . htmlspecialchars($attrValue, ENT_COMPAT, 'UTF-8') . '"';
			}
		}

		return $dataAttribute;
	} 
    
	 
	/**
	 * Method to get the custom field options.
	 * Use the query attribute to supply a query to generate the list.
	 *
	 * @return  array  The field option objects. 
	 * @since   1.7.0
	 */
	protected function getOptions()
	{
		$options = array();

		// Initialize some field attributes.
//		$key   = $this->keyField;
//		$value = $this->valueField;
		$header = $this->header;
		$items = [];

		if ($this->query)
		{
			// Get the database object.
			$db = JFactory::getDbo();

			// Set the query and get the result list.
			$db->setQuery($this->query);

			try
			{
				$items += $db->loadObjectList();//loadObjectList('id'); ??
			}
			catch (ExecutionFailureException $e)
			{
				JFactory::getApplication()->enqueueMessage(JText::printf('JLIB_DATABASE_QUERY_FAILED',$e->getCode()), 'error');
			}
		}
		
		if($this->defaultSql)
		{
			// Get the database object.
			$db = JFactory::getDbo();

			// Set the query and get the result list.
			$db->setQuery($this->defaultSql);

			try
			{
				$items += $db->loadObjectList();//loadObjectList('id'); ??
			}
			catch (ExecutionFailureException $e)
			{
				JFactory::getApplication()->enqueueMessage(JText::printf('JLIB_DATABASE_QUERY_FAILED',$e->getCode()), 'error');
			}
		}
		
		if($this->sql)
		{
			// Get the database object.
			$db = JFactory::getDbo();

			// Set the query and get the result list.
			$db->setQuery($this->sql);

			try
			{
				$items += $db->loadObjectList();//loadObjectList('id'); ??
			}
			catch (ExecutionFailureException $e)
			{
				JFactory::getApplication()->enqueueMessage(JText::printf('JLIB_DATABASE_QUERY_FAILED',$e->getCode()), 'error');
			}
		}
		
		return $items;
		
// -------------------------------------------------------------------------------
		// Add header.
		if (!empty($header))
		{
			$header_title = JText::_($header);
			$options[] = JHtml::_('select.option', '', $header_title);
		}

		// Build the field options.
		if (!empty($items))
		{
			foreach ($items as $item)
			{
				if ($this->translate == true)
				{
					$options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
				}
				else
				{
					$options[] = JHtml::_('select.option', $item->$key, $item->$value);
				}
			}
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
 
		
        return []; 
        
//        $opts = []; 
//        $options = []; 
//        
//        $opts['*']= ['*', '- - '.JText::_('JALL_LANGUAGE'). ": ★ " , '✔ - -'];//JHtml ✔
//                   
//        foreach (Joomla\CMS\Language\LanguageHelper::getKnownLanguages() as $opt){ //4
//            $opts[$opt['tag']]= [$opt['tag'], "$opt[nativeName]: $opt[tag]" , ' ◯'];//JHtml ✔
//        } 
//        foreach (Joomla\CMS\Language\LanguageHelper::getContentLanguages() as $opt){//3
//            //$options[$opt->lang_code] .= $opt->published
//            $opts[$opt->lang_code]= [$opt->lang_code, "$opt->title: $opt->lang_code", $opt->published?'✔':'◯'];//JHtml
//        } 
//        
//        foreach($opts as $opt){            
//            $options[$opt[0]]= JHtml::_('select.option', $opt[0], "$opt[1]: $opt[2]");//JHtml ✔✔✔✓✔
//        }
//        
//toPrint($ops,'$ops',0, true, true);    
//
//	 
//        $options = array_merge($options,parent::getOptions() );
//        
//        return $options;
        
    }

     
	/**
	 * Simple method to get the value
	 *
	 * @return  array
	 *
	 * @since   3.2
	 */
	public function getValue()
	{
		return $this->value;
	}
	
	
	/**
	 * Simple method to set the value
	 *
	 * @param   mixed  $value  Value to set
	 *
	 * @return  void
	 *
	 * @since   3.2
	 */
	public function setValue($value)
	{
		$value = (array)$value;
		
		if(is_string($value)){
			$value = (array)json_decode($value);
		}
		
//		foreach($this->columns as $name => $column)
//			if(is_object($column))
//				$value[$name] = (array) $value[$name];
		
		parent::setValue($value);
	}
    
	/**
	 * Метод получения разметки метки поля.
	 *
	 * @return  string  Разметка метки поля.
	 *
	 * @since   1.7.0
	 */
	protected function getLabel()
	{ 
		
        return '';
        
        
		if ($this->hidden)
		{
			return '';
		}

		$data = $this->getLayoutData();

		// Forcing the Alias field to display the tip below
		$position = isset($this->element['name']) && $this->element['name'] == 'alias' ? ' data-placement="bottom" ' : '';

		// Here mainly for B/C with old layouts. This can be done in the layouts directly
		$extraData = array(
			'text'        => $data['label'],
			'for'         => $this->id,
			'classes'     => explode(' ', $data['class']),
			'labelclasses'=> explode(' ', $data['labelclass']),
			'position'    => $position,
		);

        
		return $this->getRenderer($this->renderLabelLayout)->render(array_merge($data, $extraData));
         
    }
    
	
	
    
    
    /**
	 * Метод получения данных FIELD для  макета для рендеринга. 
     * 
	 * @param   object  $field  The form to attach to the form field object.
	 *
	 * @return  array
	 *
	 * @since 3.5
	 */
  protected function getLayoutData(){
         

	  if(empty($this->id))
		  $this->id = $this->fieldname;
	  
	  if(empty($this->id))
		  $this->id = str_replace(['][','[',']','-','-'], '_', $this->name);

//toPrint($this->id,'$this->id',0,'message');
//toPrint($this->fieldname,'$this->fieldname',0,'message');
//toPrint($this->name,'$this->name',0,'message');
//toPrint(strtolower($this->fontIcon),'strtolower($this->fontIcon)',0,'pre');
//toPrint($this,'$this',0,'pre');
//toPrint($this->label,'$this->label',0,'pre'); 
//toPrint($label,'$label',0,'pre',TRUE);
		$this->translateLabel = true;
             
		if(isset($this->element['translate_label']))
			$this->translateLabel = (bool)$this->element['translate_label'];
		
		if(isset($this->element['translateLabel']))
			$this->translateLabel = (bool)$this->element['translateLabel'];
//		toPrint($this->element['label'], 
//				' type:' .  ((string)$this->element['type']), 0, 'message', true); 
            $label = '';// $this->getTitle();

		 
//	  reset($this->element->attributes());
		$label =(isset($this->element['label']) && $this->element['label'])  ? (string) $this->element['label'] : ((isset($this->element['name']) && $this->element['name']) ? (string) $this->element['name']:''); 
		$label = $this->translateLabel ? JText::_($label) : $label; 
 
//toPrint($label,'$label',0,'pre',TRUE);	
			//
			//
//            $label = $this->translateLabel ? JText::_($label) : $label;
//      $label = '';
            $description = $this->description ?: (isset($this->element['description']) ?(string)$this->element['description']: (isset($this->element->description)  ?$this->element->description: ''));
            
            $this->translateDescription = (isset($this->element['translate_description']) && (bool)$this->element['translate_description'])
                                        || (isset($this->element['translateDescription']) && (bool)$this->element['translateDescription']);
             
            
            $description = $description && $this->translateDescription ? JText::_($description) : $description;
            

            
            $this->translateCaption = true;
			
					
			if(isset($this->element['translate_caption']))
				$this->translateCaption = (bool)$this->element['translate_caption'];
					
			if(isset($this->element->caption['translate_caption']))
				$this->translateCaption = (bool)$this->element->caption['translate_caption'];
			
			if(isset($this->element->caption['translate']))
				$this->translateCaption = (bool)$this->element->caption['translate'];
					
			if(isset($this->element['translateCaption']))
				$this->translateCaption = (bool)$this->element['translateCaption']; 
			
			if(isset($this->element->caption['translateCaption']))
				$this->translateCaption = (bool)$this->element->caption['translateCaption'];
            
            $caption = $this->caption ?: (isset($this->element['caption']) ?(string)$this->element['caption']: (isset($this->element->caption)  ?(string) $this->element->caption : ($label ?: '')));
            
            $caption = $caption && $this->translateCaption ? JText::_($caption) : $caption;
            
            
            $alt = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname);   
            
            $position = isset($this->element['name']) && (string)$this->element['name'] == 'alias' ? ' data-placement="bottom" ' : '';
            
		
//toPrint($this->element['label'],'$this->element[label]',0,'pre',TRUE);
//$label = $this->element['label'] ? ((string)$this->element['label']) : ((string) $this->element['name']);
//$label = $this->element['label'] ? settype($this->element['label'], "string")  :settype($this->element['name'], "string")  ;
//toPrint($this->element,'$this->element',0,'pre',TRUE);
            $data = parent::getLayoutData(); 
                
            $data['description'   ] = $description;
            $data['label'         ] = $label;
            $data['type'          ] = $this->type;
            $data['dataAttribute' ] = $this->renderDataAttributes();
            $data['dataAttributes'] = $this->dataAttributes;
            $data['text']        = $label;
            $data['for']         = $this->id;
//          $data  'classes'     = explode(' '; $this->labelclass);
            $data['position']    = $position;
            
            $data['hint']          = isset($data['translateHint']) && $data['translateHint'] ? JText::alt($data['hint'], $alt) : $data['hint'];
            $data['creatableClass']= $this->creatableClass;
            $data['movableClass'  ]= $this->movableClass;
            $data['script'        ]= $this->script;
            $data['css'           ]= $this->css;
            $data['style'         ]= $this->style;
            
            $data['fontIcon'      ]= (strtolower($this->fontIcon)=='icomoon') ? 'icon-' : (in_array(strtolower($this->fontIcon), ['fontawesome','awesome'])?'fa':' ');//IcoMoon || FontAwesome
            
            $data['captionExpander'] = $this->captionExpander;
            $data['captionExpanded'] = (bool)($this->captionExpander && $description);
            $data['caption'  ] = ($this->translateLabel || $this->translateCaption)? JText::_($caption) : $caption;
            $data['creatable'] = (bool) ($this->creatable ?? true);
            $data['movable'  ] = (bool) ($this->movable   ?? true);
            $data['removable'] = (bool) ($this->removable ?? true); 
            
            $data['isJ4' ]= $this->isJ4;
            
            
            return $data;

 
    }
    
	/**
	 * 
	 * @return array 
	 */
    public function getLayoutColumns(){
        
        $columnsField = [];
		
//toPrint($Element);
//toPrint($this->columns,'$this->columns',0);
//return [];
        
//toPrint($this->name,'$this->name',0,'pre');
        foreach ($this->columns as $name => $column){
//toPrint($column->fieldname.' '.$name,'getLayoutColumns() $column->fieldname');
			

			
            if ($column->default && static::isTrue($column->translateDefault)){
                $lang = JFactory::getLanguage();

                if ($lang->hasKey($column->default)){
                    $debug = $lang->setDebug(false);
                    $column->default = JText::_($column->default);
                    $lang->setDebug($debug);
                }
                else{
                    $column->default = JText::_($column->default);
                }
            }
           

			
//            if(empty($column->name) && empty($column->element['name'])){
//                $column->name = $column->type;
//                $column->fieldname = $column->type;
//            }
//            if(empty($column->value))
//                unset ($column->value);
            
            
//toPrint($this->name,'$this->name',0,'pre');
//toPrint($column->name,'$column->name',0,'pre');
//				$column->id			= $this->id. '_'.$column->name. '_';
//				$column->fieldname	= $column->name;
//				$column->row		= '';
//				$column->description= '';
//if($column->type=='radio')            
//toPrint(array_merge([],(array)$column, $param),'$column',0,'pre');
//if($column->type=='radio')            
//toPrint($column->element,'$column->element',0,'pre');
//            unset($column->classes);
            if($column instanceof JFormField){
				
				$column->id        =$this->id. '_'.$column->fieldname. '_';
//				$column->fieldname = $column->name??'';
//				$column->name  =$this->name.'['.$column->name.'][]';
                $column->row   = '';
				$column->rows = 1;
//                $column->description='';
				$column->label = $column->translateLabel ? JText::_($column->getLabel()): $column->getLabel();
//				array_walk($param , function($val,$prop,$column){ 
//					toPrint($val,$prop);
//					$column->__set($prop,$val);
//					$column->$prop = $val;
//				},$column);
				
//echo "<pre>hidden:".print_r($field->hidden,true)." --- translateLabel:".print_r($field->translateLabel,true)." --- Label:".print_r(htmlspecialchars ($field->label),true).".</pre>"; //'123 '.
//echo "<pre>!"  .print_r( ($field->getLabel()),true).".</pre>"; //'123 '. htmlspecialchars (string)
//JFactory::getApplication()->enqueueMessage($type);
//toPrint($data->class,'$data->class',0,'pre',true);
//echo "<pre> $type ".print_r($field->label,true)." --- ".print_r(htmlspecialchars ($Element->asXML()),true)."</pre>";
				$columnsField[$column->fieldname] = $column;
//toPrint($column->fieldname,'getLayoutColumns() $column->fieldname' ); 
				
			}else{
				
				$column->id = $this->id. '_'.$column->name. '_';
				$column->fieldname = $column->name??'';
				$column->label =  $column->translateLabel ? JText::_($column->label): $column->label;
				$column->row = '+';
				$column->rows = 1;
//				$column->description = '';
//				$column->name = $column->name;
//				$column->name = $this->name.'['.$column->fieldname.'][]';
				
				

				$columnsField[$column->fieldname] = static::createField($column->element, $column->default, $column);
				
				
//toPrint($column->fieldname,'getLayoutColumns() $column->fieldname' ); 
			}
			
			
            $columnsField[$column->fieldname]->fieldname = $column->name;
            $columnsField[$column->fieldname]->name = $this->name.'['.$column->fieldname.'][]';
			
			
			if(ucwords($columnsField[$column->fieldname]->type)== 'Radio' && $columnsField[$column->fieldname]->countOptions === false){
				$columnsField[$column->fieldname]->countOptions = count($columnsField[$column->fieldname]->element->xpath('option'));
				if($columnsField[$column->fieldname]->countOptions === 0){
					$columnsField[$column->fieldname]->name = "{$this->name}[{$column->fieldname}]";
					$columnsField[$column->fieldname]->addOption(" &#10003; ",['value'=>'', 'xclass'=>'', 'class'=>'btn btn-outline-success fw-bold']);//'class'=>'btn btn-outline-success      btn-check  fa fa-check' &#10003; &#10004;
// // ✓ ✓   &#10003; 🗸 &#128504;               ✔✔✔✓✔  &#10004; &#10003; &#128504; ✓   🗸 ⍻ √  class="form-check-input"
//						$columnsField[$column->name]->value = '';
//						$columnsField[$column->name]->default = '';
				}
			}
//toPrint($columnsField[$column->fieldname]->name,'$column->fieldname',0,'pre');
			
			//toPrint($value,' $value:'.$key.' ',0,'pre'); //						checked
	 
					 
//toPrint($column->countOptions,'$column->countOptions');
				 
//				$column->countOptions;
//toPrint(gettype($column->countOptions),'$column->countOptions');
			
			
//toPrint($columnsField[$column->name]    ,'$column');
//toPrint( $columnsField[$column->name]->name    ,'name');
//toPrint(get_class_methods($columnsField[$column->name])   ,'get_class_methods($column)');
//toPrint($columnsField[$column->name]->label,'$column->label',0,'pre');
//toPrint($column->name,'$column->name',0,'pre');
//toPrint($column instanceof JFormField,'$column');
//toPrint(get_class($columnsField[$column->name]),'$columnsField[$column->name]');
            
		
			
//if($column->type=='radio')            
//toPrint($columnsField[$column->name],'$columnField',0,'pre'); 
//            $this->value = $this->getValue((string) $this->element['name'], $group, $default);
        }
//toPrint(array_keys($this->columns));	
//toPrint(array_keys($columnsField),'getLayoutColumns() array_keys($columnsField)' ); 
//toPrint('key:'.$name,'Col->name:'.$col->name);	
//return [];
        return $columnsField;
    }
    
    public function getLayoutFields() {
//toPrint(JFactory::getApplication()->getInput()->getRaw('jform'));//jform[params][list_currencies][default_cur][]
		
		
        $keys_rows = [];
		$defaults = [];
		
		$options = $this->getOptions();
		
		$keys_rows += array_keys($options);
		
		foreach ($keys_rows as $key){
			foreach ($options[$key] as $col_name => $cell){
				$defaults[$col_name][$key] = $cell;
			}
		}
		//-------------------------------------------
		
//toPrint($this->value,'$this->value',0,'pre');
        
        $this->value;
//        $data = [];
        $fields = [];
         
		try {
			if(is_object($this->value))
				$this->value = (array)$this->value;
			if(is_null($this->value))
				$this->value = [];
			if (is_string($this->value))
				$this->value = (array)json_decode($this->value);
			if(! is_array($this->value) || empty($this->value))
				$this->value = [];
		} catch (Exception $exc) {
//			echo $exc->getTraceAsString();
			$this->error .= "<br> Error decode JSON for Default value";
			$this->value = [];
		}
		
		//-------------------------------------------
//toPrint($this->value,'$this->value',0,'pre');
//return [];
//toPrint($this->columns,'$this->columns',1,'pre'); 
//toPrint('$val FIELDS -----------------------!','',0,'pre');
        
        foreach ((array)$this->value as $i => $column){
			if(is_object($column))
				$this->value[$i] = (array)$column;
			if(is_array($column)) 
				$keys_rows += array_keys ($column);
		}
        
        $keys_rows = array_unique($keys_rows);
//        sort($keys_rows);
//toPrint($keys_rows,'$value  ',0,'pre',true);


//toPrint(array_keys($this->columns),'array_keys($this->columns]',0,'pre'); 
//toPrint($defaults, '$defaults',0);
//toPrint($keys_rows, '$keys_rows',0);
//toPrint($this->value, '$this->value',0);
        foreach ($this->columns as $column){
            $name = $column->fieldname;
//toPrint($name,'$val',0,'pre');
//            $colData = $value[$name];
            if(isset($this->value[$column->fieldname]) && is_scalar($this->value[$column->fieldname])){
				$column->default = $this->value[$column->fieldname] ?? '';
//toPrint($this->name,'$column->default:'.$column->default,0,'pre');
			}
            if(ucwords($column->type)== 'Radio' && $column->countOptions === 0 
			&& isset($this->value[$column->fieldname]) && is_array($this->value[$column->fieldname])){
				$column->default = array_search(true, $this->value[$column->fieldname],false) ?? '';
//toPrint($this->value[$column->fieldname],'$column->default:'.$column->default,0,'pre');
			}
            if(ucwords($column->type)== 'Checkbox' 
					&& empty($column->value) 
					&& empty($column->default))
				$column->default = false;//$this->value[$column->fieldname]; //empty($value) && empty($column->value) && empty($column->default)
			
//toPrint( ($this->value[$column->fieldname]), '  $this->value[$column->fieldname] ',0,$column->type=='Checkbox');
//if(ucwords($column->type)== 'Radio' && $column->countOptions === 0){
////	$column->default  
//toPrint(array_keys($this->value),'array_keys($this->value[$column->fieldname]',0,'pre'); //[$column->fieldname]
//}
			
//toPrint($this->value,'$this->value',0,'message');
//if(is_object($this->value[$column->fieldname])){
//	toPrint($this->value,'$this->value fieldName:'.$column->fieldname.' key:'.$key,0,'message');
//	return [];
//}
            foreach ($keys_rows as $key){
				if(isset($this->value[$column->fieldname][$key])) 
					$value = $column->translateDefault ? JText::_($this->value[$column->fieldname][$key]) : $this->value[$column->fieldname][$key];
//				elseif(isset($this->value[$column->fieldname]) && is_scalar($this->value[$column->fieldname]))
//					$value = $this->value[$column->fieldname];
                elseif(isset($defaults[$column->fieldname][$key]))
					$value = $column->translateDefault ? JText::_($defaults[$column->fieldname][$key]) : $defaults[$column->fieldname][$key];
//				elseif(isset($defaults[$column->fieldname]) && is_scalar($defaults[$column->fieldname]))
//					$value = $defaults[$column->fieldname];
				else
					$value = $column->translateDefault ? JText::_((string)$column->default) : (string)$column->default;
					
//toPrint($this->value[$column->fieldname][$key],' $value',0, $column->fieldname == 'select' );
//toPrint($column->translateDefault,' translateDefault',0, $column->fieldname == 'select' );
				
				 if(empty($value) && $column->format && isset($options[$key]))
					 $value = JText::printf($column->format, ...get_object_vars($options[$key]));
				 elseif(empty($value) && $column->printf && isset($options[$key]))
					 $value = JText::printf($column->printf, ...get_object_vars($options[$key]));
				
				
//if(ucwords($column->type)== 'Radio' && $column->countOptions === 0){ 
//toPrint($field->default,'default.'.$key,0,'pre');
//toPrint($field->value,'value.'.$key,0,'pre');
//toPrint($value,'$value.'.$key,0,'pre');
//toPrint($this->value[$column->fieldname][$key],'$value.'.$key,0,'pre');
//toPrint(isset($this->value[$column->fieldname][$key]),'isset().'.$key,0,'pre');
//}
//toPrint($value,'$value',0,'pre');
//toPrint($key,'$key',0,'pre');
//toPrint($column->name,'$column->name',0,'pre');
//toPrint($column->fieldname,'$column->fieldname',0,'pre');
//toPrint($column->type,'$column->type',0,'pre');
//toPrint($this->value[$column->fieldname],'$this->value[$column->fieldname]',0,'pre');
//$fields[$key][$column->name] = null; continue;

//toPrint($this->name,'$this->name',0,'pre');
//toPrint($column->name,'$column->name',0,'pre');
//toPrint($column->fieldname,'$column->fieldname',0,'pre'); 
//				$column->name = $this->name.'['.$column->fieldname.']['.(ucwords($column->type)== 'Radio'?$key:'').']';
//                $field->id = $this->id. '_'.$key. '_'.$column->name;
//				$column->row =$key;
				
//toPrint($this->id,'$fld->id:'.$i );
				
                $param = [
                    'id'        => $this->id. '_'.$key. '_'.$column->name,
                    'name'      => $this->name.'['.$column->fieldname.'][]',
                    'fieldname' => $column->fieldname,
                    'row'       => $key,
                    'description'=>'',
                    'hidden'	=>false,
                    'label'		=>'',
//					'class' => $column->class,
					'rows' => $column->rows,//1, //
                    ];
				
//				if(ucwords($column->type)== 'Radio' && $column->countOptions === false){// in_array($field->countOptions, [false, 1])   [2, 3,4,5,6,7]
//toPrint($value,' $value:'.$key.' ',0,'pre'); //						checked
//					$column->countOptions = count($column->element->xpath('option'));
//toPrint($column->countOptions,'$column->countOptions');
//					if($column->countOptions === 0){
//						$column->addOption("&#10004;",['value'=>$key, 'class'=>'btn btn-outline-success fw-bold']);//'class'=>'btn btn-outline-success      btn-check  fa fa-check' &#10003; &#10004;
//						$column->value = $value;
//						$column->default = $value;
//					}
//				}
//				$column->countOptions;
//toPrint(gettype($column->countOptions),'$column->countOptions');
				if(ucwords($column->type)== 'Radio' && $column->countOptions === 0){
//toPrint($value,'$val',0,'pre');
					$param ['name'] = "{$this->name}[{$column->fieldname}]"; 
					$param ['fieldname'] = $column->fieldname;
					$param ['countOptions'] = $column->countOptions;
						$param['value'] = $value;
						$param['default'] = $value;  
						
//toPrint($value,' $value',0  );
//						$column->value = $value;
//						$column->default = $value;
//					$param ['checked'] = $value == $key;
//					$value = $key;
//					$param ['value'] = $value;
//					$param ['default'] = $value;
//toPrint($value,' '.$key.' ',0,'pre');
//toPrint($value,'$value.'.$key,0,'pre');
//toPrint($value,'$value.'.$key,0,'pre');
				}
				if(in_array(ucwords($column->type), ['Radio']) && $column->countOptions){
					$param ['name'] = "{$this->name}[{$column->fieldname}][$key]";
					$param ['fieldname'] = $column->fieldname;
//toPrint($param ['name'],'$param [name]');
				}
//toPrint($key, ' $key',0,$column->type=='Checkbox');
//toPrint( ($value), $key.'  $value ',0,$column->type=='Checkbox');
//toPrint(empty($column->value), '  $column->value ',0,$column->type=='Checkbox');
//toPrint(empty($column->default), '  $column->default ',0,$column->type=='Checkbox');
				if(in_array(ucwords($column->type), ['Checkbox']) 
						&& empty($column->value) && empty($column->default))//$column->default === false
				{//&& empty($value) 
					$value = null;// Костыль
//					$param['default'] = '0'.$key; // Костыль
					$param['default'] = true; // Костыль
//					$param['default'] = $this->value[$column->fieldname][$key] ?? $defaults[$column->fieldname][$key] ?? true;
					$param ['name'] = "{$this->name}[{$column->fieldname}][$key]";
//					if(isset($this->value[$column->fieldname][$key]))
//						$value = $this->value[$column->fieldname][$key];
////					elseif(isset($this->value[$column->fieldname]) && is_scalar($this->value[$column->fieldname]))
////						$value = $this->value[$column->fieldname];
//					elseif(isset($defaults[$column->fieldname][$key]))
//						$value = $defaults[$column->fieldname][$key];
//					$param ['name'] = "{$this->name}[{$column->fieldname}][$key]";
//					$param ['fieldname'] = $column->fieldname;
//					$param ['value'] = $key;
//					$param ['default'] = $key;
//					$param['value'] = $value;
					
					/* */
//					$param['checked'] = isset($this->value[$column->fieldname]) && is_array($this->value[$column->fieldname]) 
//							? in_array($key, $this->value[$column->fieldname])// empty($value) == false;
//							: (isset($defaults[$column->fieldname]) && is_array($defaults[$column->fieldname]) 
//									? in_array($key, $defaults[$column->fieldname]) 
//									: false);
					
//toPrint($this->value[$column->fieldname],'$key:'.$key );
					$param['checked'] = (bool)($this->value[$column->fieldname][$key] ?? $defaults[$column->fieldname][$key] ?? false);
					
					
//toPrint($param ['name'],'$param [name]');
//toPrint($param['checked'], '$key:'.$key.' $value:'.$value); //(string)
//toPrint($param['checked']);
				}
					
//				$data = array_walk($param, $callback);
//                $data = array_merge([],(array)$column, $param);
				$param = array_merge([],get_object_vars($column), $param);
				
				$param['translateLabel'] = false;
				$param['translateDescription'] = false;
				$param['hidden'] = true;
				
                $field = static::createField($column->element, $value, $param);// <<<<<<<<<<<<<<<<<<<<< ->asXML()
				
                $field->id = $this->id. '_'.$key. '_'.$column->fieldname;
                $fields[$key][$column->fieldname] = $field;
				
//toPrint($field->fieldname,'value.'.$key,0,'pre'); 
//toPrint(array_keys($fields[$key]),'getLayoutFields() array_keys($fields[$key].'.$key,0,'pre'); 
				
//toPrint($field->checked, '  - - - - - - - - - - - - - - --- $field->checked:',0,$column->type=='Checkbox');
//toPrint($field->default, '  - - - - - - - - - - - - - - --- $field->default:',0,$column->type=='Checkbox');
//				if(in_array(ucwords($column->type), ['Checkbox']) && empty($column->value) && empty($column->default))//$column->default === false
//				{
////					$field->checked = isset($this->value[$column->fieldname]) && is_array($this->value[$column->fieldname]) ? in_array($key, $this->value[$column->fieldname])// empty($value) == false;
////					 : (isset($defaults[$column->fieldname]) && is_array($defaults[$column->fieldname]) ? in_array($key, $this->value[$column->fieldname]) : $param['checked']);
//				}
				
				if(ucwords($field->type)== 'Radio' && $column->countOptions === 0){// in_array($field->countOptions, [false, 1])   [2, 3,4,5,6,7]
//					$column->element->option[0]['value'] = $key;
//toPrint($field->default,'default.'.$key,0,'pre');
//toPrint($field->value,'value.'.$key,0,'pre');
//toPrint($value,'$value.'.$key,0,'pre');
//					$column->element->option[0]['value'] = $key;
//					$options = $column->element->xpath('option');
////					$column->countOptions = $options ? count($options) : 0;
//					if($count)
//						$field->addOption(' '.$key,['value'=>$key]);
//					else
						
//					$field->layout = 'joomla.form.field.radio.switcher';// 'joomla.form.field.radio.switcher'
//toPrint("[$key][$column->fieldname]");
//					$field->default = $value;
//					$field->value = $value;
//					$param ['checked'] = $value == $key;
//					$value = $key;
//toPrint($param['value'],"Name:$this->fieldname $key param->Value ",0,'pre');
//toPrint($value,'$Value ',0,'pre');
//toPrint($key);
//toPrint($field->value," field->Value",0,'pre');
//toPrint($field->checked," field->checked",0,'pre');
				}
//toPrint(((array)$column),'$column->class',0,'pre');
//toPrint($data->class,'$data->class',0,'pre');
//toPrint($column->class,'$column->class',0,'pre');
//toPrint($field->class,'$field->class',0,'pre');
//toPrint($field ,'$field ',0,'pre');
//if($column->type=='list')
//toPrint($field->id,'$field->id',0,'pre');
//toPrint($field->id,'FIELDS-$fieldID',0,'pre');
//                $field->id = $this->id.'_'.$column->id.'_'.$i;
//if($column->type=='list')            
//toPrint($field->id,'$field->id',0,'pre');
                
//toPrint($field,'$field',0,'pre'); //class  'classes','classCell','classHeader'
//toPrint($field->class,'$field',0,'pre');
                
//toPrint($field->id,'$field->id',0,'pre');
            }
        }
        
        return $fields;
        
        foreach ($this->columns as $column){    
            if(empty($column->name) || empty($this->value[$column->name]) || is_array($this->value[$column->name]=== false)){
//                $column->translateLabel = true;
//                $column->translateDescription = true;
//                $column->translateDescription = true;
//                $column->translateDefault = false;
//                $value = $column->velue ?: $column->default;
//                $value = empty($column->value) && $column->default && $column->translateDefault ? JText::_($column->default) : $column->default;
//                $fields[$i][$column->name] = $column;
                continue;
            }
            
            
            
            foreach ($this->value[$column->name] as $i => $val){
//                $data[$i][$column->name] = $val; //$this->value[$column->name][$i]; 
//toPrint($param,'$param',0,'pre');
//toPrint($val,'$val',0,'pre');
//toPrint($param['id'],'FIELD-paramID',0,'pre');
                $field = static::createField($column->type, $val, $param, $column->element);
//if($column->type=='list')            
//toPrint($field->id,'$field->id',0,'pre');
//toPrint($field->id,'FIELDS-$fieldID',0,'pre');
//                $field->id = $this->id.'_'.$column->id.'_'.$i;
//if($column->type=='list')            
//toPrint($field->id,'$field->id',0,'pre');
                $fields[$i][$column->name] = $field;
//                $field = JFormHelper::loadFieldType($column->type);
//                $field->setup($column->element, $val);
//                $field->id = $this->id. '_'.$field->name. '_'.$i; 
//                $field->name = $this->name.'['.$field->name.'][]';//.'[]' jform[params][textsubmit]   $this->name.'[]'   nameforpost[]
//                $field->row = $i;
//$field->label .= $field->name;            jform[params][tbl][nameforpost][]

//toPrint($field,'$field',0,'pre');
//                $field->html = $field->render('default');// renderField(); $value
//                $field->html = $field->renderField(['hiddenLabel'=>true,'hiddenDescription'=>true]);// renderField(); $value
//toPrint($field->name,'$field->name',0,'pre');
//                $column->fields[$i] = $field;
//                $fields[] = $field;
//toPrint($field->id,'$field->id',0,'pre');
            }
//toPrint($column,'$column',0,'pre');
        }
        
//toPrint($fields,'$fields',0,'pre');
//toPrint($fields,'$this->value[$column->name]',1,'pre');
        return $fields;
    }
    
    
 
    /**
	 * Method to get the field input markup for a generic list.
	 * Use the multiple attribute to enable multiselect.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   3.7.0
	 */
    protected function getInput(){
        
        
        return $this->getControl();
    }
    
	public function getControl()
	{
        
        if(true){
//            $columnIndex = static::createField(null); 
			$columnIndex = static::getDefaultData();
            $columnIndex->hidden      = false;
            $columnIndex->norender = TRUE;
            $columnIndex->translateLabel = false;
            $columnIndex->label      = '#';
            $columnIndex->text      = '#';
            $columnIndex->default    = '::';
            $columnIndex->type       = 'index';
            $columnIndex->fieldname  = 'i';
            $columnIndex->name       = 'i';
            $columnIndex->id         = $this->id.'_'.'i'; 
            $columnIndex->classHeader= 'index ';
            $columnIndex->classCell  = 'index '.$this->movableClass;
            $columnIndex->html       = '';
            $columnIndex->input       = '';
            $columnIndex->movable    = $this->movable;
        }
        if($this->creatable || $this->removable){
//            $columnRemove = static::createField(null);
			$columnRemove = static::getDefaultData();
            $columnIndex->norender = TRUE;
            $columnRemove->translateLabel = false;
            $columnRemove->hidden      = false;
            $columnRemove->label      = '+';
            $columnRemove->text      = '+';
            $columnRemove->default    = 'X';
            $columnRemove->type       = 'new_del';
            $columnRemove->fieldname  = 'new_del';
            $columnRemove->name       = 'new_del';
            $columnRemove->id         = $this->id.'_'.'new_del';
            $columnRemove->classHeader= 'new_del '.$this->creatableClass;
            $columnRemove->classCell  = 'new_del '.$this->removableClass;
            $columnRemove->class  = $this->buttonClass ?: ' btn-sm ';
            $columnRemove->html       = '';
            $columnRemove->input       = '';
            $columnRemove->creatable  = $this->creatable;
            $columnRemove->removable  = $this->removable;
        }
        
        
//            [
//            'autocomplete','autofocus','class','description','default','disabled',
//            'element','field','group','hidden','hint',
//            'id','label','labelclass','multiple','showon',
//            'name','onchange','onclick','pattern','validationtext','readonly','repeat','required','size','spellcheck',
//            'type','validate','value','dataAttribute','dataAttributes',
//            'text','for','classes','classCell','classHeader','position',
//            'fieldname','translateLabel','translateDescription','translateHint',
//            'translate_label', 'translate_description',
//            'sortable'
//            ];
        
//toPrint($this,'$this',0,'pre');
//toPrint($this->value,'$this->value',0,'pre');
//toPrint($this->id,'$this->layout',0,'pre');
//        $html .= "funInput: - <br>Default: <b>$this->default</b>  <br> ID: <b>$this->id</b>  <br> Type: <b>$this->type</b> <br> Name: <b>$this->name</b> <br><br>";

        if(empty($this->layout))
            $this->layout = $this->type;
    
//toPrint($this->value,' Velue ',0,'pre');    
        
        $data =  $this->getLayoutData(); 
//$label = $this->element['label'] ? ((string)$this->element['label']) : ((string) $this->element['name']); 
        
        $data['columns'] = $this->getLayoutColumns();
 $temp_delete=false;
//toPrint($data['columns'],'$data[columns]',0,'pre');
//toPrint(array_keys($data['columns']),'getControl() array_keys($data[columns]] tblName:'.$this->name,0,'message' );
//toPrint($data['columns']['select'],'getControl();  SELECT:' ,0,'message');
//unset($data['columns']['title']);
//unset($data['columns']['option']);
//unset($data['columns']['cost']);
//unset($data['columns']['quantity']);
//unset($data['columns']['account']);
//unset($data['columns']['display']);
//unset($data['columns']['select']);

        foreach ($data['columns'] as $name => $col){
			
//toPrint('getControl();   key:'.$name,'Col->name:'.$col->name);
//	continue;
			
//toPrint($col->value,' columnDefault',0, $name == 'select' );
//			if(ucwords($col->type)== 'Radio' && empty($col->countOptions)){// in_array($field->countOptions, [false, 1])   [2, 3,4,5,6,7]
//				$col->name = "{$this->name}[{$col->fieldname}]";
//toPrint($col->norender,' $col->norender:'.$col->fieldname.' ',0,'pre'); //					checked
//			}
			
			
//			$renderer = new FileLayout($this->renderLayout);
//			$layoutPaths = $this->getLayoutPaths(); 
//			if ($layoutPaths)
//				$renderer->setIncludePaths($layoutPaths);
//			if($col->norender)
//				$col->input = $col->getInput();
//			$col->html = $renderer->render(
//					['hiddenLabel'=>true,'hiddenDescription'=>true,'id'=>$col->id,'name'=>$col->name,'label'=>$col->label,'input'=>$col->input ]);
//toPrint($col); continue;
// * @var   array   $options      Optional parameters
// * @var   string  $name         The id of the input this label is for
// * @var   string  $label        The html code for the label
// * @var   string  $input        The input field html code
// * @var   string  $description  An optional description to use in a tooltip
//            $col->html = $col->norender ? $col->html : $col->render($this->renderLayout,['hiddenLabel'=>true,'hiddenDescription'=>true,'id'=>$col->id]);// renderField(); $value
//toPrint(array_keys($data['columns']),'$namesCol:'.$this->name,0,'message');
//if(in_array($this->name, [
//	'jform[com_fields][tsena][0]',
//	'jform[com_fields][tsena][1]',
////	'jform[com_fields][tsena][2]', // Ошибки нет
//	'jform[com_fields][tsena][3]',
//	]))
//return '';
			if(empty($col->norender))
			{
//if($col->fieldname==1)
//	$temp_delete = true;
//if($temp_delete)
//try {

				$col->text = $col->getLabel();
				$col->hidden = true;
				if(ucfirst($col->type) == 'Radio' && $col->countOptions == 0){
//					$col->default = false;
					$col->checked = false;
					$col->value = true;
//					toPrint($col->default);
				}
				$col->html = $col->renderField(['hidden'=>true,'hiddenLabel' => true, 'hiddenDescription' => true, 'id' => $col->id]); // renderField(); $value
//} catch (Exception $exc) {
//toPrint($col->checked);
//toPrint($exc->getTraceAsString());
////					echo $exc->getTraceAsString();
//}
			}
            $col->id    = $this->id.'_'.$col->name.'_';
        }
//return;
        
        $data['columns'] = array_merge([], ['i'=>$columnIndex],$data['columns']);
        
        if($this->creatable || $this->removable)
            $data['columns']['coldel'] = $columnRemove;
        
        $data['fields'] = $this->getLayoutFields();
        
        $_i = 0;
         
		
//unset($data['fields']['select']);
		
        foreach ($data['fields'] as $i => $row) {
			
//toPrint(array_keys($row),'$fields $row');  
			
            foreach ($row as $field) {
                
//				if(isset($data['columns'][$field->fieldname]))
//					$field->class = $data['columns'][$field->fieldname]->class;
				
//toPrint($data['columns'][$field->fieldname],'$field->id',0,$field->fieldname == 'idField');
//                $field->id = $field->id.'_'.$i.'_x';
//if($field->type=='radio')
//toPrint($field->id,'$field->id',0,'pre');
//if($field->type=='Radio')            
//toPrint($field,'$field->id '.$id,0,'pre');
//toPrint($field->id,'$field->id',0,'pre');
              if(ucwords($field->type)== 'Radio')  {
//toPrint($field->countOptions, $field->fieldname.'.'.$i);
			  }
//toPrint($field); continue;
				if(ucwords($field->type)== 'Radio' && $field->countOptions === 0){// in_array($field->countOptions, [false, 1])   [2, 3,4,5,6,7]

//						$field->countOptions
						$field->checked = $field->default == $i;
						$field->element->option[0]['value'] = $i;
//toPrint($this->name,' default:'.$field->default.' $i:'.$i,0);
//toPrint($col->default,' columnDefault',0, $name == 'select' );
//						$value = $key;
//toPrint($param['value'],"Name:$this->fieldname $key param->Value ",0,'pre');
//toPrint($field->value,'$field->value ',0,'pre');
//toPrint( $field->default.' == '.$i);
//toPrint($field->value," field->Value",0,'pre');
//toPrint($field->default," field->default",0,'pre');
//toPrint($field->checked," field->checked",0,'pre');
				}
//toPrint($field->rows,'$field->rows',0,'pre');
//				renderLayout layoutFile
				if(false && $field->layoutPath){//'joomla.form.field.checkbox',//JPATH_BASE . '/plugins/fields/cost/field/layouts/'
					$alt = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $field->fieldname);
					$dataField = get_object_vars($field);
					$dataField['hiddenLabel'] = true;
					$dataField['hidden'] = true;
					$dataField['hiddenDescription'] = true;
					$dataField['id'] = $field->id;
					$dataField['hint'] = $field->translateHint ? JText::alt($field->hint, $alt) : $field->hint;
					$dataField['checked'] = $field->checked || $field->value;
					
//toPrint($field->layoutFile);
//toPrint($field->layoutPath);
					$field->html = JLayoutHelper::render($field->layout, $dataField, $field->layoutPath);//, $basePath,$options
				}
				else
					$field->html = $field->renderField(['hidden' => true,'hiddenLabel' => true,'hiddenDescription'=>true,'id'=>$field->id]); // renderField(); $value    ,'id'=>$field->id.'_'.$i
//				$field->html = $field->renderField(['hiddenLabel' => true,'hiddenDescription'=>true,'id'=>$field->id]); // renderField(); $value    ,'id'=>$field->id.'_'.$i
                
//if($field->type=='Radio')
//$_i += 1;
//if($field->type=='Radio')
//toPrint($field,$field->type.' $field->id '.$field->id,0,'pre');
//if($field->type=='Radio')
//toPrint($field->id,$field->type.' -$field->id- '.$field->id,0,'pre');
//if($field->type=='radio')
//toPrint($field->html,'$field->html',0,'pre');
            }
        }
		$data['error'] = $this->error;
		
//toPrint($data['fields'],'$fields',0,'pre');
//toPrint($data,'$caption',0,'message',true);
        
        $layoutPath1 = realpath(__DIR__.'/../layouts/');
        $layoutPath2 = realpath(__DIR__.'/layouts/');
		
//toPrint($data,'',0);
//toPrint($this->layout,'',0);//GridFields
//toPrint($layoutPath1,'',0);
		
//toPrint($layoutPath1,'$layoutPath1',0,'message');
//toPrint($layoutPath2,'$layoutPath2',0,'message');
//toPrint($this->layout,'$this->layout',0,'message');
		
		$html = $this->getRenderer(strtolower($this->layout))->addIncludePath($layoutPath1)->addIncludePath($layoutPath2)->render($data);
		
		
//toPrint(strlen($html),'Lenght',0,'message');
		 
        return $html;  
        return parent::getInput();
	}
    
}
?> 
