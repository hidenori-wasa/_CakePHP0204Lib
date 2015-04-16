<?php
$this->layout = 'WasaBootstrap3.default';
$this->set('title_for_layout', 'Security error.');

$securityErrorMessage = \CakeSession::read('securityErrorMessage');
if ($securityErrorMessage !== null) {
    \CakeSession::delete('securityErrorMessage');
    echo '<div class="alert alert-danger">' . $securityErrorMessage . '</div>';
}
