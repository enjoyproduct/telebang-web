jssor_1_slider_init = function() {
  var jssor_1_options = {
    $AutoPlay: false,
    $SlideWidth: 400,
    $Cols: 2,
    $Align: 200,
    $ArrowNavigatorOptions: {
      $Class: $JssorArrowNavigator$
    },
    $BulletNavigatorOptions: {
      $Class: $JssorBulletNavigator$
    }
  };

  var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

  /*responsive code begin*/
  /*remove responsive code if you don't want the slider scales while window resizing*/
  function ScaleSlider() {
      var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
      if (refSize) {
          refSize = Math.min(refSize, 1900);
          jssor_1_slider.$ScaleWidth(refSize);
      }
      else {
          window.setTimeout(ScaleSlider, 30);
      }
  }
  ScaleSlider();
  $Jssor$.$AddEvent(window, "load", ScaleSlider);
  $Jssor$.$AddEvent(window, "resize", ScaleSlider);
  $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
  /*responsive code end*/
};
jssor_carousel = function() {
  var jssor_1_options = {
    $AutoPlay: true,
    $AutoPlaySteps: 3,
    $SlideDuration: 160,
    $SlideWidth: 250,
    $SlideSpacing: 30,
    $Cols: 3,
    $ArrowNavigatorOptions: {
      $Class: $JssorArrowNavigator$,
      $Steps: 3
    },
    $BulletNavigatorOptions: {
      $Class: $JssorBulletNavigator$,
      $SpacingX: 8,
      $SpacingY: 1
    }
  };

  var jssor_1_slider = new $JssorSlider$("jssor_2", jssor_1_options);

  /*responsive code begin*/
  /*remove responsive code if you don't want the slider scales while window resizing*/
  function ScaleSlider() {
      var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
      if (refSize) {
          refSize = Math.min(refSize, 1170);
          jssor_1_slider.$ScaleWidth(refSize);
      }
      else {
          window.setTimeout(ScaleSlider, 30);
      }
  }
  ScaleSlider();
  $Jssor$.$AddEvent(window, "load", ScaleSlider);
  $Jssor$.$AddEvent(window, "resize", ScaleSlider);
  $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
  /*responsive code end*/
};
jssor_carousel_category = function() {
  var jssor_1_options = {
    $AutoPlay: false,
    $AutoPlaySteps: 2,
    $SlideDuration: 160,
    $SlideWidth: 380,
    $SlideSpacing: 30,
    $Cols: 2,
    $ArrowNavigatorOptions: {
      $Class: $JssorArrowNavigator$,
      $Steps: 2
    },
    $BulletNavigatorOptions: {
      $Class: $JssorBulletNavigator$,
      $SpacingX: 8,
      $SpacingY: 1
    }
  };

  var jssor_1_slider = new $JssorSlider$("jssor_3", jssor_1_options);

  /*responsive code begin*/
  /*remove responsive code if you don't want the slider scales while window resizing*/
  function ScaleSlider() {
      var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
      if (refSize) {
          refSize = Math.min(refSize, 1170);
          jssor_1_slider.$ScaleWidth(refSize);
      }
      else {
          window.setTimeout(ScaleSlider, 30);
      }
  }
  ScaleSlider();
  $Jssor$.$AddEvent(window, "load", ScaleSlider);
  $Jssor$.$AddEvent(window, "resize", ScaleSlider);
  $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
  /*responsive code end*/
};
slider_category = function(){
  $('#cssmenu ul ul li:odd').addClass('odd');
  $('#cssmenu ul ul li:even').addClass('even ');
  $('#cssmenu > ul > li > a').click(function() {
    $('#cssmenu li').removeClass('active');
    $(this).closest('li').addClass('active');    
    var checkElement = $(this).next();
    if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
      $(this).closest('li').removeClass('active ');
      checkElement.slideUp('normal');
    }
    if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
      $('#cssmenu ul ul:visible').slideUp('normal');
      checkElement.slideDown('normal');
    }
    if($(this).closest('li').find('ul').children().length == 0) {
      return true;
    } else {
      return false;    
    }        
  });
}
show_description = function(){
    var minimized_elements = $('.description');
    minimized_elements.each(function(){    
        var t = $(this).text();        
        if(t.length < 560) return;
        
        $(this).html(
            t.slice(0,560)+'<span class="showmore">... </span><a href="#" class="more btn-showmore">Show More</a>'+
            '<span  class="showless" style="display:none;">'+ t.slice(560,t.length)+' <br><a href="#" class="less btn-showmore">Show Less</a></span>'
        );
    }); 
    
    $('a.more', minimized_elements).click(function(event){
        event.preventDefault();
        $(this).hide().prev().hide(500);
        $(this).next().show(500);        
    });
    
    $('a.less', minimized_elements).click(function(event){
        event.preventDefault();
        $(this).parent().hide(500).prev().show().prev().show();    
    });

    $("#clickcomment").click(function() {
      $('html,body').animate({
          scrollTop: $("#comment").offset().top},
          'slow');
    });
    (function($){
      $('#like-button').click(function(){
        likeVideo();
      });
    })(jQuery);

    
};

likeVideo = function() {
  if( user_id == 0) {
    alert('login to like this video');
    return ;
  }
  $.ajax({
    url: "api/likeVideo",
    method: "post",
    data:{
      'customer_id':user_id,
      'video_id':video_id
    },
    success:function(response){
      var response = JSON.parse(response);
      if(response.code === 1) {
        if(response.content.action == 'liked') {
          $('#likeIcon').html('<i class="fa fa-thumbs-up" aria-hidden="true"></i>');
        } else if (response.content.action == 'unLike') {
          $('#likeIcon').html('<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>');
        }
      } else{
        alert('fail');
      }
    }
  });
}