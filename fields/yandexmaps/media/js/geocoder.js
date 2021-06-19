document.addEventListener("DOMContentLoaded", function () {

    ymaps.load(function () {
        let list = document.querySelectorAll('.in-yandex-maps');
        for (let i = 0; i < list.length; i++) {
            (new ymaps.SuggestView(list[i].getAttribute('id'))).events.add('select', function (event) {
                ymaps.geocode(event.get('item').value).then(function (res) {
                    var id = event.get('target')._panel._anchor.id;
                    var obj = res.geoObjects.get(0),
                        error, hint;
                    var fulladdress = obj.properties.get('metaDataProperty.GeocoderMetaData.Address.formatted');
                    var point = obj.properties.get('metaDataProperty.GeocoderMetaData.InternalToponymInfo.Point');
                    list[i].value = fulladdress + ';' + point.coordinates[1] + ',' + point.coordinates[0];
                }, function (e) {

                });
            });
        }
    });

});