// TODO переписать скрипт на сабформу и убрать все эти id
window.Selectmenuitem = function () {

    let self = this;


    this.element = null;


    this.root = null;


    this.init = function (element) {

        if (typeof element !== 'object') {
            return;
        }

        self.element = element;
        self.root = self.element.querySelector(':scope > ul');
        self.initList(self.root);
        self.element.querySelector('.checkAll').addEventListener('click', self.checkAll);
        self.element.querySelector('.uncheckAll').addEventListener('click', self.uncheckAll);
        self.element.querySelector('.expandAll').addEventListener('click', self.expandAll);
        self.element.querySelector('.collapseAll').addEventListener('click', self.collapseAll);
    };


    this.initList = function (list) {

        if (list === null || list === undefined) {
            return;
        }

        let lis = list.querySelectorAll(':scope > li');
        for (let i = 0; i < lis.length; i++) {

            let sub_ul = lis[i].querySelector(':scope > ul');

            if (sub_ul !== null && sub_ul !== undefined) {
                self.initList(sub_ul);

                let carret = lis[i].querySelector('.selectmenuitem-carret');
                if (carret !== null && carret !== undefined) {
                    carret.addEventListener('click', self.visibleToggle);
                }

            } else {
                let carret = lis[i].querySelector('.selectmenuitem-carret');
                if (carret !== null && carret !== undefined) {
                    carret.querySelector('span').remove();
                }
            }
        }
    };


    this.expandAll = function () {
        let lists = self.element.querySelectorAll('ul');
        for (let i = 0; i < lists.length; i++) {
            self.show(lists[i]);
        }
    };


    this.collapseAll = function () {
        let lists = self.element.querySelectorAll('ul');
        for (let i = 0; i < lists.length; i++) {
            self.hide(lists[i]);
        }
    };


    this.checkAll = function () {
        let inputs = self.element.querySelectorAll('input[type=checkbox]');
        for (let i = 0; i < inputs.length; i++) {
            if (!inputs[i].checked) {
                inputs[i].click();
            }
        }
    };


    this.uncheckAll = function () {
        let inputs = self.element.querySelectorAll('input[type=checkbox]');
        for (let i = 0; i < inputs.length; i++) {
            if (inputs[i].checked) {
                inputs[i].click();
            }
        }
    };


    this.visibleToggle = function () {
        let list = this.closest('li').querySelector('ul');

        if(list !== null && list !== undefined) {
            if(!list.classList.contains('hide')) {
                self.hide(list);
            } else {
                self.show(list);
            }
        }
    };


    this.show = function (list) {
        if(list === null) {
            list = self.root;
        }

        let root = list.closest('li');

        if(root === null || root === undefined) {
            return;
        }

        let carret = root.querySelector('.selectmenuitem-carret');

        if(carret === null || carret === undefined) {
            return;
        }

        carret.querySelector('span').classList.remove('icon-plus');
        carret.querySelector('span').classList.add('icon-minus');
        list.classList.remove('hide');
    };


    this.hide = function (list) {
        if(list === null) {
            list = self.root;
        }

        let root = list.closest('li');

        if(root === null || root === undefined) {
            return;
        }

        let carret = root.querySelector('.selectmenuitem-carret');

        if(carret === null || carret === undefined) {
            return;
        }

        carret.querySelector('span').classList.add('icon-plus');
        carret.querySelector('span').classList.remove('icon-minus');
        list.classList.add('hide');
    };


};


document.addEventListener('DOMContentLoaded', function () {
    let elements = document.querySelectorAll('.selectmenuitem');

    for (let i = 0; i < elements.length; i++) {
        new window.Selectmenuitem().init(elements[i]);
    }


    if (window.jQuery !== undefined) {
        jQuery(document).on('subform-row-add', function (event, row) {
            let elements = row.querySelectorAll('.selectmenuitem');

            for (let i = 0; i < elements.length; i++) {
                new window.Selectmenuitem().init(elements[i]);
            }
        });
    }

});