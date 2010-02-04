<?php
// To display the full contents of a sent email.
?>

<div id="fp-marketing-sent-email-full">
    <span class="fp-email-label">Date:</span> <?php print $sent_email->date_used; ?><br/>
    <span class="fp-email-label">To: </span><?php print $sent_email->to_address; ?><br/>
    <span class="fp-email-label">Subject: </span><?php print $sent_email->subject; ?><br/>
    <div class="fp-email-body"><?php print $sent_email->email_body; ?></div>
</div>