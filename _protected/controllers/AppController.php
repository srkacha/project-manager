<?php
namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

/**
 * AppController extends Controller and implements the behaviors() method
 * where you can specify the access control ( AC filter + RBAC ) for your controllers and their actions.
 */
class AppController extends Controller
{
    /**
     * Returns a list of behaviors that this component should behave as.
     * Here we use RBAC in combination with AccessControl filter.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'controllers' => ['user', 'project'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'add-participant', 'add-supervisor', 'active'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        // other rules
                        'controllers' => ['user', 'project'],
                        'actions' => ['my', 'editme', 'viewmy', 'add-income', 'add-expense', 'update', 'finance', 'update-finance', 'debug'],
                        'allow' => true,
                        'roles' => ['employee'],
                    ],
                    [
                        'controllers' => ['project'],
                        'actions' => ['view'],
                        'allow' => false,
                        'roles' => ['employee']
                    ]

                ], // rules

            ], // access

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ], // verbs

        ]; // return

    } // behaviors

} // AppController
