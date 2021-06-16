document.addEventListener('DOMContentLoaded' ,function () {

    function initAccordion(container) {
        let acc = container.querySelectorAll('.subformmore-accordion');

        for (let i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
                this.classList.toggle("active");
                let panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }
    }


    initAccordion(document);

    if (window.jQuery !== undefined) {
        jQuery(document).on('subform-row-add', function (event, row) {
            initAccordion(row);
        });
    }

});