# Группа полей listcomponents


## Поля

### Поле listcomponents
#### Описание
Фиксированная выгрузка статей по указанным атрибутам для выбора.

#### Атрибуты
- client="site" - строка | доступные значения: site или administrator

Унаследовано от поля List, поэтому частично доступны атрибуты. [Посмотреть можно тут](https://docs.joomla.org/List_form_field_type)

#### Пример xml
```xml
<field
    name="mycomp"
    type="listcomponents"
    label="Мое название поля"
    description="Мое описание поля"
    client="administrator"
    addfieldpath="libraries/lib_fields/listcomponents"
/>
```