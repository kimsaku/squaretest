<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Square[]|\Cake\Collection\CollectionInterface $squares
 */
?>
<div class="squares index content">
    <?= $this->Html->link(__('New Square'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Squares') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($squares as $square): ?>
                <tr>
                    <td><?= $this->Number->format($square->id) ?></td>
                    <td><?= h($square->date) ?></td>
                    <td><?= $this->Number->format($square->amount) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $square->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $square->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $square->id], ['confirm' => __('Are you sure you want to delete # {0}?', $square->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
