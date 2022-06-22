# Группа полей subformmore

## Поля

### Поле subformmore
#### Описание
Табличная сабформа с аккордеоном, куда можно вынести дополнительные поля.
#### Требования
В описании вложенной формы требуется сделать два fieldset. Первый с именем default, второй с именем more. <br/>
Так же укажите шаблон subformmore.

#### Атрибуты
Атрибутов доступных нет.
Унаследовано от поля Subform, поэтому частично доступны атрибуты. [Посмотреть можно тут](https://docs.joomla.org/Special:MyLanguage/subform_form_field_type)

#### Пример xml
```xml
<field
    name="mysubform"
    type="subformmore"
    label="Мое название сабформы"
    description="Мое описание сабформы"
    multiple="true"
    layout="subformmore"
    addfieldpath="libraries/lib_fields/subformmore"
>
    <form>
        <fieldset name="default">
        </fieldset>
        <fieldset name="more">
        </fieldset>
    </form>
</field>
```
