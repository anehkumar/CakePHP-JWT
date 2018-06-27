<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Group extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public function parentNode()
    {
        return null;
    }
    
}