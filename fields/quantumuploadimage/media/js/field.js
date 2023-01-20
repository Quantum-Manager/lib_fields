let isJoomla4 = false;
let quantumuploadimageSelector = null;
let quantumuploadimageModal = null;

window.QuantumuploadimageInsertFieldValue = function (value, fieldid) {
    let input = document.querySelector('#' + fieldid),
        wrap = input.closest('.quantumuploadimage-field');
    if (value.slice(0, 1) === '/') {
        value = value.slice(1);
    }
    input.value = value;
    updateImage(wrap, value);
};

window.QuantumuploadimageModalOpen = function () {
    let input = quantumuploadimageSelector.querySelector('input');
    let url = QuantumUtils.getFullUrl('index.php?option=com_quantummanager&tmpl=component&layout=modal&namespace=quantumuploadimage') + '&fieldid=' + input.getAttribute('id');

    if (input.value !== '') {
        let paths = input.value.split('/');
        paths.pop();
        url += '&folder=' + paths.join('/').replace('images/', '');
    }

    if (!isJoomla4) {

        SqueezeBox.open(url, {
            handler: 'iframe',
            size: {x: 1450, y: 700},
            classWindow: 'quantummanager-modal-sbox-window'
        });

    } else {

        quantumuploadimageModal = quantumuploadimageSelector.querySelector('.joomla-modal');
        // TODO разобраться с модалки до лучших времен

        /*if (quantumuploadimageModal && window.bootstrap && window.bootstrap.Modal && !window.bootstrap.Modal.getInstance(quantumuploadimageModal)) {
            return;
        }*/

        quantumuploadimageModal.setAttribute('data-url', url);
        quantumuploadimageModal.setAttribute('data-iframe',
            quantumuploadimageModal.getAttribute('data-iframe').replace(/src=[\'\"].*?[\'\"]/g, 'src="' + url + '"')
        );

        Joomla.initialiseModal(quantumuploadimageModal, {
            isJoomla: true
        });

        quantumuploadimageModal.open();

    }
}

window.QuantumuploadimageModalClose = function () {
    if (!isJoomla4) {
        if (window.jModalClose !== undefined) {
            window.jModalClose();
        }

        window.jQuery('.modal.in').modal('hide');
    } else {

        if (quantumuploadimageModal && window.bootstrap && window.bootstrap.Modal && !window.bootstrap.Modal.getInstance(quantumuploadimageModal)) {
            return;
        }

        let close = quantumuploadimageModal.querySelector('[data-bs-dismiss]');
        if (close !== null && close !== undefined) {
            close.click();
        }


    }

}

function updateImage(wrap, image) {
    let preview = wrap.querySelector('.quantumuploadimage-preview');
    if (image !== '') {
        preview.classList.add('quantumuploadimage-preview-active');
        preview.innerHTML = '<img src="' + QuantumSettings.urlRoot + image + '" />';
    } else {
        preview.classList.remove('quantumuploadimage-preview-active');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    initQuantumuploadimage();
});


document.addEventListener('subform-row-add', function (event) {
    initQuantumuploadimage(event.target);
});

//support subform add row
if (window.jQuery !== undefined) {
    jQuery(document).on('subform-row-add', function (event, row) {
        initQuantumuploadimage(row);
    });
}

function initQuantumuploadimage(container) {

    if (container === null || container === undefined) {
        container = document;
    }

    let quantumuploadimageAll = container.querySelectorAll('.quantumuploadimage-field.quantummanager');

    for (let i = 0; i < quantumuploadimageAll.length; i++) {

        let wait_quantum = setInterval(function () {

            let quantummanager = quantumuploadimageAll[i].closest('.quantummanager'),
                fmIndex = parseInt(quantummanager.getAttribute('data-index'));

            if (!isNaN(fmIndex)) {
                clearInterval(wait_quantum);
            } else {
                return;
            }

            let buttonUpload = quantumuploadimageAll[i].querySelector('.quantumuploadimage-upload-start'),
                buttonChange = quantumuploadimageAll[i].querySelector('.quantumuploadimage-change'),
                buttonCopy = quantumuploadimageAll[i].querySelector('.quantumuploadimage-copy'),
                buttonDelete = quantumuploadimageAll[i].querySelector('.quantumuploadimage-delete'),
                input = quantumuploadimageAll[i].querySelector('.quantumuploadimage-input');

            if (input.value !== '') {
                QuantumuploadimageInsertFieldValue(input.value, input.getAttribute('id'));
            }

            if (buttonCopy !== null) {
                buttonCopy.addEventListener('click', function (ev) {
                    ev.preventDefault();

                    if (input.value === '') {
                        return;
                    }

                    QuantumUtils.copyInBuffer(QuantumUtils.getFullUrl(input.value, true));
                    QuantumUtils.notify({text: QuantumLang.copied});

                });
            }

            if (buttonUpload !== null) {
                buttonUpload.addEventListener('click', function (ev) {
                    QuantummanagerLists[fmIndex].Qantumupload.selectFiles();
                    ev.preventDefault();
                });
            }

            buttonChange.addEventListener('click', function (ev) {
                let isJoomla4Attr = this.getAttribute('data-is-joomla4');

                if (isJoomla4Attr === '1') {
                    isJoomla4 = true;
                } else {
                    isJoomla4 = false;
                }

                quantumuploadimageSelector = this.closest('.quantumuploadimage-field-toolbar');
                window.QuantumuploadimageModalOpen();

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
                if (fm.Qantumupload.filesLists === undefined || fm.Qantumupload.filesLists.length === 0) {
                    return;
                }

                let pathFile = fm.data.path + '/' + fm.Qantumupload.filesLists[0];
                QuantumUtils.ajaxGet(QuantumUtils.getFullUrl("index.php?option=com_quantummanager&task=quantumviewfiles.getParsePath&path=" + encodeURIComponent(pathFile) +
                    '&scope=' + fm.data.scope +
                    '&v=' + QuantumUtils.randomInteger(111111, 999999))).done(function (response) {
                    response = JSON.parse(response);

                    if (response.path !== undefined) {
                        QuantumuploadimageInsertFieldValue(response.path, input.getAttribute('id'));
                    }

                });

            });
        }, 100);

    }
}
