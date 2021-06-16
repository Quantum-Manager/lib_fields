<?php

defined('_JEXEC') or die;

if (!$field->value)
{
	return;
}

$arr = explode(';', $field->value);

if(!isset($arr[0]) || !isset($arr[1]))
{
	return;
}

?>

<div id="mapyandex" style="width: 100%; height: 400px"></div>


<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript">
</script>
<script type="text/javascript">
    ymaps.ready(init);

    function init(){
        var coor = '<?= $arr[1] ?>';
        var myMap = new ymaps.Map("mapyandex", {
            center: coor.split(','),
            zoom: 17
        });

        var myPlacemark = new ymaps.Placemark(coor.split(','), {
            balloonContent: '<?= $arr[0] ?>'
        });

        myMap.geoObjects.add(myPlacemark);
    }
</script>