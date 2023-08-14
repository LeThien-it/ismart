$(document).ready(function () {
  // start homebanner
  var sync1 = $('#sync1')
  var sync2 = $('#sync2')
  var slidesPerPage = 4 //globaly define number of elements per page
  var syncedSecondary = false

  sync1
    .owlCarousel({
      items: 1,
      // slideSpeed: 5000,
      nav: true,
      autoplay: true,
      autoplayTimeout: 5000,
      loop: true,
      dots: false,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1,
          nav: false,
          dots: true,
        },
        600: {
          items: 1,
          nav: false,
          dots: true,
        },
        768: {
          items: 1,
          nav: true,
        },
      },
    })
    .on('changed.owl.carousel', syncPosition)

  sync2
    .on('initialized.owl.carousel', function () {
      sync2.find('.owl-item').eq(0).addClass('current synced')
    })
    .owlCarousel({
      items: slidesPerPage,
      dots: false,
      nav: false,
      slideBy: 1, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
      rewind: false,
    })
    .on('changed.owl.carousel', syncPosition2)

  function syncPosition(el) {
    //if you set loop to false, you have to restore this next line
    // var current = el.item.index;

    //if you disable loop you have to comment this block
    var count = el.item.count - 1
    var current = Math.round(el.item.index - el.item.count / 2 - 0.5)

    if (current < 0) {
      current = count
    }
    if (current > count) {
      current = 0
    }

    //end block

    sync2
      .find('.owl-item')
      .removeClass('current synced')
      .eq(current)
      .addClass('current synced')
    var onscreen = sync2.find('.owl-item.active').length - 1
    var start = sync2.find('.owl-item.active').first().index()
    var end = sync2.find('.owl-item.active').last().index()

    if (current > end) {
      sync2.data('owl.carousel').to(current, 100, true)
    }
    if (current < start) {
      sync2.data('owl.carousel').to(current - onscreen, 100, true)
    }
  }

  function syncPosition2(el) {
    if (syncedSecondary) {
      var number = el.item.index
      sync1.data('owl.carousel').to(number, 100, true)
    }
  }

  sync2.on('click', '.owl-item', function (e) {
    e.preventDefault()
    var number = $(this).index()
    sync1.data('owl.carousel').to(number, 300, true)
    $('.owl-carousel').trigger('stop.owl.autoplay')
    var carousel = $('.owl-carousel').data('owl.carousel')
    $('.owl-carousel').trigger('refresh.owl.carousel')
  })

  // end homebanner

  //slider-product
  $('.slider-product').owlCarousel({
    loop: false,
    margin: 0,
    nav: true,
    dots: false,
    responsive: {
      0: {
        items: 2,
      },
      460: {
        items: 3,
      },
      768: {
        items: 4,
      },
      1025: {
        items: 5,
      },
    },
  })

  $('.banner-cat-main').owlCarousel({
    items: 1,
    loop: true,
    nav: true,
    margin: 0,
    dots: false,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
        nav: false,
        dots: true,
      },
      768: {
        items: 1,
        nav: true,
        dots: false,
      },
    },
  })

  $('.same-product').owlCarousel({
    loop: false,
    nav: true,
    margin: 0,
    dots: false,
    responsive: {
      0: {
        items: 2,
      },
      460: {
        items: 3,
      },
      768: {
        items: 4,
      },
      1025: {
        items: 5,
      },
    },
  })

  //end slider-product

  // start homebanner
  var syncBig = $('#sync-big')
  var syncSmall = $('#sync-small')
  var slidesPerPage = 4 //globaly define number of elements per page
  var syncedSecondary1 = false

  syncBig
    .owlCarousel({
      items: 1,
      // slideSpeed: 5000,
      nav: true,
      autoplay: true,
      autoplayTimeout: 5000,
      loop: true,
      dots: false,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1,
          nav: false,
        },
        600: {
          items: 1,
          nav: false,
        },
        768: {
          items: 1,
          nav: true,
        },
      },
    })
    .on('changed.owl.carousel', syncPosition3)

  syncSmall
    .on('initialized.owl.carousel', function () {
      syncSmall.find('.owl-item').eq(0).addClass('current synced')
    })
    .owlCarousel({
      items: slidesPerPage,
      dots: false,
      nav: false,
      slideBy: 1,
      rewind: false,
      margin: 20,
      responsive: {
        0: {
          items: 4,
        },
        800: {
          items: 5,
        },
        992: {
          items: 4,
        },
      },
    })
    .on('changed.owl.carousel', syncPosition4)

  function syncPosition3(el) {
    //if you set loop to false, you have to restore this next line
    // var current = el.item.index;

    //if you disable loop you have to comment this block
    var count = el.item.count - 1
    var current = Math.round(el.item.index - el.item.count / 2 - 0.5)

    if (current < 0) {
      current = count
    }
    if (current > count) {
      current = 0
    }

    //end block

    syncSmall
      .find('.owl-item')
      .removeClass('current synced')
      .eq(current)
      .addClass('current synced')
    var onscreen = syncSmall.find('.owl-item.active').length - 1
    var start = syncSmall.find('.owl-item.active').first().index()
    var end = syncSmall.find('.owl-item.active').last().index()

    if (current > end) {
      syncSmall.data('owl.carousel').to(current, 100, true)
    }
    if (current < start) {
      syncSmall.data('owl.carousel').to(current - onscreen, 100, true)
    }
  }

  function syncPosition4(el) {
    if (syncedSecondary1) {
      var number = el.item.index
      syncBig.data('owl.carousel').to(number, 100, true)
    }
  }

  syncSmall.on('click', '.owl-item', function (e) {
    e.preventDefault()
    var number = $(this).index()
    syncBig.data('owl.carousel').to(number, 300, true)
    $('.owl-carousel').trigger('stop.owl.autoplay')
    var carousel = $('.owl-carousel').data('owl.carousel')
    $('.owl-carousel').trigger('refresh.owl.carousel')
  })

  // end homebanner

  //LOAD MORE
  $('.loadmoredesc').click(function (e) {
    e.preventDefault()
    $('.desc_cat .load-content').css('height', 'auto')
    $(this).hide()
  })

  //  SCROLL TOP
  $(window).scroll(function () {
    if ($(this).scrollTop() != 0) {
      $('#btn-top').stop().fadeIn(150)
    } else {
      $('#btn-top').stop().fadeOut(150)
    }
  })
  $('#btn-top').click(function () {
    $('body,html').stop().animate({ scrollTop: 0 }, 800)
  })

  //  EVEN MENU RESPON
  $('html').on('click', function (event) {
    var target = $(event.target)
    var site = $('#site')

    if (target.is('#btn-respon i')) {
      if (!site.hasClass('show-respon-menu')) {
        site.addClass('show-respon-menu')
      } else {
        site.removeClass('show-respon-menu')
      }
    } else {
      $('#wrapper').click(function () {
        if (site.hasClass('show-respon-menu')) {
          site.removeClass('show-respon-menu')
          return false
        }
      })
    }
  })

  //  MENU RESPON
  $('#main-menu-respon li .sub-menu').after(
    '<span class="fa fa-angle-right arrow"></span>',
  )
  $('#main-menu-respon li .arrow').click(function () {
    if ($(this).parent('li').hasClass('open')) {
      $(this).parent('li').removeClass('open')
    } else {
      //            $('.sub-menu').slideUp();
      //            $('#main-menu-respon li').removeClass('open');
      $(this).parent('li').addClass('open')
      //            $(this).parent('li').find('.sub-menu').slideDown();
    }
  })

  $('#search-ajax').keyup(function () {
    var href = $(this).data('url')
    var key = $(this).val()
    if (key != '') {
      $.ajax({
        url: href,
        method: 'GET',
        data: { key: key },
        dataType: 'json',
        success: function (data) {
          if (data.code == 200) {
            console.log('hihi')
            $('#search-result').fadeIn()
            $('#search-result').html(data.text)
          }
        },
      })
    } else {
      $('#search-result').fadeOut()
    }
  })
})

function tab() {
  var tab_menu = $('#tab-menu li')
  tab_menu.stop().click(function () {
    $('#tab-menu li').removeClass('show')
    $(this).addClass('show')
    var id = $(this).find('a').attr('href')
    $('.tabItem').hide()
    $(id).show()
    return false
  })
  $('#tab-menu li:first-child').addClass('show')
  $('.tabItem:first-child').show()
}
