$(function() {

    $(".icon_delete").click(function(){
        if (confirm('Are you sure?')) {
            $(this).closest('.list_sources').remove();
            $.get("/source/delete/" + $(this).attr('data-id') );
        }
    }); 

});

