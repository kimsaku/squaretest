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

            // To learn more about splitting payments with additional recipients,
            // see the Payments API documentation on our [developer site]
            // (https://developer.squareup.com/docs/payments-api/overview).

            $money = new Money();
            // Monetary amounts are specified in the smallest unit of the applicable currency.
            // This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
            $money->setAmount(100);         //金額
            $money->setCurrency('JPY');     //決済通貨

            $create_payment_request = new CreatePaymentRequest($nonce, uniqid(), $money);
            // $app_fee_money = new Money();
            // $app_fee_money->setAmount(10);
            // $app_fee_money->setCurrency('JPY');
            // $create_payment_request->setAppFeeMoney($app_fee_money);
            //$create_payment_request->setAutocomplete(true); //即決済（基本は変えない）
            //$create_payment_request->setCustomerId('VDKXEEKPJN48QDG3BGGFAK05P8'); //Square側に保存しているカスタマーID
            //$create_payment_request->setLocationId('XK3DBG77NJBFX');              //ロケーションIDを設定する場合
            $create_payment_request->setReferenceId('123456');  //注文ID
            $create_payment_request->setNote('メモお客さんの名前とか'); //メモ

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
                }
                //echo '<pre>';
                //print_r($response);
                //echo '</pre>';
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
        $this->set('nonce',$nonce);
        //$this->set('sqAppId',$sqAppId);
        //$this->set('sqLocationId',$sqLocationId);
        $this->set('upperCaseEnvironment',$upperCaseEnvironment);
        //$this->set('squareJsSrc',$squareJsSrc);
        $this->set('response',$response->getResult());
        $this->set('responseArr',$this->toArray($response->getResult()));
        $this->set('message',$message);
    }
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
        // if ($this->request->is('post')) {
        //     if (0) {
        //         $this->Flash->success(__('squareの支払が無事完了しました'));
        //         //squareの返り値を配列に保存
        //         //squareの返り値をポストしてaddに移動
        //         return $this->redirect(['action' => 'add']);
        //     }
        //     $this->Flash->error(__('squareの処理を失敗しました'));
        // }
        // //viewに
        // $this->set(compact('square'));
        $this->set('sqAppId',$sqAppId);
        $this->set('sqLocationId',$sqLocationId);
        $this->set('upperCaseEnvironment',$upperCaseEnvironment);
        $this->set('squareJsSrc',$squareJsSrc);
        
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
