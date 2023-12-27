<?php

namespace api\controllers;

use common\models\User;
use common\models\Token;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use api\models\SignupForm;
use api\models\LoginForm;
use yii\web\HttpException;

/**
 * Site controller
 */
class SiteController extends ActiveController
{
    public $modelClass = User::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only' => [
                'logout',
            ],
            'except' => [
                'login',
                'signup',
            ],
        ];

        return $behaviors;
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $request = Yii::$app->request->post();
        $model = new SignupForm();
        if ($model->load($request, '') && $model->validate()) {
            $user = $model->signup();
            if (($user->getErrors()) !== []) {
                throw new HttpException(422, current($user->getErrors())[0]);
            }
            return $this->setSuccessfulResponse('Register successful!');
        }
        throw new HttpException(422, current($model->getErrors())[0]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $request = Yii::$app->request->post();
        $model = new LoginForm();
        if ($model->load($request, '') && $model->validate()) {
            $token = $model->auth();
            if (($token->getErrors()) !== []) {
                throw new HttpException(401, 'Unable to get token');
            }
            Yii::$app->response->data = [
                "message" => 'Login successful!',
                "login_token" => $token->token,
                "status" => 200,
            ];
            return;
        }
        throw new HttpException(401, current($model->getErrors())[0]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     * @throws HttpException
     */
    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest) {
            Token::deleteAll(['user_id' => Yii::$app->user->id]);
            return $this->setSuccessfulResponse('Logout successful!');
        }
        throw new HttpException(401);
    }

    private function setSuccessfulResponse($message = 'OK', $token = null)
    {
        Yii::$app->response->data = [
            "message" => $message,
            "status" => 200,
        ];
        is_null($token) ?: Yii::$app->response->data['token'] = $token;
    }
}
