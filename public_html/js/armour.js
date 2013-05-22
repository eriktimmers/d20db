$(function() {

    $(".icon_delete").click(function(){
        if (confirm('Are you sure?')) {
            $(this).closest('.list_armour').remove();
            $.get("/armour/delete/" + $(this).attr('data-id') );
        }
    }); 

    $(".icon_copy").click(function(){
        if (confirm('Are you sure?')) {
            $.get("/armour/copy/" + $(this).attr('data-id') );
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
                attr('name', 'sourceform' + newNumber + '[arso_page]');                       
    });        
    
    // formfield handle delete/-    
    $(".delsourcerow").click(function(){     
        var newNumber = Number( $("#numberofsourceforms").val()) - 1;
        $("#numberofsourceforms").val(newNumber);
        $(this).parent().parent().remove();
    });     

});

