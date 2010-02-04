<?php

?>

<div id="fp-order-form-page">
<div id="fp-order-form-form">
<?php print $rform; ?>
</div>
<div id="fp-order-form-links">
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