<?php

?>

<div id="fp-contact-us-page">
<?php print $rform; ?>
<div id="fp-contact-us-links">
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