<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message error alert alert-danger" onclick="this.classList.add('hidden');">
    <?php 
        echo $message;
    ?>
</div>

