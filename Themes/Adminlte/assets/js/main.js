$(document).ready(function () {
    $('[data-slug="source"]').each(function(){
	    $(this).slug();
	});

    $(document).ajaxStart(function() { Pace.restart(); });

    Mousetrap.bind('f1', function() {
        window.open('https://asgardcms.com/docs', '_blank');
    });

    $('.selectize-single').selectize();

    $('.selectize-multiple').selectize({
        plugins: ['remove_button']
    });

    $(".datepicker").datepicker({
        format: "dd/mm/yyyy"
    });

    $(".has-datepicker").datepicker({
        format: "dd/mm/yyyy",
        setDate: new Date(),

    });
    setTimeout(function(){
        $(".has-datepicker").each(function(){
            if($(this).val() === "") {
                $(this).datepicker("setDate", new Date());
            }
        });
    });
});
