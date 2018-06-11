import 'bootstrap-toggle/js/bootstrap-toggle.js';

const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

let MainController = function () {
    let initBtnSwitch = () => {
        $('.btn-switch').removeClass('hide');
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
            trigger: 'click',
            container: 'body',
            html: true
        })
    }

    let toggleInput = () => {
        $('input[data-toggle="toggle"]').change(function () {
            let state = $(this).prop('checked');
            let id = $.trim($(this).attr('data-notify-id'));
            let url = null;
            if ($(this).data('type') == 'project') {
                url = Routing.generate('project_notification');
            } else {
                url = Routing.generate('instance_notification');
            }
            if (id) {
                ajaxRequest({id: id, url: url, state: state})
            }
        });
        return false;
    }

    let ajaxRequest = function (option) {
        $.getJSON(option.url, {
            id: option.id,
            state: option.state
        }).done(function (result) {
            console.log(result);
        })
        return false;
    }

    // let oTable = function () {}
    return {
        init: () => {
            initBtnSwitch();
            toggleInput();
            collapse();
            notification();
        }
    }
}();

$(function () {
    MainController.init();
});
