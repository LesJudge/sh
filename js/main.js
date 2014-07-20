function author() {
    console.log('Csige Imre | imre.csige@gekko-marketing.com');
}

function hide_n_show($hide, $show) {
    $($hide).fadeOut('fast');
    $($show).fadeIn('slow');
}

function toggle_current($hide, $show) {
    $($hide).toggleClass('current');
    $("#"+$show).toggleClass('current');
}

function get_hide() {
    
    if ($('#experience').is(":visible")) {
        return '#experience';
    } else if ($('#hotel').is(":visible")) {
        return '#hotel';
    } else if ($('#guests').is(":visible")) {
        return '#guests';
    } else if ($('#conference').is(":visible")) {
        return '#conference';
    } else if ($('#party').is(":visible")) {
        return '#party';
    }
}

function hide_all_button() {
    $('#button1').hide();
    $('#button2').hide();
    $('#button3').hide();
    $('#button4').hide();
    $('#button5').hide();
    $('.fixed-hotline-footer').hide();
}

function get_show_button(clicked) {
    
    if (clicked === '#experience') {
        return '#button1';
    } else if (clicked === '#hotel') {
        return '#button2';
    } else if (clicked === '#guests') {
        return '#button3';
    } else if (clicked === '#conference') {
        return '#button4';
    } else if (clicked === '#party') {
        return '#button5';
    }
}

function get_hide_current() {
    
    if ($('#link_experience').hasClass("current")) {
        return '#link_experience';
    } else if ($('#link_hotel').hasClass("current")) {
        return '#link_hotel';
    } else if ($('#link_guests').hasClass("current")) {
        return '#link_guests';
    } else if ($('#link_conference').hasClass("current")) {
        return '#link_conference';
    } else if ($('#link_party').hasClass("current")) {
        return '#link_party';
    }
}

function get_show_current_text() {
    
    if ($('#link_experience').hasClass("current")) {
        return '#button1';
    } else if ($('#link_hotel').hasClass("current")) {
        return '#button2';
    } else if ($('#link_guests').hasClass("current")) {
        return '#button3';
    } else if ($('#link_conference').hasClass("current")) {
        return '#button4';
    } else if ($('#link_party').hasClass("current")) {
        return '#button5';
    }
}

function collision($div1, $div2) {
      var x1 = $div1.offset().left;
      var y1 = $div1.offset().top;
      var h1 = $div1.outerHeight(true);
      var w1 = $div1.outerWidth(true);
      var b1 = y1 + h1;
      var r1 = x1 + w1;
      var x2 = $div2.offset().left;
      var y2 = $div2.offset().top;
      var h2 = $div2.outerHeight(true);
      var w2 = $div2.outerWidth(true);
      var b2 = y2 + h2;
      var r2 = x2 + w2;

      if (b1 < y2 || y1 > b2 || r1 < x2 || x1 > r2) return false;
      return true;
}

$(document).ready(function() {
    
    var first = true;
    
    $('a#link_hotel, a#link_experience, a#link_guests, a#link_conference, a#link_party').bind("click",function(e){
        e.preventDefault();
        var $show = $(this).attr("href");
        var $hide = get_hide();
        var $hide_current = get_hide_current();
        var $show_current = $(this).attr("id");
        
        toggle_current($hide_current, $show_current);
        hide_n_show($hide, $show);
        
        /**/
        hide_all_button(); 
        var $show_button = get_show_button($show);
        
        console.log('show: '+$show_button);
        
        $($show_button).fadeIn('slow');
        $('.fixed-hotline-footer').fadeIn('slow');
        $($show_button).css('display', 'block');
        return false;
    });
    
    $('#menu>ul>li>a').bind("click",function(e){
        e.preventDefault();
        
        $('html, body').animate({
            scrollTop: $( this ).offset().top
        }, 500);
        
        return false;
    });
    
    $('#lang_select').bind("click", function(){
        $('.button').removeClass('hidden');
    });
    
    $('#lang_select a').bind("click", function(e){
        
        if (first == true) {
            e.preventDefault();
        }
        
        first = false;
    });
    
    var hashTagActive = "";
    $(".scroll").click(function (event) {
        if(hashTagActive != this.hash) { 
            event.preventDefault();
            
            var dest = 0;
            if ($(this.hash).offset().top > $(document).height() - $(window).height()) {
                dest = $(document).height() - $(window).height();
            } else {
                dest = $(this.hash).offset().top;
            }
            
            $('html,body').animate({
                scrollTop: dest
            }, 1000, 'swing');
            hashTagActive = this.hash;
        }
    });

    $(window).scroll(function() {

       if($(window).scrollTop() + $(window).height() == $(document).height()) {
           $( '.foot-fixed-bottom' ).css( "margin-bottom", "60px" );
           $( '.foot-fixed-bottom-small' ).css( "margin-bottom", "60px" );
       } else {
           $( '.foot-fixed-bottom' ).css( "margin-bottom", "0" );
           $( '.foot-fixed-bottom-small' ).css( "margin-bottom", "0" );
       }

       if($(window).scrollTop() + $(window).height() > $('#slider_video').height() +215) {
           $( '.foot-fixed-bottom' ).fadeIn();
           var button = get_show_current_text();
           $(button).fadeIn();
           $(button).css('display', 'block');
       } else {
           $( '.foot-fixed-bottom' ).fadeOut();
       }
    });
    
    if (window.location.pathname == '/packages' && LAYER_PATH !== '') {
        
        $.get('/'+ LAYER_PATH,function(data){
			$.modal(data,{opacity:80, close: true, overlayClose: true});
		},'html');
                
        if (CAN_BOOK === false) {
            
            $('a.this-link').removeAttr("href");
            $('div.this').addClass('grey');
        }        
    }

});