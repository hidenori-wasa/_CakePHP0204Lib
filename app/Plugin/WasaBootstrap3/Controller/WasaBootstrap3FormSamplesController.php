<?php

\App::uses('WasaBootstrap3AppController', 'WasaBootstrap3.Controller');
class WasaBootstrap3FormSamplesController extends \WasaBootstrap3AppController
{
    public $uses = array ('WasaBootstrap3.WasaBootstrap3FormSample');

    function sample()
    {
        if ($this->request->is('post')) {
            $this->WasaBootstrap3FormSample->create(false);
            if ($this->WasaBootstrap3FormSample->save($this->request->data[$this->WasaBootstrap3FormSample->alias])) {
                \CakeSession::write('savedFormMessage', '保存しました');
                return;
            }
        }
        if (\CakeSession::read('savedFormMessage') !== null) {
            \CakeSession::delete('savedFormMessage');
        }
    }

}
