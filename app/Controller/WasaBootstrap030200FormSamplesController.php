<?php

\App::uses('WasaAppController', 'Wasa/Controller');
class WasaBootstrap030200FormSamplesController extends \WasaAppController
{
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
