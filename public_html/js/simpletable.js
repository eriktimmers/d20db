$(function() {

    $(".icon_delete").click(function(){
        if (confirm('Are you sure?')) {
            $(this).closest('.list_systemname').remove();
            $.get("/simpletable/" + $(this).attr('data-type') + "/delete/" + $(this).attr('data-id') );
        }
    }); 

});