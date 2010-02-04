<?php

?>
<div id='fp-sent-email' <?php if ( $hide_email == true ): ?>class='fp-sent-email-hidden' <?php else: ?>class='fp-sent-email-visible'<?php endif; ?>>
<a href="<?php print $sent_email->eid; ?>" class="fp-sent-email-popup">
    <span class="fp-marketing-email-date"><?php print $sent_email->date_used; ?></span></a><br/>
    <?php print $sent_email->to_address; ?><br/>
</div>
<?php if ( $show_more_link ): ?>
<div id='fp-sent-email-more'>
    <a href="#" id='fp-sent-email-more-link'>Show more sent emails</a>
</div>
<?php endif; ?>