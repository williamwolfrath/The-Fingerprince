<?php

?>
<div id="fp-order-quantity-page">
    <div id="fp-order-quantity-text-left">
        If you are ordering an e book<br/>
        and a print book, please<br/>
        complete the e book order<br/>
        before ordering the print book.<br/>
        If ordering only the print book<br/>
        proceed to the far right of the<br/>
        order form and select the<br/>
        wholesaler.
    </div>
    <div id="fp-order-quantity-text-e-book">
        e book $5.00
    </div>
    <div id="fp-order-quantity-text-audio-e-book">
        audio e book $10.00
        <div id="fp-order-total">total $<span id="fp-order-total-amount">00</span>.00</div>
    </div>
    <div id="fp-order-quantity-text-right">
        To order a 8 1/2 x 11<br/>
        full color, perfect bound,<br/>
        soft cover copy<br/>
        click below.<br/>
        <a id="fp-amazon-link" href="http://www.amazon.com/Finger-Prince-Peter-Begley/dp/0615261531/ref=sr_1_1?ie=UTF8&s=books&qid=1249956621&sr=1-1"><img src="/sites/default/files/buy-from-amazon.gif" /></a>
        <a id="fp-bn-link" href="http://search.barnesandnoble.com/The-Finger-Prince/Peter-Begley/e/9780615261539/?itm=1"><img src="/sites/default/files/BNBuy.gif" /></a>
    </div>
<div id="fp-order-quantity-form">
<?php print $rform; ?>
</div>
<div id="fp-order-quantity-form-links">
<?php
// the only good way to insert the fp links block into the node div
$block = module_invoke('block', 'block', 'view', 2);
print $block['content'];
?>
</div>
</div>
<pre>
<?php //print print_r(array_values($form)); ?>
</pre>