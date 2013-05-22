$(function() {

    $(".icon_delete").click(function(){
        if (confirm('Are you sure?')) {
            $(this).closest('.list_weapon').remove();
            $.get("/weapon/delete/" + $(this).attr('data-id') );
        }
    }); 

    $(".icon_copy").click(function(){
        if (confirm('Are you sure?')) {
            $.get("/weapon/copy/" + $(this).attr('data-id') );
        }
    }); 

    // formfield handle add/+
    $(".addsourcerow").click(function(){            
        var newNumber = Number( $("#numberofsourceforms").val()) + 1; 
        $("#numberofsourceforms").val(newNumber);
        $(this).parent().parent().clone(true, true).
                insertAfter($(this).parent().parent()).
                children().children(".src_id").
                attr('name', 'sourceform' + newNumber + '[src_id]').                
                siblings('.src_page').
                attr('name', 'sourceform' + newNumber + '[weso_page]');                       
    });        
    
    // formfield handle delete/-    
    $(".delsourcerow").click(function(){     
        var newNumber = Number( $("#numberofsourceforms").val()) - 1;
        $("#numberofsourceforms").val(newNumber);
        $(this).parent().parent().remove();
    });     

});

