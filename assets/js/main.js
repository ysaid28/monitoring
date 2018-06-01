import 'bootstrap-toggle/js/bootstrap-toggle.js';

let MainController = () => {
    let toogleInput = () => {
        $('input[data-toggle="toggle"]').change(function () {
            console.log("Change");
        });
        return false;
    }

    return {
        init: () => {
            toogleInput();
        }
    }
}
MainController.init();
