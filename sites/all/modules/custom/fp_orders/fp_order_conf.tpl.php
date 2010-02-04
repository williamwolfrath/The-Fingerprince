<?php

?>

<div id="fp-order-conf-page">
    <div id="fp-order-conf-page-text">
        
        <?php if ( $order->num_copies_e_book > 0 ): ?>
            <div id="fp-order-conf-e-books">
            e book @ $5.00 each<br/>
            <span class="fp-order-conf-book-highlight">
                <?php print $order->num_copies_e_book; ?>
                    <?php if ($order->num_copies_e_book == 1) {
                        print " copy ";
                    }
                    else {
                        print " copies ";
                    }
                ?>
                $<?php print ($order->num_copies_e_book * 5); ?>.00 
            </span>
            <?php if ($order->num_copies_e_book > 0): ?>
                    email to<br/>
                    <?php foreach ( $order->e_book_emails as $ebe ): ?>
                        <?php print $ebe; ?><br/>
                    <?php endforeach; ?>
            <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <?php if ( $order->num_copies_audio_e_book > 0 ): ?>
            <div id="fp-order-conf-audio-e-books">
            audio e book @ $10.00 each<br/>
            <span class="fp-order-conf-book-highlight">
                <?php print $order->num_copies_audio_e_book; ?>
                    <?php if ($order->num_copies_audio_e_book == 1) {
                        print " copy ";
                    }
                    else {
                        print " copies ";
                    }
                ?>
                $<?php print ($order->num_copies_audio_e_book * 10); ?>.00 
            </span>
            <?php if ( $order->num_copies_audio_e_book > 0 ): ?>
                    email to<br/>
                    <?php foreach ( $order->audio_e_book_emails as $aebe ): ?>
                        <?php print $aebe; ?><br/>
                    <?php endforeach; ?>
            <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div id="fp-order-conf-totals" <?php if ( $order->num_copies_audio_e_book == 0 ) { print 'class="fp-move-left"'; } else { print 'class="fp-move-right"'; } ?>
            total charges <span class="fp-order-conf-book-highlight">$<?php print $order->total; ?>.00</span><br/>
            credit card <?php print $order->cc; ?><br/>
            <span class="fp-order-conf-book-highlight"><?php print $order->acct; ?></span><br/>
            All Finger Prince print<br/>
            books ordered separately.
            <br/><br/>
            Click <?php echo l("here", "order-conf-printable"); ?> for a <br/>printable confirmation.
        </div>
    </div>
<div id="fp-order-conf-links">
<?php
// the only good way to insert the fp links block into the node div
$block = module_invoke('block', 'block', 'view', 2);
print $block['content'];
?>
</div>
</div>
<pre>
<?php //print check_plain(print_r($rform, true)); ?>
</pre>