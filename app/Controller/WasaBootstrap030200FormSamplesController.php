<?php

App::uses('\AppController', '\Controller');
class WasaBootstrap030200FormSamplesController extends \AppController
{
    /**
     * @var array Helpers for view.
     */
    public $helpers = array (
        'Form' => array ('className' => 'WasaForm'), // Uses "WasaForm" helper instead of "Form" helper.
        'Paginator' => array ('className' => 'BoostCake.BoostCakePaginator'), // Uses "BoostCakePaginator" helper instead of "Paginator" helper.
        'WasaHtml',
    );
    public $uses = array ('WasaBootstrap030200FormSample');

    function index()
    {
        if ($this->request->is('post')) {
            $this->WasaBootstrap030200FormSample->create(false);
            if ($this->WasaBootstrap030200FormSample->save($this->request->data[$this->WasaBootstrap030200FormSample->alias])) {
                \CakeSession::write('savedFormMessage', '保存しました');
                return;
            }
        }
        if (\CakeSession::read('savedFormMessage') !== null) {
            \CakeSession::delete('savedFormMessage');
        }
    }

}
