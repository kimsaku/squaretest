<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Square $square
 */
?>
<?= $this->Html->script($square_js_src);?>
<?= $this->Html->script('js/sq-payment-form');?>

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
            <div><?= $upper_case_environment?></div>
            <div id="form-container">
                <label>Card Number</label>
                <div id="sq-card-number"></div>
                <label>CVV</label>
                <div id="sq-cvv"></div>
                <label>Expiration Date</label>
                <div id="sq-expiration-date"></div>
                <label>Postal Code</label>
                <div id="sq-postal-code"></div>
                <button id="sq-creditcard" onclick="requestCardNonce(event)">カードで支払い</button>
            </div>
            </fieldset>
            <input type="hidden" id="card-nonce" name="nonce">
        <?= $this->Form->end() ?>
        </div>

        <!-- Begin Payment Form -->
        <div class="sq-payment-form">
          <!--
            Square's JS will automatically hide these buttons if they are unsupported
            by the current device.
          -->
          <div id="sq-walletbox">
            <button id="sq-google-pay" class="button-google-pay"></button>
            <button id="sq-apple-pay" class="sq-apple-pay"></button>
            <button id="sq-masterpass" class="sq-masterpass"></button>
            <div class="sq-wallet-divider">
              <span class="sq-wallet-divider__text">Or</span>
            </div>
          </div>
          <div id="sq-ccbox">
            <!--
              You should replace the action attribute of the form with the path of
              the URL you want to POST the nonce to (for example, "/process-card").

              You need to then make a "Charge" request to Square's Payments API with
              this nonce to securely charge the customer.

              Learn more about how to setup the server component of the payment form here:
              https://developer.squareup.com/docs/payments-api/overview
            -->
            <form id="nonce-form" novalidate action="/process-card.php" method="post">
              <div class="sq-field">
                <label class="sq-label">Card Number</label>
                <div id="sq-card-number"></div>
              </div>
              <div class="sq-field-wrapper">
                <div class="sq-field sq-field--in-wrapper">
                  <label class="sq-label">CVV</label>
                  <div id="sq-cvv"></div>
                </div>
                <div class="sq-field sq-field--in-wrapper">
                  <label class="sq-label">Expiration</label>
                  <div id="sq-expiration-date"></div>
                </div>
                <div class="sq-field sq-field--in-wrapper">
                  <label class="sq-label">Postal</label>
                  <div id="sq-postal-code"></div>
                </div>
              </div>
              <div class="sq-field">
                <button id="sq-creditcard" class="sq-button" onclick="onGetCardNonce(event)">
                  Pay $1.00 Now
                </button>
              </div>
              <!--
                After a nonce is generated it will be assigned to this hidden input field.
              -->
              <div id="error"></div>
              <input type="hidden" id="card-nonce" name="nonce">
            </form>
          </div>
        </div>
        <!-- End Payment Form -->
    </div>
</div>


<!--
var applicationId = <?= "\"";?><?= h($sqAppId);?><?= "\"";?>; // アプリケーションID設定
var applicationId = "sandbox-sq0idb-7CmShbOR6Ylut1awS3EoEw";
var locationId = "REPLACE_ME";    // 店舗ID設定
-->
<script type="text/javascript">

// ボタンを押したタイミングで実行される関数
function requestCardNonce(event) {
    event.preventDefault();
    paymentForm.requestCardNonce();
}

var paymentForm = new SqPaymentForm({
  // 初期設定
  applicationId: 'sandbox-sq0idb-7CmShbOR6Ylut1awS3EoEw',
  locationId: locationId,
  inputClass: 'sq-input',
  inputStyles: [{
      fontSize: '.9em'
  }],

  // クレジットカード用
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
  // Apple Pay用
  applePay: {
    elementId: 'sq-apple-pay'
  },
  // MasterPass用
  masterpass: {
    elementId: 'sq-masterpass'
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
    // サポート外のブラウザアクセスの場合
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


