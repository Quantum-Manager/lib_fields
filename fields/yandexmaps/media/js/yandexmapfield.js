jQuery(document).ready(function () {

    ymaps.load(function () {
        jQuery('.in-yandex-maps').each(function (i, el) {
            (new ymaps.SuggestView(jQuery(el).attr('id'))).events.add('select', function (event) {
                ymaps.geocode(event.get('item').value).then(function (res) {
                    var id = event.get('target')._panel._anchor.id;
                    var obj = res.geoObjects.get(0),
                        error, hint;
                    var fulladdress = obj.properties.get('metaDataProperty.GeocoderMetaData.Address.formatted');
                    var point = obj.properties.get('metaDataProperty.GeocoderMetaData.InternalToponymInfo.Point');

                    jQuery('#' + id).val(fulladdress + ';' + point.coordinates[1] + ',' + point.coordinates[0]);

                }, function (e) {
                })
            });
        })
    });


});