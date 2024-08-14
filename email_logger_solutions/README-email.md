This project is configured to use maillog to catch all outgoing emails

This may result in a warning message displaying in the gitpod remote development environment. That is OK.

The project is also set up with a limited SendGrid API Token which supports up to 100 emails per day. At the end of class, it may make sense to switch the outgoing emails (mail system settings) from MailLog to SendGrid so that students can see the emails reach their inbox.

This change should not be made until/unless the number of emails being sent by the module is limited. Students are also free to get their own send grid API key for free if they'd like to send more "real" emails.
