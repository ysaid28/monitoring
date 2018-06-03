import 'bootstrap-toggle/js/bootstrap-toggle.js';

let MainController = function () {
    let toogleInput = function () {
        $('input[data-toggle="toggle"]').change(function () {
            console.log("Change");
        });
        return false;
    }
    let collapse = function () {
        $('.collapse').on('shown.bs.collapse', function () {
            $(this).parent().find('#btn-' + $(this).attr('id')).html('<i class="fa fa-minus-circle"></i>');
        }).on('hidden.bs.collapse', function () {
            $(this).parent().find('#btn-' + $(this).attr('id')).html('<i class="fa fa-plus-circle"></i>');
        });
    }

    
    let oTable = function () {
      
    }

    return {
        init: function () {
            toogleInput();
            collapse();
        }
    }
}();

$(function () {
    MainController.init();
});
