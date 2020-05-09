window.QuantumuploadimageInsertFieldValue = function (value, fieldid) {
    let input = document.querySelector('#' + fieldid),
        wrap = input.closest('.quantumuploadimage-field');
    if(value.slice(0, 1) === '/') {
        value = value.slice(1);
    }
    input.value = value;
    updateImage(wrap, value);
};


function updateImage(wrap, image) {
    let preview = wrap.querySelector('.quantumuploadimage-preview');
    if(image !== '') {
        preview.classList.add('quantumuploadimage-preview-active');
        preview.innerHTML = '<img src="/' + image + '" />';
    } else {
        preview.classList.remove('quantumuploadimage-preview-active');
    }
}

document.addEventListener('DOMContentLoaded' ,function () {
    let quantumuploadimageAll = document.querySelectorAll('.quantumuploadimage-field');
    for(let i=0;i<quantumuploadimageAll.length;i++) {
        let buttonUpload = quantumuploadimageAll[i].querySelector('.quantumuploadimage-upload-start'),
            buttonChange = quantumuploadimageAll[i].querySelector('.quantumuploadimage-change'),
            buttonCopy = quantumuploadimageAll[i].querySelector('.quantumuploadimage-copy'),
            buttonDelete = quantumuploadimageAll[i].querySelector('.quantumuploadimage-delete'),
            input = quantumuploadimageAll[i].querySelector('.quantumuploadimage-input'),
            quantummanager = quantumuploadimageAll[i].closest('.quantummanager'),
            fmIndex = parseInt(quantummanager.getAttribute('data-index'));

        if(input.value !== '') {
            QuantumuploadimageInsertFieldValue(input.value, input.getAttribute('id'));
        }

        if(buttonCopy !== null) {
            buttonCopy.addEventListener('click', function (ev) {
                ev.preventDefault();

                if(input.value === '') {
                    return;
                }

                QuantumUtils.copyInBuffer(QuantumUtils.getFullUrl(input.value, true));
                QuantumUtils.notify({text: QuantumLang.copied});

            });
        }

        if(buttonUpload !== null) {
            buttonUpload.addEventListener('click', function (ev) {
                QuantummanagerLists[fmIndex].Qantumupload.selectFiles();
                ev.preventDefault();
            });
        }

        buttonChange.addEventListener('click', function (ev) {
            let url = this.getAttribute('data-source-href');
            if(input.value !== '') {
                let paths = input.value.split('/');
                paths.pop();
                url += '&folder=' + paths.join('/').replace('images/', '');
            }
            SqueezeBox.open(url, {handler: 'iframe', size: {x: 1450, y: 700}, classWindow: 'quantummanager-modal-sbox-window'});
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