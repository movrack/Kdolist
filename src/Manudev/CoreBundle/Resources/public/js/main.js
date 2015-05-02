define(['jquery', 'bootstrap'], function($, bootstrap){

    console.log('it\'s working');


    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
    });

});
