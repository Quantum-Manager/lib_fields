# Как наследовать поля в php и расширять

### Загрузите путь
Сначала вам надо зарегистрировать путь поля.
```php
\Joomla\CMS\Form\FormHelper\FormHelper::addFieldPath();
```

Например, зарегистрируем поле listarticles.
```php
\Joomla\CMS\Form\FormHelper\FormHelper::addFieldPath(
    JPATH_ROOT . '/libraries/lib_fields/fields/listarticles' 
);
```

### Загрузите класс
Чтобы унаследоваться вам надо загрузить класс, в джумле есть хелпер для этого, который ранее использовался
```php
\Joomla\CMS\Form\FormHelper\FormHelper::loadFieldClass();
```

Например, загрузим поле listarticles.
```php
\Joomla\CMS\Form\FormHelper\FormHelper::loadFieldClass('listarticles');
```

### Напишите класс и унаследуйте
После этого всего вы готовы создавать свой класс поля и наследоваться. <br/>
Полный код от выше примеров:
```php
<?php defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\FormHelper;

\Joomla\CMS\Form\FormHelper\FormHelper::addFieldPath(
    JPATH_ROOT . '/libraries/lib_fields/fields/listarticles' 
);

FormHelper::loadFieldClass('listarticles');

class JFormFieldMyListarticles extends JFormFieldListarticles
{

}
```

Дальше вы добавляете и переопределяете методы доступные из класса родителя.
