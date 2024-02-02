let quantumuploadimageSelector = null;
let quantumuploadimageModalID = null;
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
    let url = QuantumUtils.getFullUrl('index.php?option=com_quantummanager&view=quantummanager&tmpl=component&layout=modal&namespace=quantumuploadimage') + '&fieldid=' + input.getAttribute('id');

    if (input.value !== '') {
        let value = input.value.replace(/\#.+$/, '');
        let paths = value.split('/');
        paths.pop();
        url += '&folder=' + paths.join('/').replace('images/', '');
    }

    let modal = document.querySelector('#' + quantumuploadimageModalID);

    if (!modal) {
        return;
    }

    window.quantumuploadimageModal = modal;
    window.quantumuploadimageModal.setAttribute('data-url', url);
    window.quantumuploadimageModal.setAttribute('data-iframe',
        window.quantumuploadimageModal.getAttribute('data-iframe').replace(/src=[\'\"].*?[\'\"]/g, 'src="' + url + '"')
    );

    Joomla.initialiseModal(modal, {isJoomla: true});

    modal.addEventListener('shown.bs.modal', (event) => {
        Joomla.Modal.setCurrent(event.target);
    });

    let currentModal = Joomla.Modal.getCurrent();
    if (currentModal) {
        currentModal.close();
    }

    document.getElementById(quantumuploadimageModalID).open();

}

window.QuantumuploadimageModalClose = function () {
    let currentModal = Joomla.Modal.getCurrent();
    if (currentModal) {
        currentModal.close();
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

//support subform add row
if (window.jQuery !== undefined) {
    jQuery(document).on('subform-row-add', function (event, row) {
        if(row == null || row === undefined) {
            row = event.target;
        }

        row = row.querySelector('.subform-repeatable-group:last-child');
        initQuantumuploadimage(row);
    });
} else {
    document.addEventListener('subform-row-add', function (event) {
        let row = event.target;
        row = row.querySelector('.subform-repeatable-group:last-child');
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
                quantumuploadimageSelector = this.closest('.quantumuploadimage-field-toolbar');
                quantumuploadimageModalID = this.getAttribute('data-modal-id');

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
