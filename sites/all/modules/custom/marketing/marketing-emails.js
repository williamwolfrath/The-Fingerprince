jQuery(document).ready(function($){

    // bind the sent email links to functions to pop up the email
    $('#fp-email-display').dialog({ autoOpen: false,
                                            modal: true,
                                            width: 600,
                                            height: 800,
                                            title: "Sent Email",
                                            position: ['center', 'top']});
    
    $('.fp-sent-email-popup').each(function() {
        $(this).bind('click', function() {
            var id = $(this).attr('href');  // id is stored as the href. is that bad?
            $('#fp-email-display').empty();
            $('#fp-email-display').load('marketing/sent/' + id + ' #fp-marketing-sent-email-full', {});
            $('#fp-email-display').dialog('open');
            return false;
        });
    });
    

    // hide the hidden sent emails and bind a click to show them
    $('.fp-sent-email-hidden').each(function() {
        $(this).hide();  
    });
    
    $('#fp-sent-email-more-link').click(function() {
        $('.fp-sent-email-hidden').each(function() {
            $(this).show();  
        });
        return false;
    });
    
    
    $('a#switch_oFCK_1').hide();
    
    // when a contact is clicked, make it the 'to address'
    $('div.view-marketing-contacts div.node h2 a').click(function() {
        $('form#marketing-emailform input#edit-to').val($(this).text());
        return false;
    });

});
