<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Squares Model
 *
 * @method \App\Model\Entity\Square newEmptyEntity()
 * @method \App\Model\Entity\Square newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Square[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Square get($primaryKey, $options = [])
 * @method \App\Model\Entity\Square findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Square patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Square[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Square|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Square saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Square[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Square[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Square[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Square[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SquaresTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('squares');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->dateTime('date')
            ->notEmptyDateTime('date');

        $validator
            ->scalar('receipt')
            ->requirePresence('receipt', 'create')
            ->notEmptyString('receipt');

        $validator
            ->numeric('amount')
            ->requirePresence('amount', 'create')
            ->notEmptyString('amount');

        $validator
            ->scalar('id_square')
            ->requirePresence('id_square', 'create')
            ->notEmptyString('id_square');

        $validator
            ->scalar('comment')
            ->allowEmptyString('comment');

        return $validator;
    }
}
