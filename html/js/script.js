$('.product-slider').owlCarousel({
  loop: true,
  margin: 10,
  nav: false,
  navText: ["<img src='images/15.png'>", "<img src='images/16.png'>"],
  dots: false,
  center: true,
  autoplay: true,
  autoplayTimeout: 3000,
  autoplayHoverPause: true,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 3
    },
    1000: {
      items: 3
    }
  }
})

$('.client-review').owlCarousel({
  loop: true,
  margin: 10,
  dots: false,
  nav: true,
  autoplay: true,
  autoplayTimeout: 3000,
  autoplayHoverPause: true,
  navText: ["<img src='images/20.png'>", "<img src='images/21.png'>"],
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 1
    },
    1000: {
      items: 1
    }
  }
})

$('.product-img').owlCarousel({
  loop: false,
  margin: 5,
  nav: false,
  dots:false,
  autoplay: true,
  autoplayTimeout: 3000,
  autoplayHoverPause: true,
  dots: true,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 1
    },
    1000: {
      items: 1
    }
  }
})


$('.inner-slides').owlCarousel({
  loop:true,
  margin:10,
  nav:false,
  dots:false,
  responsive:{
      0:{
          items:1
      },
      600:{
          items:1
      },
      1000:{
          items:1
      }
  }
})

$(document).ready(function () {
  $('#main-layout').click(
    function () {  
    $(this).find("#main-box-layout").slideToggle('fast')
    },
  )
})



$(document).ready(function () {
  $('.click-li').click(
    function () {  
    $(this).find(".menu-drop").slideToggle('fast')
    },
  )
})

// increment decrement js 

$(document).ready(function () {
  $('.minus-1').click(function (e) {
    e.preventDefault()
    let input = $(this).next()
    if (parseInt(input.val()) > 0) {
      if (parseInt(input.val()) - 0 == 0) {
        input.val(parseInt(2))
      }else {
        input.val(parseInt(input.val()) - 2)
      }
    }
  })
  $('.plus-1').click(function (e) {
    e.preventDefault()
    let input = $(this).prev()
    input.val(parseInt(input.val()) + 2)
  })
})
// increment decrement js

const typedTextSpan = document.querySelector('.typed-text')
const cursorSpan = document.querySelector('.cursor')

const textArray = ['When You Need it']
const typingDelay = 200
const erasingDelay = 100
const newTextDelay = 2000 // Delay between current and next text
let textArrayIndex = 0
let charIndex = 0

function type () {
  if (charIndex < textArray[textArrayIndex].length) {
    if (!cursorSpan.classList.contains('typing'))
      cursorSpan.classList.add('typing')
    typedTextSpan.textContent += textArray[textArrayIndex].charAt(charIndex)
    charIndex++
    setTimeout(type, typingDelay)
  } else {
    cursorSpan.classList.remove('typing')
    setTimeout(erase, newTextDelay)
  }
}

function erase () {
  if (charIndex > 0) {
    if (!cursorSpan.classList.contains('typing'))
      cursorSpan.classList.add('typing')
    typedTextSpan.textContent = textArray[textArrayIndex].substring(
      0,
      charIndex - 1
    )
    charIndex--
    setTimeout(erase, erasingDelay)
  } else {
    cursorSpan.classList.remove('typing')
    textArrayIndex++
    if (textArrayIndex >= textArray.length) textArrayIndex = 0
    setTimeout(type, typingDelay + 1100)
  }
}

document.addEventListener('DOMContentLoaded', function () {
  // On DOM Load initiate the effect
  if (textArray.length) setTimeout(type, newTextDelay + 250)
})


     


