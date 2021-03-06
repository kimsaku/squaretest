<?php
declare(strict_types=1);

namespace App\Controller;

use Square\Environment;
use Square\Models\Money;
use Square\Models\CreatePaymentRequest;
use Square\Exceptions\ApiException;
use Square\SquareClient;
/**
 * Squares Controller
 *
 * @property \App\Model\Table\SquaresTable $Squares
 * @method \App\Model\Entity\Square[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SquaresController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        //$this->viewBuilder('square_test');

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $squares = $this->paginate($this->Squares);

        $this->set(compact('squares'));
    }

    public function confirm() //thanksの間違い
    {
        $upperCaseEnvironment = strtoupper(getenv('ENVIRONMENT'));  //square環境
        $message = "";
        // $squareJsSrc = ($upperCaseEnvironment == Environment::PRODUCTION) ? "https://js.squareup.com/v2/paymentform" :  "https://js.squareupsandbox.com/v2/paymentform";  //jsの接続先を環境で切り替え
        // $sqAppId = getenv($upperCaseEnvironment."_APP_ID");
        // $sqLocationId = getenv($upperCaseEnvironment."_LOCATION_ID");
        //$square = $this->Squares->newEmptyEntity();
        if ($this->request->is('post')) {
            $access_token =  getenv($upperCaseEnvironment.'_ACCESS_TOKEN');    

            // Initialize the Square client.
            $client = new SquareClient([
                'accessToken' => $access_token,  
                'environment' => getenv('ENVIRONMENT')
            ]);

             // Fail if the card form didn't send a value for `nonce` to the server
            $nonce = $this->request->getData('nonce');
            if (is_null($nonce)) {
                $message = 'Invalid card data';
                //http_response_code(422);
                //return;
            }

            $payments_api = $client->getPaymentsApi();

            $money = new Money();
            $money->setAmount(100);         //金額
            $money->setCurrency('JPY');     //決済通貨

            $create_payment_request = new CreatePaymentRequest($nonce, uniqid(), $money);   //第2引き数はユニークな文字列にして被らないように。ランダム+uniqid()にしておけば良し
            // $app_fee_money = new Money();    //feeを設定する場合だが、なぜか使えない…
            // $app_fee_money->setAmount(10);
            // $app_fee_money->setCurrency('JPY');
            // $create_payment_request->setAppFeeMoney($app_fee_money);
            //$create_payment_request->setAutocomplete(true); //即決済（基本は変えない）
            //$create_payment_request->setCustomerId('VDKXEEKPJN48QDG3BGGFAK05P8'); //Square側に保存しているカスタマーID
            //$create_payment_request->setLocationId('XK3DBG77NJBFX');              //ロケーションIDを設定する場合
            $create_payment_request->setReferenceId('123456');  //注文ID（こちら側のIDを入れておく）
            $create_payment_request->setNote('メモお客さんの名前とか'); //メモ（注文ID入れておけばよっぽど使わないと思う）

            try {
                $response = $payments_api->createPayment($create_payment_request);
                // If there was an error with the request we will
                // print them to the browser screen here
                if ($response->isError()) {
                    echo 'Api response has Errors';
                    $errors = $response->getErrors();
                    echo '<ul>';
                    foreach ($errors as $error) {
                        echo '<li>❌ ' . $error->getDetail() . '</li>';
                    }
                    echo '</ul>';
                    exit();
                }else{
                    //データベースの情報を決済済みに書き換え
                }
            } catch (ApiException $e) {
                echo 'Caught exception!<br/>';
                echo('<strong>Response body:</strong><br/>');
                echo '<pre>'; var_dump($e->getResponseBody()); echo '</pre>';
                echo '<br/><strong>Context:</strong><br/>';
                echo '<pre>'; var_dump($e->getContext()); echo '</pre>';
                exit();
            }
        }else {
            // Helps ensure this code has been reached via form submission
            //error_log('Received a non-POST request');
            $message ='Request not allowed';
            //http_response_code(405);
            $response = 'no';
            $nonce = 'no';
        }
        $this->set(compact(['nonce','upperCaseEnvironment']));
        //$this->set('sqAppId',$sqAppId);
        //$this->set('sqLocationId',$sqLocationId);
        //$this->set('upperCaseEnvironment',$upperCaseEnvironment);
        //$this->set('squareJsSrc',$squareJsSrc);
        $this->set('response',$response->getResult());
        $this->set('responseArr',$this->toArray($response->getResult()));
        $this->set('message',$message);
    }
    // オブジェクトを連想配列に変換
    function toArray($var): array
    {
        return json_decode(json_encode($var), true);
    }

    public function pay()
    {
        $upperCaseEnvironment = strtoupper(getenv('ENVIRONMENT'));  //square環境
        $squareJsSrc = ($upperCaseEnvironment == Environment::PRODUCTION) ? "https://js.squareup.com/v2/paymentform" :  "https://js.squareupsandbox.com/v2/paymentform";  //jsの接続先を環境で切り替え
        $sqAppId = getenv($upperCaseEnvironment."_APP_ID");
        $sqLocationId = getenv($upperCaseEnvironment."_LOCATION_ID");

        // $square = $this->Squares->newEmptyEntity();
        // 実際の処理はカート⇒レジに進む⇒購入品の確認⇒送付先入力⇒（注文を保存（状態は未払い））⇒pay()
        // pay()でクレカ入力確認、決済処理後、決済無事済んだら対象の注文の状態を支払い完了にする。
        // 決済が無事済まなかったら状態を決済できなかったでクローズ
        // ポストを確認してから表示の処理。ポスト無かったら不正な処理です、にリダイレクト
        $this->set(compact(['sqAppId','sqLocationId','upperCaseEnvironment','squareJsSrc']));
        
    }

    /**
     * View method
     *
     * @param string|null $id Square id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $square = $this->Squares->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('square'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $square = $this->Squares->newEmptyEntity();
        if ($this->request->is('post')) {
            $square = $this->Squares->patchEntity($square, $this->request->getData());
            if ($this->Squares->save($square)) {
                $this->Flash->success(__('The square has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The square could not be saved. Please, try again.'));
        }
        $this->set(compact('square'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Square id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $square = $this->Squares->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $square = $this->Squares->patchEntity($square, $this->request->getData());
            if ($this->Squares->save($square)) {
                $this->Flash->success(__('The square has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The square could not be saved. Please, try again.'));
        }
        $this->set(compact('square'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Square id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $square = $this->Squares->get($id);
        if ($this->Squares->delete($square)) {
            $this->Flash->success(__('The square has been deleted.'));
        } else {
            $this->Flash->error(__('The square could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
