

$(document).ready(function () {

	/*js start /messages modal form/ start*/
	$('#message_cross_success').click(function () {
		$('#message_modal_success')
  			.animate({opacity: 0}, 250, function () {
  				$(this).css('display', 'none');
  		});
	});
	$('#message_dop_cross_success').click(function () {
		$("#message_modal_success .message_modal_container").toggleClass('show_animate');
		$("#message_modal_success .message_modal_container").toggleClass('hide_animate');
	});
	$('#message_cross_wrong').click(function () {
		$("#message_modal_wrong").addClass('hide_animate');
	});
	$('#message_dop_cross_wrong').click(function () {
		$("#message_modal_wrong .message_modal_container").toggleClass('show_animate');
		$("#message_modal_wrong .message_modal_container").toggleClass('hide_animate');
	});
	/* js end /messages modal form/ end */

	$(document).on('click','.modul_button_pay',function (e) {
		$(this).closest('form').find('.modal_wrapper').css('display', 'block')
     		.animate({opacity: 1}, 150);
  	});

	$('.modal_wrapper .dm-cell').click(function (e) {
		var div = $(".modal_wrapper .dm-cell");
		if ( div.has(e.target).length === 0) { // и не по его дочерним элементам
	   $('.modal_wrapper')
			.animate({opacity: 0}, 100, function () {
				$(this).css('display', 'none');
			});
	 }
  	});

  	$(document).on('click','.modal_close_button', function () {
	   $('.modal_wrapper')
			.animate({opacity: 0}, 100, function () {
				$(this).css('display', 'none');
		});
  	});
  	$(document).on('click','.modal_button_form', function () {
	   $('.modal_wrapper')
			.animate({opacity: 0}, 100, function () {
				$(this).css('display', 'none');
		});
  	});

  	$('.modal_first .dm-cell').click(function (e) {
  		var div = $(".modal_first .dm-cell");
  		if ( div.has(e.target).length === 0) { // и не по его дочерним элементам
	       $('.modal_first')
  			.animate({opacity: 0}, 100, function () {
  				$(this).css('display', 'none');
  			});
	     }
  	});

  	$('.modul_button_second').click(function () {
  		$('.modal_second')
  			.css('display', 'block')
     		.animate({opacity: 1}, 150);
  	});

  	$('.modal_second .dm-cell').click(function (e) {
  		var div = $(".modal_second .dm-cell");
  		if ( div.has(e.target).length === 0) { // и не по его дочерним элементам
	       $('.modal_second')
  			.animate({opacity: 0}, 100, function () {
  				$(this).css('display', 'none');
  			});
	     }
  	});

  	$('.modul_button_fird').click(function () {
  		$('.modal_fird')
  			.css('display', 'block')
     		.animate({opacity: 1}, 150);
  	});

  	$('.modal_fird .dm-cell').click(function (e) {
  		var div = $(".modal_fird .dm-cell");
  		if ( div.has(e.target).length === 0) { // и не по его дочерним элементам
	       $('.modal_fird')
  			.animate({opacity: 0}, 100, function () {
  				$(this).css('display', 'none');
  			});
	     }
  	});
  	
  	$('.modul_button_fourth').click(function () {
  		$('.modal_fourth')
  			.css('display', 'block')
     		.animate({opacity: 1}, 150);
  	});

  	$('.modal_fourth .dm-cell').click(function (e) {
  		var div = $(".modal_fourth .dm-cell");
  		if ( div.has(e.target).length === 0) { // и не по его дочерним элементам
	       $('.modal_fourth')
  			.animate({opacity: 0}, 100, function () {
  				$(this).css('display', 'none');
  			});
	     }
  	});
  	$(".modal_button_panel").click(function() {
	 	$('.modal_first')
  			.animate({opacity: 0}, 100, function () {
  				$(this).css('display', 'none');
  			});
  		$('.modal_second')
  			.animate({opacity: 0}, 100, function () {
  				$(this).css('display', 'none');
  			});
  		$('.modal_fird')
  			.animate({opacity: 0}, 100, function () {
  				$(this).css('display', 'none');
  			});
  		$('.modal_fourth')
  			.css('display', 'block')
     		.animate({opacity: 1}, 150);
	})


  	// $(".modal_types input").on('click',function() {
	//   $(".type-form").addClass('modal_dn');
	//   $(".type-form").animate({left: '0px'});	
	//   var activeType = $(this).val();
	//   $(".modal_type_"+activeType).removeClass('modal_dn');	
	//   $(".modal_type_"+activeType).animate({left: '250px'});	
	// })




	

	$(document).on("change keyup input click","[data-number]", function() {
		if (this.value.match(/[^0-9]/g)) {
		this.value = this.value.replace(/[^0-9]/g, '');
		}
	});

	$('.modal_summ').bind("change keyup input click", function() {
		if (this.value.match(/[^0-9]/g)) {
		this.value = this.value.replace(/[^0-9]/g, '');
		}
	});
	$(".modal_panel_item_head").click(function(e) {
	  /*$(this).toggleClass('modal_panel_item_active');
	  $(this).removeClass('modal_panel_item_unactive');*/
	  $(this).parents(".modal_panel_item").toggleClass("modal_panel_item_active");
	})
    $(document).on('click',".modal_pricelist_button", function () {
        var elementClick = $(this).attr("href");
        var destination = $(elementClick).offset().top;
        $('html,body').animate({ scrollTop: destination }, 500); //1100 - скорость
        return false; 
    });
    $(document).on('click',".modal_pricelist_button", function () {
    	setTimeout(function () {
			$(".modal_footer_link_price").addClass("animated wobble");
		}, 600); // время в мс
		setTimeout(function () {
			$(".modal_footer_link_price").removeClass("animated wobble");
			$(".modal_prised").css('display', 'block')
     		.animate({opacity: 1}, 350);
		}, 1600);
    });
     $(".modal_footer_link_price").click(function () {
    	$(".modal_prised").css('display', 'block')
     		.animate({opacity: 1}, 350);
     });
});

function modal_form() {
    // здесь отрисовка канвы
    $(document).ready(function () {
  		$('.message_success')
  			.css('display', 'block')
     		.animate({opacity: 1}, 350);
  	});
    return false;
}


function fileSelected(el, target){
	$(target).text(el.files.item(0).name);
}