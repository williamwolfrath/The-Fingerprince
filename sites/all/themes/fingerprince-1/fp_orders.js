$(document).ready(function(){

    var etotal = 0.00;  // e book total
    var aetotal = 0.00;   // audio e book total

    // set the total based on what's currently in the fields
    // for when the form reloads on validation error
    var ebookCopies = 0; 
    var audioebookCopies = 0;
    
    // both empty, set total to zero
    if ( $('#edit-num-copies-e-book').val() == "" && $('#edit-num-copies-audio-e-book').val() == "" ) {
        $('#fp-order-total-amount').text('00'); 
    }
    else { // if either one has a value, add to total
        if ( !$('#edit-num-copies-e-book').val() == "" ) {
            ebookCopies = parseInt($('#edit-num-copies-e-book').val());
        }
        if ( !$('#edit-num-copies-audio-e-book').val() == "" ) {
            audioebookCopies = parseInt($('#edit-num-copies-audio-e-book').val());
        }
        etotal = ebookCopies * 5.00;
        aetotal = audioebookCopies * 10.00;
        $('#fp-order-total-amount').text(etotal + aetotal); 
    }

    // keyup functions
    $('#edit-num-copies-e-book').keyup(function(event) {
        var eCopies = parseInt($('#edit-num-copies-e-book').val());
        if ( eCopies > 0 && eCopies < 5 ) {
            etotal = eCopies * 5.00;
            $('#fp-order-total-amount').text(etotal + aetotal);  // show grand total
        }
        else {
            etotal = 0;
            $('#fp-order-total-amount').text(aetotal);  // show other total
        }
    });


    $('#edit-num-copies-audio-e-book').keyup(function(event) {
        var eCopies = parseInt($('#edit-num-copies-audio-e-book').val());
        if ( eCopies > 0 && eCopies < 5 ) {
            aetotal = eCopies * 10.00;
            $('#fp-order-total-amount').text(etotal + aetotal);  // show grand total
        }
        else {
            aetotal = 0;
            $('#fp-order-total-amount').text(etotal);  // show other total
        }
    });


    // support for highlighting email address boxes if the correct number is not filled in
    var quantityErrorDiv = $('.page-order-quantity .error');
    if ( !($(quantityErrorDiv).html() == null) ) {  // any error messages??
        // were emails left out?
        if ( $(quantityErrorDiv).html().indexOf("enter email addresses") > 0 ) {  // can't think of a better way to do this
            
            // E BOOKS
            var numEBooks = $('#edit-num-copies-e-book').val();
            var current = 1;
            $('input[id^=edit-e-book-email]').each(function() {
                if ( current <= numEBooks && $(this).val() == "" ) {
                    $(this).css({"borderColor":"red", "borderWidth":2});  // i hate this weird alternate css property name thing
                }
                current++;
            });
            
            // AUDIO E BOOKS
            var numAudioEBooks = $('#edit-num-copies-audio-e-book').val();
            current = 1;
            $('input[id^=edit-audio-e-book-email]').each(function() {
                if ( current <= numAudioEBooks && $(this).val() == "" ) {
                    $(this).css( {"borderColor":"red", "borderWidth":2});  // i hate this weird alternate css property name thing
                }
                current++;
            });
        }
    }


    // this relates to the contact page - should change the name of this file
    // since I'm combining other pieces here
    var contactusErrorDiv = $('body.page-contactus .error');
    if ( !($(contactusErrorDiv).html() == null ) ) {
        if ( $(contactusErrorDiv).html().indexOf("Please enter a value for email") > 0  ||
             $(contactusErrorDiv).html().indexOf("valid") > 0 ) {
            $('#fp-contactus-contactform #edit-sender-email').css( {"borderColor":"red", "borderWidth":2} );
        }
        
        if ( $(contactusErrorDiv).html().indexOf("Please enter the email text") > 0 ) {
            $('#fp-contactus-contactform #edit-email-body-1').css( {"borderColor":"red", "borderWidth":2} );
        }
    }

});