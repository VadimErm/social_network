(function ($) {
    $(document).ready(function() {
        $(":input").inputmask();
    });

    $('#add-relatives').on('click', function () {
        Stan.log('Add ne relative');
        Stan.Relative.addField();
    });

    $('.delete-br-and-sis').on('click', function () {
        Stan.Relative.deleteField(this);
    });

    $('#add-experience').on('click',  function () {
        Stan.Experience.addField();
    });

    $('#add-travel').on('click', function () {
        Stan.Travel.addField();
    });

    var agreement = null;
    return;

    $.ajax({
        url: '/index.php?r=site/agreement',
        method: 'GET',
        success: function (response) {
            agreement = new Stan.Modal({
                id: 'agreementModal',
                confirmHandler: function () {
                    Stan.log('Agree');
                },
                html: response
            }).show(5000);
        }
    });
})(jQuery);

var Stan = {
    devMode: true,
    log: function (message) {
        if (this.devMode) console.log(message)
    },
    deleteRecursive: function (element, depth) {
    depth == undefined ? 4 : depth;

    if (depth != 0) {
        $(element).prev().remove();
        Stan.deleteRecursive(element, depth-1);
    }

    return 0;
    },
    Travel: {
        deleteField: function (element) {
            Stan.deleteRecursive(element, 5);
            $(element).parent().remove();
        },
        addField: function () {
            $('#social-number').prepend('<div class="form-group"> ' +
                '<label class="control-label col-md-3 col-sm-3 col-xs-12">Страна</label> ' +
                '<div class="col-md-3 col-sm-3 col-xs-12"> ' +
                '<input type="text" class="form-control"> ' +
                '</div> ' +
                '<label class="control-label col-md-3 col-sm-3 col-xs-12">Тип визы</label> ' +
                '<div class="col-md-3 col-sm-3 col-xs-12"> ' +
                '<input type="text" class="form-control"> ' +
                '</div> ' +
                '<button type="button" class="btn btn-round delete-travel"><i class="fa fa-times"></i></button></div>');

            $('.delete-travel').on('click', function () {
                Stan.Travel.deleteField(this);
            });
        }
    },
    Experience: {
        deleteField: function (element) {

            Stan.deleteRecursive(element, 4);
            $(element).remove();
        },
        addField: function () {
            $('#experience').append('<hr>' +
                '<div class="form-group"> ' +
                '<label class="control-label col-md-3 col-sm-3 col-xs-12">Название компании</label> ' +
                '<div class="col-md-9 col-sm-9 col-xs-12"> ' +
                '<input type="text" class="form-control"> ' +
                '</div> ' +
                '</div> ' +
                '<div class="form-group"> ' +
                '<label class="control-label col-md-3 col-sm-3 col-xs-12">Должность</label> ' +
                '<div class="col-md-9 col-sm-9 col-xs-12"> ' +
                '<input type="text" class="form-control"> ' +
                '</div> ' +
                '</div> ' +
                '<div class="form-group"> ' +
                '<label class="control-label col-md-3 col-sm-3 col-xs-12">Период с (мм/гггг)</label> ' +
                '<div class="col-md-3 col-sm-3 col-xs-12"> ' +
                '<input type="text" class="form-control"> ' +
                '</div> ' +
                '<label class="control-label col-md-3 col-sm-3 col-xs-12">Период по (мм/гггг)</label> ' +
                '<div class="col-md-3 col-sm-3 col-xs-12"> ' +
                '<input type="text" class="form-control"> ' +
                '</div> ' +
                '</div><button type="button" class="btn btn-round delete-experience"><i class="fa fa-times"></i></button>');
            $('.delete-experience').on('click', function () {
                Stan.Experience.deleteField(this);
            });
        }
    },
    Relative: {
        deleteField: function (element) {
            Stan.log('Delete');
            $(element).prev().remove();
            $(element).remove();
        },
        addField: function () {
            var formGroup = document.createElement('div'),
                label = document.createElement('label'),
                div = document.createElement('div'),
                input = document.createElement('input'),
                deleteBtn = document.createElement('button'),
                i = document.createElement('i');

            deleteBtn.setAttribute('type', 'button');
            deleteBtn.className = 'btn btn-round delete-br-and-sis';
            i.className = 'fa fa-times';
            deleteBtn.appendChild(i);
            deleteBtn.onclick = function () {
                Stan.Relative.deleteField(deleteBtn);
            };
            formGroup.className = 'form-group';
            label.className = 'control-label col-md-3 col-sm-3 col-xs-12';
            label.innerText = 'Ф.И.О';
            div.className = 'col-md-9 col-sm-9 col-xs-12';
            input.setAttribute('type', 'text');
            input.className = 'form-control';

            formGroup.appendChild(label);
            formGroup.appendChild(div);
            div.appendChild(input);

            var broAndSis = document.getElementById('brothers-and-sisters');

            broAndSis.appendChild(formGroup);
            formGroup.parentNode.insertBefore(deleteBtn, formGroup.nextSibling);
        }
    },
    Modal: function (options) {
        var id = options.id;
        $('body').append(options.html);

        this.show = function (delay) {
            if (delay) {
                setTimeout(function () {
                    $('#' + id).modal('show');
                }, delay)
            } else {
                $('#' + id).modal('show');
            }
        };

        this.attachConfirm = function () {
            $('#' + id).find('.confirm').on('click', options.confirmHandler);
        };

        this.attachConfirm();
    }
};