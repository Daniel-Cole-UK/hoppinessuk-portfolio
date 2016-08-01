$(document).ready(function() {
    $('#fullpage').fullpage({
        resize: false,
        controlArrows: false,
        scrollingSpeed:1000,
        loopHorizontal: false,
        scrollOverflow: true,
        scrollBar: false,
        afterSlideLoad: function( anchorLink, index, slideAnchor, slideIndex){
            var loadedSlide = $(this);

            //first slide of the second section
            if(anchorLink == 'about' && slideAnchor == 'label-design'){
                $.fn.fullpage.setAllowScrolling(false, 'up');
                $.fn.fullpage.setKeyboardScrolling(false, 'up');
                $('#backArrow').removeClass('hidden');
            }
        },
        onSlideLeave: function( anchorLink, index, slideIndex, direction, nextSlideIndex){
            var leavingSlide = $(this);

            //leaving the first slide of the 2nd Section to the right
            if(anchorLink == 'about' && direction == 'left'){
                $.fn.fullpage.setAllowScrolling(true, 'up');
                $.fn.fullpage.setKeyboardScrolling(true, 'up');
                $('#backArrow').addClass('hidden');
            }
        },
        afterRender: function(){
var pluginContainer = $(this);
			
$('.buttons').click(function() {
    $(this).blur();
});
	
var date_input=$('input[name="deliveryDate"]');
var options={
format: 'dd/mm/yyyy',
disableTouchKeyboard: true,	
todayHighlight: true,	
weekStart: 1,
daysOfWeekDisabled: [0],
startDate: '+28d',	
autoclose: true,
};
date_input.datepicker(options); 		

$.fn.clearForm = function() {
  return this.each(function() {
    var type = this.type, tag = this.tagName.toLowerCase();
    if (tag == 'form')
      return $(':input',this).clearForm();
    if (type == 'text' || tag == 'textarea')
      this.value = '';
    else if (type == 'checkbox' || type == 'radio')
      this.checked = false;
    else if (tag == 'select')
      this.selectedIndex = 0;
  });
};			
			
// order form
    $('form').submit(function(event) {
    $('.form-group').removeClass('has-error'); // remove the error class
    $('.help-block').remove(); // remove the error text        
        
// get the form data
    var formData = {
		'designs' : $('select[name=designs]').val(),
		'deliveryDate' : $('input[name=deliveryDate]').val(),
		'pale' : $('input[name=pale]:checked').val(),
		'ipa' : $('checkbox[name=ipa]:checked').val(),
		'stout' : $('checkbox[name=stout]:checked').val(),
		'quantity' : $('select[name=quantity]').val(),
		'nameTag' : $('select[name=nameTag]').val(),
		'nameTagText' : $('input[name=nameTagText]').val(),
		'wrapping' : $('select[name=wrapping]').val(),
		'ribbon' : $('select[name=ribbon]').val(),
        'firstName' : $('input[name=firstName]').val(),
        'surname' : $('input[name=surname]').val(),
		'email' : $('input[name=email]').val(),
		'phone' : $('input[name=phone]').val(),
		'postcode' : $('input[name=postcode]').val(),
		'houseNum' : $('input[name=houseNum]').val(),
		'flat' : $('input[name=flat]').val(),
		'city' : $('input[name=city]').val(),
		'county' : $('select[name=county]').val(),
		'company' : $('input[name=company]').val(),
		'address1' : $('input[name=address1]').val(),
		'address2' : $('input[name=address2]').val(),
        'requirements' : $('textarea[name=requirements]').val()
        };
// process the form
    $.ajax({
        type        : 'POST',
        url         : '/quote/process.php',
        data        : formData, //data object
        dataType    : 'json', 
        encode      : true
    })
	
// Connected
        .done(function(data) {
       
// Handle errors
        if ( ! data.success) {
$('#successMessage').addClass('alertHidden');			
     // handle errors for delivery date
            if (data.errors.deliveryDate) {
                $('#deliveryDate').addClass('has-error'); // add the error class to show red
				$('#errorMessage').append('<div class="help-block">' + data.errors.deliveryDate + '</div>');
                $('#errorMessage').removeClass('alertHidden');
				$('#errorMessage').addClass('animated flipInX');
            }            

     // handle errors for beer type
            if (data.errors.pale) {
                $('#beerType').addClass('has-error'); // add the error class to show red
				$('#errorMessage').append('<div class="help-block">' + data.errors.pale + '</div>');
                $('#errorMessage').removeClass('alertHidden');
				$('#errorMessage').addClass('animated flipInX');
                
            }
			
     // handle errors for beer type
            if (data.errors.quantity) {
                $('#quantity').addClass('has-error'); // add the error class to show red
				$('#errorMessage').append('<div class="help-block">' + data.errors.quantity + '</div>');
                $('#errorMessage').removeClass('alertHidden');
				$('#errorMessage').addClass('animated flipInX');
                
            }
			
     // handle errors for first name
            if (data.errors.firstName) {
                $('#firstName').addClass('has-error'); // add the error class to show red
				$('#errorMessage').append('<div class="help-block">' + data.errors.firstName + '</div>');
                $('#errorMessage').removeClass('alertHidden');
				$('#errorMessage').addClass('animated flipInX');
                
            }			

     // handle errors for surname
            if (data.errors.surname) {
                $('#surname').addClass('has-error'); // add the error class to show red
				$('#errorMessage').append('<div class="help-block">' + data.errors.surname + '</div>');
                $('#errorMessage').removeClass('alertHidden');
				$('#errorMessage').addClass('animated flipInX');
                
            }
			
     // handle errors for email
            if (data.errors.email) {
                $('#email').addClass('has-error'); // add the error class to show red
				$('#errorMessage').append('<div class="help-block">' + data.errors.email + '</div>');
                $('#errorMessage').removeClass('alertHidden');
				$('#errorMessage').addClass('animated flipInX');
                
            }
			
     // handle errors for postcode
            if (data.errors.postcode) {
                $('#postcode').addClass('has-error'); // add the error class to show red
				$('#errorMessage').append('<div class="help-block">' + data.errors.postcode + '</div>');
                $('#errorMessage').removeClass('alertHidden');
				$('#errorMessage').addClass('animated flipInX');
                
            }
			
     // handle errors for house number
            if (data.errors.houseNum) {
                $('#houseNum').addClass('has-error'); // add the error class to show red
				$('#errorMessage').append('<div class="help-block">' + data.errors.houseNum + '</div>');
                $('#errorMessage').removeClass('alertHidden');
				$('#errorMessage').addClass('animated flipInX');
                
            }
			
     // handle errors for city
            if (data.errors.city) {
                $('#city').addClass('has-error'); // add the error class to show red
				$('#errorMessage').append('<div class="help-block">' + data.errors.city + '</div>');
                $('#errorMessage').removeClass('alertHidden');
				$('#errorMessage').addClass('animated flipInX');
                
            }
			
     // handle errors for county
            if (data.errors.county) {
                $('#county').addClass('has-error'); // add the error class to show red
				$('#errorMessage').append('<div class="help-block">' + data.errors.county + '</div>');
                $('#errorMessage').removeClass('alertHidden');
				$('#errorMessage').addClass('animated flipInX');
                
            }	

     // handle errors for address1
            if (data.errors.address1) {
                $('#address1').addClass('has-error'); // add the error class to show red
				$('#errorMessage').append('<div class="help-block">' + data.errors.address1 + '</div>');
                $('#errorMessage').removeClass('alertHidden');
				$('#errorMessage').addClass('animated flipInX');
                
            }				

        } else {
            // Tell user order is placed
			$('#errorMessage').removeClass('animated flipInX');
			$('#errorMessage').addClass('alertHidden');
            $('#successMessage').removeClass('alertHidden');
			$('#successMessage').addClass('animated flipInX');
			$("input[type='email']").val('');
			$("input[type='tel']").val('');
			$('form').clearForm();
        }
            
            
            })
        
// Call failed
.fail(function(data) {
     
});        
        
        // stop the form from submitting and refreshing the page
        event.preventDefault();
    });
        }        
    })
    
});