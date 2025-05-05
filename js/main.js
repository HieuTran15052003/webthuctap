(function($) {
	"use strict"

	// Mobile Nav toggle
	$('.menu-toggle > a').on('click', function (e) {
		e.preventDefault();
		$('#responsive-nav').toggleClass('active');
	})

	// Fix cart dropdown from closing
	$('.cart-dropdown').on('click', function (e) {
		e.stopPropagation();
	});

	/////////////////////////////////////////

	// Products Slick
	$('.products-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
			slidesToShow: 4,
			slidesToScroll: 4,
			autoplay: true,
			infinite: true,
			speed: 300,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
			responsive: [{
	        breakpoint: 991,
	        settings: {
	          slidesToShow: 2,
	          slidesToScroll: 1,
	        }
	      },
	      {
	        breakpoint: 480,
	        settings: {
	          slidesToShow: 1,
	          slidesToScroll: 1,
	        }
	      },
	    ]
		});
	});

	// Products Widget Slick
	$('.products-widget-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
			infinite: true,
			autoplay: true,
			speed: 300,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
		});
	});

	/////////////////////////////////////////

	// Product Main img Slick
	$('#product-main-img').slick({
    infinite: true,
    speed: 300,
    dots: false,
    arrows: true,
    fade: true,
    asNavFor: '#product-imgs',
  });

	// Product imgs Slick
  $('#product-imgs').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    centerMode: true,
    focusOnSelect: true,
		centerPadding: 0,
		vertical: true,
    asNavFor: '#product-main-img',
		responsive: [{
        breakpoint: 991,
        settings: {
					vertical: false,
					arrows: false,
					dots: true,
        }
      },
    ]
  });

	// Product img zoom
	var zoomMainProduct = document.getElementById('product-main-img');
	if (zoomMainProduct) {
		$('#product-main-img .product-preview').zoom();
	}

	/////////////////////////////////////////

})(jQuery);
// Review form handling
document.addEventListener('DOMContentLoaded', function() {
    const reviewForm = document.querySelector('.review-form');
    const stars = document.querySelectorAll('input[name="rating"]');
    
    // Update visual stars when rating is selected
    stars.forEach(star => {
        star.addEventListener('change', function() {
            const rating = this.value;
            updateStarDisplay(rating);
        });
    });

    function updateStarDisplay(rating) {
        stars.forEach((star, index) => {
            const label = star.nextElementSibling;
            if (index < rating) {
                label.classList.add('active');
            } else {
                label.classList.remove('active');
            }
        });
    }

    function addReviewToList(review) {
        const reviewsList = document.querySelector('.reviews');
        const currentDate = new Date().toLocaleString();
        
        const reviewHTML = `
            <li>
                <div class="review-heading">
                    <h5 class="name">${review.name}</h5>
                    <p class="date">${currentDate}</p>
                    <div class="review-rating">
                        ${generateStarRating(review.rating)}
                    </div>
                </div>
                <div class="review-body">
                    <p>${review.review}</p>
                </div>
            </li>
        `;
        
        reviewsList.insertAdjacentHTML('afterbegin', reviewHTML);
        updateAverageRating();
    }

    function generateStarRating(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            stars += `<i class="fa fa-star${i <= rating ? '' : '-o empty'}"></i>`;
        }
        return stars;
    }

    function updateAverageRating() {
        // Fetch updated rating data from server
        fetch('get_ratings.php')
            .then(response => response.json())
            .then(data => {
                document.querySelector('.rating-avg span').textContent = data.average;
                // Update rating distribution
                updateRatingDistribution(data.distribution);
            })
            .catch(error => console.error('Error updating ratings:', error));
    }

    function updateRatingDistribution(distribution) {
        const ratingBars = document.querySelectorAll('.rating-progress div');
        const ratingSums = document.querySelectorAll('.rating .sum');
        
        distribution.forEach((count, index) => {
            ratingBars[index].style.width = `${(count / distribution.total) * 100}%`;
            ratingSums[index].textContent = count;
        });
    }
});


// paypal.Buttons({
// 	style: {
// 	shape: "rect",
// 	layout: "vertical",
// 	color: "blue",
// 	label: "paypal",
// 	},
// 	createOrder: function(data, actions) {
// 		var tongtien = document.getElementById('tongtien').value;
// 		return actions.order.create({
// 			purchase_units: [{
// 				amount: {
// 					value: tongtien
// 				}
// 			}]
// 		});
// 	},
// 	onApprove: function(data, actions) {
// 		return actions.order.capture().then(function(details) {
// 			alert('Thanh toán thành công! Cảm ơn ' + details.payer.name.given_name);
// 			console.log(details);
// 			window.location.href = 'http://localhost/web1/index.php?management=thanks&pay=paypal';
// 		});
// 	},
// 	onCancel: function(data) {
// 		window.location.href = 'http://localhost/web1/index.php?management=payment_information';
// 	}
// }).render('#paypal-button-container');
// Show the first tab and hide the rest
$('#tabs-nav li:first-child').addClass('active');
$('.tab-content').hide();
$('.tab-content:first').show();

// Click function
$('#tabs-nav li').click(function(){
$('#tabs-nav li').removeClass('active');
$(this).addClass('active');
$('.tab-content').hide();

var activeTab = $(this).find('a').attr('href');
$(activeTab).fadeIn();
return false;
});

document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const responsiveNav = document.getElementById('responsive-nav');
    
    menuToggle.addEventListener('click', function() {
        responsiveNav.classList.toggle('active');
    });
});



