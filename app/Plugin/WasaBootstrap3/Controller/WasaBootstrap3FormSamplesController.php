<?php

\App::uses('WasaBootstrap3AppController', 'WasaBootstrap3.Controller');
class WasaBootstrap3FormSamplesController extends \WasaBootstrap3AppController
{
    public $uses = array ('WasaBootstrap3.WasaBootstrap3FormSample');

    function sampleForm()
    {
        $this->postFromForm($this->WasaBootstrap3FormSample, array ('savedFormMessage' => 'It saved.'));
    }

    function displaySecurityError()
    {
        $this->redirect(array ('controller' => 'WasaBootstrap3App', 'action' => __FUNCTION__));
    }

}
