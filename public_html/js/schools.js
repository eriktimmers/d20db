$(function() {

    $(".icon_delete").click(function(){
        if (confirm('Are you sure?')) {
            
            if ($(this).attr("data-type") == 'school') {
                $(this).closest('.schools').remove();
                $.get("/school/schooldelete/" + $(this).attr('data-id') );                
            } else {
                $(this).closest('.subschools').remove();
                $.get("/school/subschooldelete/" + $(this).attr('data-id') );                                
            }
            
        }
    }); 



    

});

