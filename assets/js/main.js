import 'bootstrap-toggle/js/bootstrap-toggle.js';

let MainController = function () {
    let initBtnSwitch = () => {
        $('.btn-switch').removeClass('hide');
    };
    let toogleInput = () => {
        $('input[data-toggle="toggle"]').change(function () {
            console.log("Change");
        });
        return false;
    }
    let collapse = () => {
        $('.collapse').on('shown.bs.collapse', function () {
            $(this).parent().find('#btn-' + $(this).attr('id')).html('<i class="fa fa-minus-circle"></i>');
        }).on('hidden.bs.collapse', function () {
            $(this).parent().find('#btn-' + $(this).attr('id')).html('<i class="fa fa-plus-circle"></i>');
        });
    }

    let notification = () => {
        $('#notification').popover({
            animation: true,
            content: 'Aucun alert',
            placement: 'bottom',
            trigger: 'click',
            container: 'body',
            html: true
        })
    }

    // let oTable = function () {}
    return {
        init: () => {
            initBtnSwitch();
            toogleInput();
            collapse();
            notification();
        }
    }
}();

$(function () {
    MainController.init();
});
