<?php
/**
 * Created by PhpStorm.
 * User: gamalan
 * Date: 07/10/16
 * Time: 10:24
 */

namespace Application\Router;

use Phalcon\Mvc\Router\Group;

class MainRouter extends Group
{
    public function initialize()
    {
        $this->setPaths([
            'namespaces' => 'Application\\Controllers',
            'controller'=>'index'
        ]);

        $this->add('/', array('action' => 'index'));
        $this->add('/create', array('action' => 'create'));
        $this->add('/update/([0-9]+)', array('action' => 'update', 'id' => 1));
        $this->add('/delete/([0-9]+)', array('action' => 'delete', 'id' => 1));
    }
}