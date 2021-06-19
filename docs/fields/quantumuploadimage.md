# Группа полей Quantumuploadimage


## Зависимости
Для использования поля требуется установить Qauntum Manager пакет:
- [Qauntum Manager](https://github.com/Quantum-Manager/start)


## Поля

### Поле quantumuploadimage
#### Описание
Загрузка файлов с помощью Quantum Manager.

#### Атрибуты
- maxsize="2" - число | указать максимальную загрузку файла в мегабайтах (только клиентская проверка идет)
- copy="true" - булево значение | кнопка копирования ссылки на файл
- directory="images/myfolder" - строка | папка для загрузки
- dropAreaHidden="true" - булево значение | показ области превью и загрузки

#### Пример xml
```xml
<field
    name="myfile"
    type="quantumuploadimage"
    label="Мое название поля"
    description="Мое описание поля"
    dropAreaHidden="0"
    addfieldpath="libraries/lib_fields/quantumuploadimage"
/>
```