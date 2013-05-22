$(function() {

    $(".icon_delete").click(function(){
        if (confirm('Are you sure?')) {
            $(this).closest('.list_spells').remove();
            $.get("/spell/delete/" + $(this).attr('data-id') );
        }
    }); 

    $(".icon_copy").click(function(){
        if (confirm('Are you sure?')) {
            $.get("/spell/copy/" + $(this).attr('data-id') );
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
                attr('name', 'sourceform' + newNumber + '[spc_page]');                       
    });        
    
    // formfield handle delete/-    
    $(".delsourcerow").click(function(){     
        var newNumber = Number( $("#numberofsourceforms").val()) - 1;
        $("#numberofsourceforms").val(newNumber);
        $(this).parent().parent().remove();
    });     

    // formfield handle add/+
    $(".addclassrow").click(function(){            
        var newNumber = Number( $("#numberofclassforms").val()) + 1; 
        $("#numberofclassforms").val(newNumber);
        $(this).parent().parent().clone(true, true).
                insertAfter($(this).parent().parent()).
                children().children(".cls_id").
                attr('name', 'classform' + newNumber + '[cls_id]').                
                siblings('.cls_level').
                attr('name', 'classform' + newNumber + '[spcl_level]');                       
    });        
    
    // formfield handle delete/-    
    $(".delclassrow").click(function(){     
        var newNumber = Number( $("#numberofclassforms").val()) - 1;
        $("#numberofclassforms").val(newNumber);
        $(this).parent().parent().remove();
    });  

    // formfield handle add/+
    $(".adddomainrow").click(function(){            
        var newNumber = Number( $("#numberofdomainforms").val()) + 1; 
        $("#numberofdomainforms").val(newNumber);
        $(this).parent().parent().clone(true, true).
                insertAfter($(this).parent().parent()).
                children().children(".dom_id").
                attr('name', 'domainform' + newNumber + '[dom_id]').                
                siblings('.dom_level').
                attr('name', 'domainform' + newNumber + '[spdm_level]');                       
    });        
    
    // formfield handle delete/-    
    $(".deldomainrow").click(function(){     
        var newNumber = Number( $("#numberofdomainforms").val()) - 1;
        $("#numberofdomainforms").val(newNumber);
        $(this).parent().parent().remove();
    });  

    // formfield handle add/+
    $(".adddescriptorrow").click(function(){            
        var newNumber = Number( $("#numberofdescriptorforms").val()) + 1; 
        $("#numberofdescriptorforms").val(newNumber);
        $(this).parent().parent().clone(true, true).
                insertAfter($(this).parent().parent()).
                children().children(".dcp_id").
                attr('name', 'descriptorform' + newNumber + '[dcp_id]');                       
    });        
    
    // formfield handle delete/-    
    $(".deldescriptorrow").click(function(){     
        var newNumber = Number( $("#numberofdescriptorforms").val()) - 1;
        $("#numberofdescriptorforms").val(newNumber);
        $(this).parent().parent().remove();
    });  
});

