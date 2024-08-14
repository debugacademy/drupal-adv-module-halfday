<?php

namespace Drupal\email_logger\Services;

use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Mail\MailManagerInterface;

class EmailLogger {

  /**
   * Constructs an EmailLogger object.
   *
   * @param \Drupal\Core\Mail\MailManagerInterface $mail_manager
   *   The email sending service.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The manager to use for language translations.
   */
  public function __construct(
    protected MailManagerInterface $mailManager,
    protected LanguageManagerInterface $languageManager
  ) {
    // Note: This uses PHP8's constructor property promotion.
    // So injected services are available via:
    // $this->mailManager and $this->languageManager
    // See https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion
  }

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
    $langcode = $this->languageManager->getDefaultLanguage()->getId();
    $send = true;
    $toAddress = $this->getEmailSender();
    $params = [];
    $to = $toAddress;
    $params['message'] = $message; // Email body must be an array, not a string.
    $result = $this->mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
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
