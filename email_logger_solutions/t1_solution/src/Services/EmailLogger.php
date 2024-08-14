<?php

namespace Drupal\email_logger\Services;

class EmailLogger {

  /**
   * Gets the destination email address for logged messages
   *
   * @return string
   *   The email address where logged messages will be sent
   */
  protected function getEmailSender() {
    return 'test@example.com';
  }

  /**
   * Sends the logged messages as email
   *
   * @param array $entry
   *   Array containing the details and message associated with this log entry.
   *
   * @return boolean
   *   A success indicator of the email, failure being already written to the
   *   watchdog. (Success means nothing more than the message being accepted at
   *   php-level, which still doesn't guarantee it to be delivered.)
   */
  protected function sendEmail($message) {
    $module = 'email_logger';
    $key = 'send_log_messages';
    $langcode = \Drupal::service('language_manager')->getDefaultLanguage()->getId();
    $send = true;
    $toAddress = $this->getEmailSender();
    $params = [];
    $to = $toAddress;
    $params['message'] = $message; // Email body must be an array, not a string.
    $mailManager = \Drupal::service('plugin.manager.mail');
    $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
    return $result;
  }

  /**
   * Creates the message to be sent via email
   *
   * @param array $message
   *   Array containing the details and message associated with this message entry.
   */
  public function buildMessageEntry($message) {
    $this->sendEmail($message);
  }
}
