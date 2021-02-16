<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Square $square
 */
?>

<?= $this->Html->script($squareJsSrc,['block' => true]);?>
<?= $this->Html->scriptStart(['block' => true]);?>
    window.applicationId = <?= "\"".$sqAppId."\""?>;
    window.locationId = <?= "\"".$sqLocationId."\""?>;
<?= $this->Html->scriptEnd();?>
<?= $this->Html->script('sqpaymentform',['block' => true]);?>


<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Squares'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="squares payment form content">
            <?= $this->Form->create(NULL,['id'=>"nonce-form",'url'=>['action'=>"confirm"]]) ?>
            <fieldset>
            <!-- <form id="nonce-form" novalidate action="confirm.php" method="post"> -->
                カードで支払います
                <table><tbody>
                    <tr>
                    <td>カード番号:</td>
                    <td><div id="sq-card-number"></div></td>
                    </tr>
                    <tr>
                    <td>CVV:</td>
                    <td><div id="sq-cvv"></div></td>
                    </tr>
                    <tr>
                    <td>有効期限:</td>
                    <td><div id="sq-expiration-date"></div></td>
                    </tr>
                    <tr>
                    <td>郵便番号:</td>
                    <td><div id="sq-postal-code"></div></td>
                    </tr>
                    <tr>
                    <td colspan="5">
                        <button id="sq-creditcard" class="button-credit-card" onclick="requestCardNonce(event)">
                        カードで支払う
                        </button>
                    </td>
                    </tr>
                </tbody></table>
                <div id="error"></div>
                <input type="hidden" id="card-nonce" name="nonce">
            <!-- </form> -->
            </fieldset>
        <?= $this->Form->end() ?>
        </div>
    </div>
</div>
