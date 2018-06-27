<?php
namespace App\Model\Table;

use App\Model\Entity\Group;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class GroupsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setTable('groups'); 
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        //$this->table('groups');  For version below 3.6
        //$this->displayField('name'); For version below 3.6
        //$this->primaryKey('id'); For version below 3.6
        $this->addBehavior('Timestamp');
        $this->addBehavior('Acl.Acl', ['type' => 'requester']);
        $this->hasMany('Users', [
            'foreignKey' => 'group_id'
        ]);
    }
   
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');
        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');
        return $validator;
    }
}