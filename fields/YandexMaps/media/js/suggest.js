document.addEventListener("DOMContentLoaded", function () {

    function initMaps(container) {
        let list = container.querySelectorAll('.in-yandex-maps');
        for (let i = 0; i < list.length; i++) {
            (new ymaps.SuggestView(list[i].getAttribute('id'))).events.add('select', function (event) {
                list[i].value = event.get('item').value;
            });
        }
    }

    ymaps.load(function () {
        initMaps(document);
    });

    if (window.jQuery !== undefined) {
        jQuery(document).on('subform-row-add', function (event, row) {
            initMaps(row);
        });
    }



});