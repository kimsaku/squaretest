<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Square $square
 */
?>

<?= $this->Html->script($square_js_src,['block' => true]);?>
<?= $this->Html->scriptStart(['block' => true]);?>
    window.applicationId = <?= "\"".$sqAppId."\""?>;
    window.locationId = <?= "\"".$sqAppId."\""?>;
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
            <?= $this->Form->create() ?>
            <!-- <fieldset>
            <div>Squareの開発環境＝<?= $upper_case_environment?></div>
            <div id="form-container">
                <label>Card Number</label>
                <div id="sq-card-number"></div>
                <label>Expiration Date</label>
                <div id="sq-expiration-date"></div>
                <label>CVV</label>
                <div id="sq-cvv"></div>
                <label>Postal Code</label>
                <div id="sq-postal-code"></div>
                <button id="sq-creditcard" 
                        onclick="onGetCardNonce(event)">Pay $1.00</button>
            </div>
            </fieldset> -->
            <fieldset>
            <form id="nonce-form" novalidate action="/process-card.php" method="post">
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
                    <td colspan="2">
                        <button id="sq-creditcard" class="button-credit-card" onclick="requestCardNonce(event)">
                        カードで支払う
                        </button>
                    </td>
                    </tr>
                </tbody></table>
                <input type="hidden" id="card-nonce" name="nonce">
            </form>
            </fieldset>
        <?= $this->Form->end() ?>
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
<!-- <script>
var applicationId = "sandbox-sq0idb-7CmShbOR6Ylut1awS3EoEw"; // アプリケーションIDと置き換えます
var locationId = "REPLACE_ME";    // 店舗IDと置き換えます

// ボタンを押したタイミングで実行される関数
function requestCardNonce(event) {
  event.preventDefault();
  paymentForm.requestCardNonce();
}

var paymentForm = new SqPaymentForm({
  // 以下は初期設定です
  applicationId: applicationId,
  locationId: locationId,
  inputClass: 'sq-input',
  inputStyles: [{
      fontSize: '.9em'
  }],

  // Apple Pay用
  applePay: {
    elementId: 'sq-apple-pay'
  },

  // MasterPass用
  masterpass: {
    elementId: 'sq-masterpass'
  },

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

    // Apple Pay / MasterPassの有効/無効チェック
    methodsSupported: function (methods) {
      var applePayBtn = document.getElementById('sq-apple-pay');
      var applePayLabel = document.getElementById('sq-apple-pay-label');
      var masterpassBtn = document.getElementById('sq-masterpass');
      var masterpassLabel = document.getElementById('sq-masterpass-label');
      // Apple Payが有効だったら表示する
      if (methods.applePay === true) {
        applePayBtn.style.display = 'inline-block';
        applePayLabel.style.display = 'none' ;
      }
      // Masterpassが有効だったら表示する
      if (methods.masterpass === true) {
        masterpassBtn.style.display = 'inline-block';
        masterpassLabel.style.display = 'none';
      }
    },

    createPaymentRequest: function () {
    },
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
</script> -->
