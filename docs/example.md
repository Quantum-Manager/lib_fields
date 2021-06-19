# Как вставлять в xml для Form (JForm)
Сначала вам надо посмотреть описание поля и установить зависимости, если они есть, которые требует поле. [Список описанией](https://github.com/JPathRu/lib_fields/tree/master/docs/fields). <br />
Когда вы пишите в xml поля из данной коллекции вам обязательно надо добавлять каждому полю атрибут **addfieldpath**, это путь до поля из коллекции. <br />
Маска путей: /libraries/lib_fields/fields/<коллекция полей>

## Пример xml
```xml

<?xml version="1.0" encoding="utf-8"?>
<form>
    <fields name="fieldparams">
        <fieldset name="fieldparams">

            <field
                type="text"
                name="mytext"
                label="Мое текстовое поле из ядра джумлы"
            />
                    
            <field
                type="layouts"
                name="layoutdefault"
                label="Мои шаблоны из группы полей layouts"
                values="PathsHelper::getLayouts"
                target="plugin.fields.radicaluniversalfield"
                addfieldpath="/libraries/lib_fields/fields/layouts"
            />

            <field
                    type="listcomponents"
                    name="components"
                    label="Список компопонентов из админки джумлы"
                    client="administrator"
                    addfieldpath="/libraries/lib_fields/fields/listcomponents"
            />
            
        </fieldset>
    </fields>
</form>
```