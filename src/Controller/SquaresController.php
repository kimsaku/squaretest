<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Squares Controller
 *
 * @property \App\Model\Table\SquaresTable $Squares
 * @method \App\Model\Entity\Square[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SquaresController extends AppController
{
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
