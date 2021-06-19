# Группа полей ipgeobase


## Зависимости
Для использования поля требуется установить ipgeobase пакет:
- [ipgeobase](https://github.com/Delo-Design/ipgeobase)


## Поля

### Поле listcities
#### Описание
Организовывает выбор города по базе IPgeobase. Работают как подсказки с требованием выбрать из списка.

#### Атрибуты
Атрибутов доступных нет от поля. 
Унаследовано от поля Text, поэтому частично доступны атрибуты. [Посмотреть можно тут](https://docs.joomla.org/Special:MyLanguage/Text_form_field_type)

#### Пример xml
```xml
<field
    name="mycity"
    type="listcities"
    label="Мое название поля"
    description="Мое описание поля"
    addfieldpath="libraries/lib_fields/ipgeobase"
/>
```

<hr />

### Поле listregions
#### Описание
Организовывает выбор региона по базе IPgeobase. Работают как подсказки с требованием выбрать из списка.
Унаследовано от поля Text, поэтому частично доступны атрибуты. [Посмотреть можно тут](https://docs.joomla.org/Special:MyLanguage/Text_form_field_type)

#### Пример xml
```xml
<field
    name="myregion"
    type="listregions"
    label="Мое название поля"
    description="Мое описание поля"
    addfieldpath="libraries/lib_fields/ipgeobase"
/>
```