window.QuantumuploadimageInsertFieldValue = function (value, fieldid) {
    let input = document.querySelector('#' + fieldid),
    wrap = input.closest('.quantumuploadimage-field');
    input.value = value;
    updateImage(wrap, value);
};


function updateImage(wrap, image) {
    let preview = wrap.querySelector('.quantumuploadimage-preview');
    if(image !== '') {
        preview.innerHTML = '<img src="/' + image + '" />';
    } else {
        preview.innerHTML = "<div class=\"drag-drop\"><div><div class=\"quantummanager-icon quantummanager-icon-upload\"></div><div>Вы можете бросить файлы для загрузки.</div></div></div>";
    }
}

document.addEventListener('DOMContentLoaded' ,function () {
    let quantumuploadimageAll = document.querySelectorAll('.quantumuploadimage-field');
    for(let i=0;i<quantumuploadimageAll.length;i++) {
        let buttonChange = quantumuploadimageAll[i].querySelector('.quantumuploadimage-upload-start'),
        buttonDelete = quantumuploadimageAll[i].querySelector('.quantumuploadimage-delete'),
        input = quantumuploadimageAll[i].querySelector('.quantumuploadimage-input'),
        quantummanager = quantumuploadimageAll[i].closest('.quantummanager'),
        fmIndex = parseInt(quantummanager.getAttribute('data-index'));

        buttonChange.addEventListener('click', function (ev) {
            QuantummanagerLists[fmIndex].Qantumupload.selectFiles();
            ev.preventDefault();
        });

        buttonDelete.addEventListener('click', function (ev) {
            QuantumuploadimageInsertFieldValue('', input.getAttribute('id'));
            ev.preventDefault();
        });

        input.addEventListener('change', function () {
            this.value = this.value.replace(QuantumSettings.urlFull, '');
            QuantumuploadimageInsertFieldValue(this.value, input.getAttribute('id'));
        });

        QuantummanagerLists[fmIndex].events.add(this, 'uploadComplete', function (fm, el) {
            if(fm.Qantumupload.filesLists === undefined || fm.Qantumupload.filesLists.length === 0) {
                return;
            }

            let pathFile = fm.data.path + '/' + fm.Qantumupload.filesLists[0];
            jQuery.get(QuantumUtils.getFullUrl("/administrator/index.php?option=com_quantummanager&task=quantumviewfiles.getParsePath&path=" + encodeURIComponent(pathFile) +
                '&scope=' + fm.data.scope +
                '&v=' + QuantumUtils.randomInteger(111111, 999999))).done(function (response) {
                response = JSON.parse(response);

                if(response.path !== undefined) {
                    QuantumuploadimageInsertFieldValue(response.path, input.getAttribute('id'));
                }

            });

        });
    }
});