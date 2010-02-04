<?php

?>

<div id="fp-order-review-page">
    <div id="fp-order-review-page-order">
            <h3>your order</h3>
            <?php
            global $user;
            if ( $user->name=="peter" || $user->name=="misha") : ?>
              <h4 class="redtext">this order will not be charged.</h4>
            <?php endif; ?>
            <?php if ($order->num_copies_e_book > 0): ?>
                <b><?php print $order->num_copies_e_book; ?></b> e books<br/>
                To the following email addresses:<br/>
                <ul>
                    <?php foreach ( $order->e_book_emails as $ebe ): ?>
                        <li><?php print $ebe; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php if ( $order->num_copies_audio_e_book > 0 ): ?>
                <b><?php print $order->num_copies_audio_e_book; ?></b> audio e books<br/>
                To the following email addresses:<br/>
                <ul>
                    <?php foreach ( $order->audio_e_book_emails as $aebe ): ?>
                        <li><?php print $aebe; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <h4>Billing Info:</h4>
            Card Type: <?php print $order->payment_info['CREDITCARDTYPE']; ?><br/>
            Account Number: ************<?php print substr($order->payment_info['ACCT'], -4); ?><br/>
            Exp Date: <?php print substr($order->payment_info['EXPDATE'], 0,2) . "/" . substr($order->payment_info['EXPDATE'], -4); ?><br/>
            Buyer Email: <?php print $order->buyer_email; ?><br/>
            <br/>
            Total: $<?php print $total; ?>.00
            <?php print $blankform; ?>
    </div>
<div id="fp-order-review-links">
<?php
// the only good way to insert the fp links block into the node div
$block = module_invoke('block', 'block', 'view', 2);
print $block['content'];
?>
</div>
</div>
