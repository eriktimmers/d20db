$(function() {

    if ($(".cover").size() > 0) {
        $("#textcontainer").removeClass('liststyle').addClass('maintext');
        $("#sidbar").removeClass('hidden').addClass('sidebar');
        $(".cover").appendTo($("#sidbar")).removeClass('hidden');
    }

    $(".mainmenu").button();
    $(".menuhome").button({icons:{primary:'ui-icon-home'}});
    $(".menuback").button({icons:{primary:'ui-icon-seek-start'}});
    $(".menuedit").button({icons:{primary:'ui-icon-wrench'}});

});

