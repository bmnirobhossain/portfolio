/**
 * Block Carousel
 */
const { GHOSTKIT, jQuery: $ } = window;
const $doc = $(document);

function getSwiperVersion(Swiper) {
  let ver = 8;

  // in version 8 added new parameter `maxBackfaceHiddenSlides`.
  if (typeof Swiper.defaults.maxBackfaceHiddenSlides === 'undefined') {
    ver = 7;
  }

  // in version 7 added new parameter `rewind`.
  if (typeof Swiper.defaults.rewind === 'undefined') {
    ver = 6;
  }

  // in version 6 added new parameter `loopPreventsSlide`.
  if (typeof Swiper.defaults.loopPreventsSlide === 'undefined') {
    ver = 5;
  }

  return ver;
}

/**
 * Prepare Carousels.
 */
$doc.on('initBlocks.ghostkit', (e, self) => {
  if (typeof window.Swiper === 'undefined') {
    return;
  }

  GHOSTKIT.triggerEvent('beforePrepareCarousels', self);

  $('.ghostkit-carousel:not(.ghostkit-carousel-ready)').each(function () {
    const $carousel = $(this);
    const $items = $carousel.children('.ghostkit-carousel-items');
    const effect = $carousel.attr('data-effect') || 'slide';
    const slidesPerView = parseInt($carousel.attr('data-slides-per-view'), 10);

    const options = {
      speed: (parseFloat($carousel.attr('data-speed')) || 0) * 1000,
      effect,
      fadeEffect: {
        // fixed fade out for previous slider.
        crossFade: true,
      },
      spaceBetween: parseFloat($carousel.attr('data-gap')) || 0,
      centeredSlides: $carousel.attr('data-centered-slides') === 'true',
      freeMode: {
        enabled: $carousel.attr('data-free-scroll') === 'true',
      },
      loop: $carousel.attr('data-loop') === 'true',
      // This feature is cool, but not working properly when loop enabled
      // and fast clicking on previous button is not working properly
      // https://github.com/nolimits4web/swiper/issues/5945
      // loopPreventsSlide: false,
      autoplay: parseFloat($carousel.attr('data-autoplay')) > 0 && {
        delay: parseFloat($carousel.attr('data-autoplay')) * 1000,
        disableOnInteraction: false,
      },
      navigation: $carousel.attr('data-show-arrows') === 'true' && {
        nextEl: '.ghostkit-carousel-arrow-next',
        prevEl: '.ghostkit-carousel-arrow-prev',
      },
      pagination: $carousel.attr('data-show-bullets') === 'true' && {
        el: '.ghostkit-carousel-bullets',
        clickable: true,
        dynamicBullets: $carousel.attr('data-dynamic-bullets') === 'true',
      },
      slidesPerView: 1,
      keyboard: true,
      grabCursor: true,
      preloadImages: false,

      // fixes text selection when swipe in the items gap.
      touchEventsTarget: 'container',

      // disable swiping on some elements.
      noSwipingSelector: 'input, textarea, .ghostkit-image-compare',
    };

    $carousel.addClass('ghostkit-carousel-ready swiper');
    $items.addClass('swiper-wrapper');
    $items.children().addClass('swiper-slide');

    // add arrows
    if (options.navigation) {
      let $prevArrowIcon = $carousel.find('.ghostkit-carousel-arrow-prev-icon');
      let $nextArrowIcon = $carousel.find('.ghostkit-carousel-arrow-next-icon');

      if ($prevArrowIcon.length) {
        $prevArrowIcon = $prevArrowIcon.html();
      } else if ($carousel.attr('data-arrow-prev-icon')) {
        $prevArrowIcon = `<span class="${$carousel.attr('data-arrow-prev-icon')}"></span>`;
      } else {
        $prevArrowIcon = '';
      }

      if ($nextArrowIcon.length) {
        $nextArrowIcon = $nextArrowIcon.html();
      } else if ($carousel.attr('data-arrow-next-icon')) {
        $nextArrowIcon = `<span class="${$carousel.attr('data-arrow-next-icon')}"></span>`;
      } else {
        $nextArrowIcon = '';
      }

      $carousel.append(`
        <div class="ghostkit-carousel-arrow ghostkit-carousel-arrow-prev">${$prevArrowIcon}</div>
        <div class="ghostkit-carousel-arrow ghostkit-carousel-arrow-next">${$nextArrowIcon}</div>
      `);
    }

    // add bullets
    if (options.pagination) {
      $carousel.append('<div class="ghostkit-carousel-bullets"></div>');
    }

    // calculate responsive.
    const breakPoints = {};
    if (effect !== 'fade' && !Number.isNaN(slidesPerView)) {
      let count = slidesPerView;
      let currentPoint = Math.min(self.screenSizes.length - 1, count - 1);

      for (; currentPoint >= 0; currentPoint -= 1) {
        if (count > 0 && typeof self.screenSizes[currentPoint] !== 'undefined') {
          breakPoints[self.screenSizes[currentPoint] + 1] = {
            slidesPerView: count,
          };
        }
        count -= 1;
      }

      options.slidesPerView = count || 1;
    }
    options.breakpoints = breakPoints;

    // Events.
    options.on = {
      // These events used to add fixes for
      // conflict with custom cursor movement.
      touchStart(swiper, evt) {
        GHOSTKIT.triggerEvent('swiperTouchStart', self, swiper, evt);
      },
      touchMove(swiper, evt) {
        GHOSTKIT.triggerEvent('swiperTouchMove', self, swiper, evt);
      },
      touchEnd(swiper, evt) {
        GHOSTKIT.triggerEvent('swiperTouchEnd', self, swiper, evt);
      },
    };

    // Fallbacks for old Swiper versions.
    (() => {
      const swiperVersion = getSwiperVersion(window.Swiper);

      // Since v7 used container class `swiper`, we should also add old `swiper-container` class.
      if (swiperVersion < 7) {
        $carousel.addClass('swiper-container');
      }

      // Since v7 freeMode options moved under `freeMode` object.
      if (swiperVersion < 7) {
        options.freeMode = options.freeMode.enabled;
      }

      // Since v5 `breakpointsInverse` option is removed and it is now `true` by default, but in older versions it was `false`.
      if (swiperVersion >= 5) {
        options.breakpointsInverse = true;
      }
    })();

    // init swiper
    // eslint-disable-next-line no-new
    new window.Swiper($carousel[0], options);

    // autoplay hover pause.
    if ($carousel.attr('data-autoplay-hover-pause') === 'true' && options.autoplay) {
      $carousel.on('mouseenter', () => {
        $carousel[0].swiper.autoplay.stop();
      });
      $carousel.on('mouseleave', () => {
        $carousel[0].swiper.autoplay.start();
      });
    }
  });

  GHOSTKIT.triggerEvent('afterPrepareCarousels', self);
});

/**
 * Re-create slides duplicates.
 * https://github.com/nolimits4web/swiper/issues/2629
 */
function reinitDuplicates($item) {
  const $carousels = $item.parents('[data-loop="true"].ghostkit-carousel-ready');

  $carousels.each(function () {
    if (this.swiper) {
      const $slide = $item.closest('.swiper-slide');

      // Copy the content of duplicated slide to original when changed content inside duplicated slide.
      if ($slide.length && $slide.hasClass('swiper-slide-duplicate')) {
        const $originalSlide = $slide.siblings(
          `[data-swiper-slide-index="${$slide.attr(
            'data-swiper-slide-index'
          )}"]:not(.swiper-slide-duplicate):eq(0)`
        );

        $originalSlide.html($slide.html());

        // Recreate loop when changed content inside original slide.
      } else if ($slide.length) {
        this.swiper.loopDestroy();
        this.swiper.loopCreate();
      }
    }
  });
}

$doc.on(
  'activateTab.ghostkit afterActivateAccordionItem.ghostkit movedImageCompare.ghostkit dismissedAlert.ghostkit',
  (e, self, $item) => {
    reinitDuplicates($item);
  }
);

$doc.on('animatedCounters.ghostkit', (e, self, item) => {
  reinitDuplicates(item.$el);
});
