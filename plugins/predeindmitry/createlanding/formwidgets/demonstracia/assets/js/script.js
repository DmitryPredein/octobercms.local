$(document).ready( function () {


  function deviceSelectedActions(typedevice){
    switch (typedevice) {
      case "Телефон":
        $('.deviceSelectedImages').removeClass('deviceSelectedImagesActive');
        $('.deviceSelectedPhone').addClass('deviceSelectedImagesActive');
        break;
      case "Ноутбук":
        $('.deviceSelectedImages').removeClass('deviceSelectedImagesActive');
        $('.deviceSelectedLaptop').addClass('deviceSelectedImagesActive');
        break;
      case "Планшет":
        $('.deviceSelectedImages').removeClass('deviceSelectedImagesActive');
        $('.deviceSelectedTablet').addClass('deviceSelectedImagesActive');
        break;
      default:
        return false;
    }
  }
  
    $('.deviceSelectedImages').click(function() {
     let priceDevice_check = '';
      switch($(this).attr('id')) {
        case 'deviceSelectedPhoneId':
          priceDevice_check = 'Телефон';
          deviceSelectedActions(priceDevice_check);
          $('.modelCheck').text('Модель не выбрана');
          break
        case 'deviceSelectedLaptopId':
          priceDevice_check = 'Ноутбук';
          deviceSelectedActions(priceDevice_check);
          $('.modelCheck').text('Модель не выбрана');
          break
        case 'deviceSelectedTabletId':
          priceDevice_check = 'Планшет';
          deviceSelectedActions(priceDevice_check);
          $('.modelCheck').text('Модель не выбрана');
          break
        default:
          return false;
      }
    });

    $(".modelBox").mouseenter(function(){
    if(!(/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) || !(window.matchMedia('(max-width: 860px)').matches)){
      $(this).children(".img_modelBox").animate({
  	      "margin-bottom": "10px", // высота элемента
  	   }, 200);
     }
    });
    $(".modelBox").mouseleave(function(){
      if(!(/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) || !(window.matchMedia('(max-width: 860px)').matches)){
      $(this).children(".img_modelBox").animate({
  	      "margin-bottom": "-30px", // высота элемента
  	   }, 200);
     }
    });

    $('.slider').slick({
      responsive: [
        {
          breakpoint: 4000,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 700,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 426,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            centerMode: true,
            variableWidth: true
          }
        },
      ]
    });

    $('.sliderNavBar').slick({
      slidesToShow: 3,
      responsive: [
        {
          breakpoint: 1050,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 700,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });

    $('.trackComment').slick({
      responsive: [
        {
          breakpoint: 4000,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 1330,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 860,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });


});
