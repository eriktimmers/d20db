$(function() {

    $(".icon_delete").click(function(){
        if (confirm('Are you sure?')) {
            $(this).closest('.list_feats').remove();
            $.get("/feat/delete/" + $(this).attr('data-id') );
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
                attr('name', 'subform' + newNumber + '[fts_page]');
        
    });        
    
    // formfield handle delete/-    
    $(".delrow").click(function(){     
        var newNumber = Number( $("#numberofsubforms").val()) - 1;
        $("#numberofsubforms").val(newNumber);
        $(this).parent().parent().remove();
    });     
    
    // formfield handle add/+
    $(".addtyperow").click(function(){            
        var newNumber = Number( $("#numberoftypes").val()) + 1; 
        $("#numberoftypes").val(newNumber);
        $(this).parent().parent().clone(true, true).
                insertAfter($(this).parent().parent()).
                children().children(".fty_id").
                attr('name', 'typeform' + newNumber + '[fty_id]');
        
    });        
    
    // formfield handle delete/-    
    $(".deltyperow").click(function(){     
        var newNumber = Number( $("#numberoftypes").val()) - 1;
        $("#numberoftypes").val(newNumber);
        $(this).parent().parent().remove();
    });    

});

