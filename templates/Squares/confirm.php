<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Square $square
 */
?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Squares'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="squares payment form content">
        <?= "nonce is ".$nonce ?>
        <?= "Environment is ".$upperCaseEnvironment ?>
        <?= "Message is ".$message?>
        <br>
        <pre><?php var_dump($responseArr);?></pre>

        </div>
        <pre><?php var_dump($response);?></pre>
    </div>

</div>
