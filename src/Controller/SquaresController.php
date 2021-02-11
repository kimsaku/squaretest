<?php
declare(strict_types=1);

namespace App\Controller;

use Square\Environment;
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

    public function pay()
    {
        $upper_case_environment = strtoupper(getenv('ENVIRONMENT'));
        $square_js_src = ($upper_case_environment == Environment::PRODUCTION) ? "https://js.squareup.com/v2/paymentform" :  "https://js.squareupsandbox.com/v2/paymentform";
 
        $square = $this->Squares->newEmptyEntity();
        if ($this->request->is('post')) {
            //squareの支払い処理
            
            //squareの処理が無事できたら
            if (0) {
                $this->Flash->success(__('squareの支払が無事完了しました'));
                //squareの返り値を配列に保存
                //squareの返り値をポストしてaddに移動
                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('squareの処理を失敗しました'));
        }

        //viewに
        $this->set(compact('square'));
        $this->set('sqAppId',env('SQ_APP_ID','applicationId'));
        $this->set('upper_case_environment',$upper_case_environment);
        $this->set('square_js_src',$square_js_src);
        
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
