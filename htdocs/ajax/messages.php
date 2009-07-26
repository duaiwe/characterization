<?php
/**
 *
 * @author Jonathan Borzilleri
 */
#include(dirname(__FILE__).'/../../includes/inc/session.php');
session_start();
include(dirname(__FILE__).'/../../includes/inc/class.message.php');

$messenger = new Message();
$messages = $messenger->messages();
$messenger->clear();

if ( count($messages) == 0 )
    die;

$output = '';
$statusText = '';
$highestLevel = 0;

foreach ( $messages as $msg ) {
    if ( $msg['level'] > $highestLevel )
        $highestLevel = $msg['level'];

    $output .= '<div class="message' . Message::$strings[$msg['level']] . '">' .
               $msg['message'] . '</div>';
}

echo Message::$strings[$highestLevel].'|'.$output;
?>