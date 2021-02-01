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
            <?= $this->Form->create() ?>
            <fieldset>
            <div id="form-container">
                <label>Card Number</label>
                <div id="sq-card-number"></div>
                <label>CVV</label>
                <div id="sq-cvv"></div>
                <label>Expiration Date</label>
                <div id="sq-expiration-date"></div>
                <label>Postal Code</label>
                <div id="sq-postal-code"></div>
                <button id="sq-creditcard" 
                        onclick="onGetCardNonce(event)">Pay $1.00</button>
            </div>
            </fieldset>
        <?= $this->Form->end() ?>
        </div>
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


<script>
var applicationId = "REPLACE_ME"; // アプリケーションIDと置き換えます
var locationId = "REPLACE_ME";    // 店舗IDと置き換えます

// ボタンを押したタイミングで実行される関数
function requestCardNonce(event) {
    event.preventDefault();
    paymentForm.requestCardNonce();
}

var paymentForm = new SqPaymentForm({
  // 初期設定
  applicationId: applicationId,
  locationId: locationId,
  inputClass: 'sq-input',
  inputStyles: [{
      fontSize: '.9em'
  }],

  // クレジットカード情報のプレイスホルダー
  cardNumber: {
    elementId: 'sq-card-number',
    placeholder: '•••• •••• •••• ••••'
  },
  cvv: {
    elementId: 'sq-cvv',
    placeholder: 'CVV'
  },
  expirationDate: {
    elementId: 'sq-expiration-date',
    placeholder: 'MM/YY'
  },
  postalCode: {
    elementId: 'sq-postal-code'
  },

  // 各種コールバック
  callbacks: {
    createPaymentRequest: function () {},
    // nonce 生成後に呼ばれるメソッド
    cardNonceResponseReceived: function(errors, nonce, cardData) {
      if (errors) {
        // エラーがあった場合
        console.log("エラーが発生しました。:");
        errors.forEach(function(error) {
          console.log('  ' + error.message);
        });
        return;
      }
      // nonceの値をhiddenの中に入れます
      document.getElementById('card-nonce').value = nonce;
      // 本来のフォームを送信します
      document.getElementById('nonce-form').submit();
    },
    // サポート外のぶらず艶アクセ視した場合
    unsupportedBrowserDetected: function() {
    },
    // イベントハンドリング
    inputEventReceived: function(inputEvent) {
    },
    // フォームを読み込んだ後のコールバック
    paymentFormLoaded: function() {
    }
  }
});
 </script>


