window.QuantumuploadimageInsertFieldValue = function (value, fieldid) {
    let input = document.querySelector('#' + fieldid),
    wrap = input.closest('.quantumuploadimage-wrap');
    input.value = value;
    updateImage(wrap, value);
};


function updateImage(wrap, image) {
    let img = wrap.querySelector('img');
    img.setAttribute('src', '/' + image);
}

document.addEventListener('DOMContentLoaded' ,function () {
    let quantumuploadimageAll = document.querySelectorAll('.quantumuploadimage-wrap');
    for(let i=0;i<quantumuploadimageAll.length;i++) {
        let buttonChange = quantumuploadimageAll[i].querySelector('.quantumuploadimage-upload-start'),
        input = quantumuploadimageAll[i].querySelector('input'),
        quantummanager = quantumuploadimageAll[i].closest('.quantummanager'),
        fmIndex = parseInt(quantummanager.getAttribute('data-index'));

        buttonChange.addEventListener('click', function (ev) {
            QuantummanagerLists[fmIndex].Qantumupload.selectFiles();
            ev.preventDefault();
        });

        QuantummanagerLists[fmIndex].events.add(this, 'uploadComplete', function (fm, el) {
            let pathFile = fm.data.path + '/' + fm.Qantumupload.filesLists[0];
            console.log(pathFile);
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