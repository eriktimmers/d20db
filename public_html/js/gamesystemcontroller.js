$(function() {

    $(".icon_delete").click(function(){
        if (confirm('Are you sure?')) {
            $(this).closest('.list_systemname').remove();
            $.get("/gamesystem/delete/" + $(this).attr('data-id') );
        }
    }); 

});