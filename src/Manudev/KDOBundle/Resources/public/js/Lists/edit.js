define(['jquery'], function($){
    function addOwnerForm($collectionHolder) {
        // Get the data-prototype and the index
        var prototype = $collectionHolder.data('prototype');

        var index = $collectionHolder.data('index');
        console.log(index);

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);
        $('#ownerTemplate .ownerForm').html(newForm);
        var form = $('#ownerTemplate').children();

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an div
        form.clone().appendTo($collectionHolder);
        $('#ownerTemplate .ownerForm').html();
    }

    $(document).ready(function() {
        ////
        // Delete owner
        $('#owners').on('click', '.deleteOwner', function(e) {
            e.preventDefault();
            $(this).parent().parent().remove();
        });

        ////
        // Add owner
        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item and finally, add the form
        $('#owners').data('index', $(this).find(':input').length);
        $('#add_owner_link').on('click', function(e) {
            e.preventDefault();
            addOwnerForm($('#owners'));
        });
    });
});