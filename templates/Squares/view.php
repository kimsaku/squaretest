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
            <?= $this->Html->link(__('Edit Square'), ['action' => 'edit', $square->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Square'), ['action' => 'delete', $square->id], ['confirm' => __('Are you sure you want to delete # {0}?', $square->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Squares'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Square'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="squares view content">
            <h3><?= h($square->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($square->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($square->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($square->date) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Receipt') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($square->receipt)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Id Square') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($square->id_square)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Comment') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($square->comment)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
