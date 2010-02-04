<img src="http://www.thefingerprince.com/sites/default/files/fp_letterhead_top_640.jpg" />
<div style="width: 640px; background: white; font-family: Arial; font-size: 14px;">
    
<div id="fp-order-conf-email" class="fp-printable">
    <div id="fp-order-conf-email-text">
        
        <?php if ( $order->num_copies_e_book > 0 ): ?>
            <div id="fp-order-printable-conf-e-books">
            e book @ $5.00 each: 
                <?php print $order->num_copies_e_book; ?>
                    <?php if ($order->num_copies_e_book == 1) {
                        print " copy ";
                    }
                    else {
                        print " copies ";
                    }
                ?>
                $<?php print ($order->num_copies_e_book * 5); ?>.00 
            <?php if ($order->num_copies_e_book > 0): ?>
                    <br/>email to:<br/>
                    <?php foreach ( $order->e_book_emails as $ebe ): ?>
                        <?php print $ebe; ?><br/>
                    <?php endforeach; ?>
            <?php endif; ?>
            </div>
        <?php endif; ?>
        <br/>
        <?php if ( $order->num_copies_audio_e_book > 0 ): ?>
            <div id="fp-order-printable-conf-audio-e-books">
            audio e book @ $10.00 each:
                <?php print $order->num_copies_audio_e_book; ?>
                    <?php if ($order->num_copies_audio_e_book == 1) {
                        print " copy ";
                    }
                    else {
                        print " copies ";
                    }
                ?>
                $<?php print ($order->num_copies_audio_e_book * 10); ?>.00 
            <?php if ( $order->num_copies_audio_e_book > 0 ): ?>
                    <br/>email to:<br/>
                    <?php foreach ( $order->audio_e_book_emails as $aebe ): ?>
                        <?php print $aebe; ?><br/>
                    <?php endforeach; ?>
            <?php endif; ?>
            </div>
        <?php endif; ?>
        <div id="fp-order-printable-conf-totals" <?php if ( $order->num_copies_audio_e_book == 0 ) { print 'class="fp-move-left"'; } else { print 'class="fp-move-right"'; } ?>
            total charges <span class="fp-order-conf-book-highlight">$<?php print $order->total; ?>.00</span><br/>
            credit card <?php print $order->cc; ?><br/>
            <span class="fp-order-conf-book-highlight"><?php print $order->acct; ?></span><br/>
            All Finger Prince print books ordered separately.
        </div>
    </div>

</div>
    
</div>
