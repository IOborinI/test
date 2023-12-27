<?php

namespace api\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use common\models\Comment;
use api\models\CommentSearch;

/**
 * Comment controller
 */
class CommentController extends ActiveController
{
    public $modelClass = Comment::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        $behaviors['access'] = [
            'class' => \yii\filters\AccessControl::class,
            'only' => ['delete','update'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['delete','update'],
                    'roles' => ['@'], // Только авторизованные пользователи
                    'matchCallback' => function ($rule, $action) {
                        return Yii::$app->user->identity->role == 2;  // Только роль == 2 (администраторы)
                    },
                ],
            ],
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new CommentSearch();
        return $searchModel->search(Yii::$app->request->queryParams);
    }
}