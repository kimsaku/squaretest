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
            <?= $this->Html->link(__('List Squares'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="squares form content">
            <?= $this->Form->create($square) ?>
            <fieldset>
                <legend><?= __('Add Square') ?></legend>
                <?php
                    echo $this->Form->control('date');
                    echo $this->Form->control('receipt');
                    echo $this->Form->control('amount');
                    echo $this->Form->control('id_square');
                    echo $this->Form->control('comment');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
