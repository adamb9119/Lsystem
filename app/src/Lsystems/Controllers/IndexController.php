<?php

namespace Lsystems\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Lsystems\Src\Lsystem;

class IndexController
{

    public function indexAction(Request $request, \Application $app)
    {
        return $app->render('index.html.twig');
    }

    public function createAction(Request $request, \Application $app)
    {
        $axiom       = $_POST['axiom'];
        $generations = $_POST['generations'];
        $rules       = $_POST['rule'];

        $lsystem = new Lsystem();
        
        $binds = [];
        $binds['F'] = [
            'param' => 15,
            'value' => 'moveForward'
        ];
        $binds['+'] = [
            'param' => 22,
            'value' => 'moveRight'
        ];
        $binds['-'] = [
            'param' => 22,
            'value' => 'moveLeft'
        ];

        $lsystem->setAxiom($axiom);
        $lsystem->addRules($rules);
        $lsystem->setBinds($binds);
        $lsystem->setBind('[', 'savePosition', '');
        $lsystem->setBind(']', 'restorePosition', '');

        $image  = $lsystem->createImage($generations);

        return json_encode([
            'pic'      => $image
        ]);
    }
}