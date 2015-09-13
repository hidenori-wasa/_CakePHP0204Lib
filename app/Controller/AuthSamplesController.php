<?php

// "WA" scope is this file only.
// Also, this name priority is higher than a class name.
// Therefore, this name is not affected by other name.
use \WasaAuthControllerParts as WA;

\App::uses('WasaAuthControllerParts', 'WasaAuth.Lib');
\App::uses('AppController', 'Controller');
class AuthSamplesController extends AppController
{

    function __construct($request = null, $response = null)
    {
        WA::construct(array (
            'controller' => $this,
            'authModelName' => 'AuthSample',
            'authErrorMessageOfDeniedPage' => '認証が必要なページです。<br />ユーザ名とパスワードを入力してください。',
            'loginRedirectAction' => array ('action' => 'displayUserPage'),
            'logoutRedirectAction' => array ('action' => 'index'),
        ));

        parent::__construct($request, $response);
    }

    /**
     * コントローラの前に呼び出されるコールバック
     */
    function beforeFilter()
    {
        // 指定アクション郡を認証なしで許可する
        $this->Auth->allow('index', 'registerUser', 'changePassword');
        // 指定アクション郡を認証ありにする (デフォルトで全て認証あり)
        // $this->Auth->deny('');
    }

    /**
     * Login action.
     *
     * @return void
     */
    function login()
    {
        WA::login(array (
            'controller' => $this,
            'loginFailureMessage' => 'Username or password is mistake.<br />Please, change password if you forget password.'
        ));
    }

    /**
     * ユーザー登録アクション
     */
    function registerUser()
    {
        // Blowfish salt: '$2a$' . '04' ～ '31' . '$[[:alnum:]]{25}$'
        // var_dump(crypt('pass', '$2a$07$usesomesillystringforsalt$'));
    }

    /**
     * パスワード変更アクション
     */
    function changePassword()
    {

    }

    /**
     * The logout action.
     *
     * @return void
     */
    function logout()
    {
        WA::logout(array ('controller' => $this));
    }

    /**
     * ユーザー登録削除アクション
     */
    function deleteUser()
    {

    }

    /**
     * 認証が不要なアクション例
     */
    function index()
    {
        // ログインしているかどうかをビュー変数にセットする
        $this->set(array ('isLoggedIn' => $this->Auth->loggedIn()));
    }

    /**
     * 認証が必要なアクション例
     */
    function displayUserPage()
    {

    }

}

?>
