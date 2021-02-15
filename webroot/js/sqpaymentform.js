// var applicationId = "REPLACE_ME"; // アプリケーションIDと置き換えます
// var locationId = "REPLACE_ME";    // 店舗IDと置き換えます

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
    elementId: 'sq-postal-code',
    placeholder: '1230001'
  },

  // 各種コールバック
  callbacks: {
    /*
     * callback function: methodsSupported
     * Triggered when: the page is loaded.
     */
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
        var error_html = "";
        for (var i =0; i < errors.length; i++){
          error_html += "<li> " + errors[i].message + " </li>";
        }
        document.getElementById("error").innerHTML = error_html;
        document.getElementById('sq-creditcard').disabled = false;

        return;
      }else{
        //document.getElementById("error").innerHTML = "nonce is " + nonce;
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