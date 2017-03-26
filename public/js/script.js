/**
 * Created by anassnadir on 2/27/17.
 */



$(document).ready(function(){


    var ul = $('#sidebar > ul');

    $('#sidebar > a').click(function(e)
    {
        e.preventDefault();
        var sidebar = $('#sidebar');
        if(sidebar.hasClass('open'))
        {
            sidebar.removeClass('open');
            ul.slideUp(250);
        } else
        {
            sidebar.addClass('open');
            ul.slideDown(250);
        }
    });

    $(window).resize(function()
    {
        if($(window).width() > 479)
        {
            ul.css({'display':'block'});
        }
        if($(window).width() < 479)
        {
            ul.css({'display':'none'});
        }
        if($(window).width() > 768)
        {
            $('#user-nav > ul').css({width:'auto',margin:'0'});
        }
    });

    if($(window).width() < 468)
    {
        ul.css({'display':'none'});
    }

    if($(window).width() > 479)
    {
        ul.css({'display':'block'});
    }

    $('.tip').tooltip();
    $('.tip-left').tooltip({ placement: 'left' });
    $('.tip-right').tooltip({ placement: 'right' });
    $('.tip-top').tooltip({ placement: 'top' });
    $('.tip-bottom').tooltip({ placement: 'bottom' });






});

function hover(element,src) {
    element.setAttribute('src', src);
}
function unhover(element,src) {
    element.setAttribute('src', src);
}

$('.inpHour').clockpicker({
    align: 'left',
    placement: 'top',
    autoclose: true,
    'default': 'now'
});
$('.datePicker').datepicker({
    inline: true,
    //nextText: '&rarr;',
    //prevText: '&larr;',
    showOtherMonths: true,
    dateFormat: 'yy-mm-dd',
    dayNamesMin: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
    //showOn: "button",
    //buttonImage: "img/calendar-blue.png",
    //buttonImageOnly: true,
});