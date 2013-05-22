$(function() {

    $(".icon_delete").click(function(){
        if (confirm('Are you sure?')) {
            $(this).closest('.list_classes').remove();
            $.get("/class/delete/" + $(this).attr('data-id') );
        }
    }); 
    
    // formfield handle add/+
    $(".addrow").click(function(){            
        var newNumber = Number( $("#numberofsubforms").val()) + 1; 
        $("#numberofsubforms").val(newNumber);
        $(this).parent().parent().clone(true, true).
                insertAfter($(this).parent().parent()).
                children().children(".src_id").
                attr('name', 'subform' + newNumber + '[src_id]').                
                siblings('.src_page').
                attr('name', 'subform' + newNumber + '[clso_page]');
                css({background: 'red'}); //;
        
    });        
    
    // formfield handle delete/-    
    $(".delrow").click(function(){     
        var newNumber = Number( $("#numberofsubforms").val()) - 1;
        $("#numberofsubforms").val(newNumber);
        $(this).parent().parent().remove();
    });     

});

