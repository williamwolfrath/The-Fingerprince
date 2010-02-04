<img src="http://fingerprince-dev.wilwolf.com/sites/default/files/fp_letterhead_top_large_640.jpg" />
<div style="width: 640px; background: white; font-family: Arial; font-size: 14px;">
    
<div id="fp-order-conf-email">
    <div id="fp-order-conf-email-text">
        <?php if ($order_type == 'audio' ): ?>
            <?php print $order->from_name; ?> has purchased a copy of the audio e book "The Fingerprince" for you. In order to receive your e book, please click <a href="http://bookguardpro.com/thank_you.php?aid=185&pid=649&code=9JEJ82CS">here.</a><br/>
            <b>Once you are viewing the book, you may drag the URL from the web address bar onto your desktop for easier access, or bookmark the page in your browser.</b>
        <?php else: ?>
            <?php print $order->from_name; ?> has purchased a copy of the e book "The Fingerprince" for you. In order to receive your e book, please click <a href="http://bookguardpro.com/thank_you.php?aid=185&pid=551&code=G9GGSG76">here.</a><br/>
            <b>Once you are viewing the book, you may drag the URL from the web address bar onto your desktop for easier access, or bookmark the page in your browser.</b>
        <?php endif; ?>

</div>
    
</div>
