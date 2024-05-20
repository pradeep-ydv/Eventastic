<?php

namespace App\Libraries;

/* * ***************************************************************************\
  +-----------------------------------------------------------------------------+
  | Project        : pradeepydv                                           	  |
  | FileName       : EmailSms.php                                             |
  | Version        : 1.0                                                      |
  | Developer      : Pradeep Yadav                                            |
  | Created On     : 04-11-2023                                               |
  | Modified On    :                                                          |
  | Modified   By  :                                                          |
  | Authorised By  :  Pradeep Yadav                                           |
  | Comments       :  This class used for site message		  		          |
  | Email          : softkiller706@gmail.com                                  |
  +-----------------------------------------------------------------------------+
  \**************************************************************************** */

class EmailSms
{

    protected $SMS_BASE_URL;
    protected $SMS_SENDERID = 'AVGNAB';
    protected $SMS_API_KEY = 'QVZJR0hOQTo4SXhpcWlSVw==';

    function __construct()
    {
        $this->SMS_BASE_URL = "http://webpostservice.com/sendsms_v2.0/sendsms.php?apikey=" . $this->SMS_API_KEY . "&type=TEXT&sender=" . $this->SMS_SENDERID . "";
    }

    private $arrMessage = array();

    public function getMessage($key)
    {
        $this->arrMessage['welcomeEmail'] = array(
            "SUBJECT" => "Welcome to " . SITE_NAME,
            "BODY" => "
                Dear ##USER_NAME##,
        
                Welcome to " . SITE_NAME . "! We're thrilled to have you join us.
        
                Thank you for registering with us. If you have any questions or need assistance, feel free to reach out to our support team.
        
                Best regards,
                Team " . SITE_NAME . "
            "
        );

        $this->arrMessage['otpmessage'] = array(
            "SUBJECT" => "Login OTP",
            "BODY" => "Dear ##USER_NAME##,<br>Your Login OTP is <b>##OTP_NUMBER##.</b><br>Do not share the OTP with anyone.<br><br>"
        );

        $this->arrMessage['generatedPassword'] = array(
            "SUBJECT" => "Welcome to " . SITE_NAME,
            "BODY" => "Dear User,<br><br>Thank you for registering with " . SITE_NAME . ".<br><br>Your login credentials for accessing the Dashboard are:<br><br>Login ID: ##USERNAME##<br>Default Password: ##PASSWORD##<br><br>Please remember to change your password upon your first login.<br><br>You can access the Dashboard via the Mobile App Settings or by clicking <a href='" . site_url('admin') . "'>here</a>.<br><br>If you need further assistance, please contact us at '" . SITE_EMAIL . "'.<br><br>Thanks,<br>Team " . SITE_NAME . "<br>"
        );

        $this->arrMessage['generateOtp'] = array(
            "SUBJECT" => SITE_NAME . " New OTP",
            "BODY" => "Dear ##USER_NAME##,<br><br>Your new OTP has been generated.<br><br>##OTP_NUMBER##<br><br>",
            "SMS" => "GENIE MONEY: Thank you for choosing Genie Money. Your One Time Password (OTP) for Registration/Login is ##OTP_NUMBER##."
        );

        // Message for forgot password
        $this->arrMessage['forgotPassword'] = array(
            "SUBJECT" => SITE_NAME . " Forgot Password",
            "BODY" => "Dear ##USER_NAME##,<br><br>Your new password for login is:<br><br>##PASSWORD##<br><br>",
            "SMS" => "Avighna: Your phone location is ##PASSWORD##."
        );

        // Message for change password
        $this->arrMessage['changePassword'] = array(
            "SUBJECT" => SITE_NAME . " New Password",
            "BODY" => "Dear ##USER_NAME##,<br><br>Your new password for login is:<br><br>##PASSWORD##<br><br>",
            "SMS" => "Avighna: Your phone location is ##PASSWORD##."
        );

        if (array_key_exists($key, $this->arrMessage)) {
            return $this->arrMessage[$key];
        }
    }

    public function emailFooter()
    {
        return "Best regards,<br>Team Stylo";
    }

    //function for making email link design
    public function generateMailLink($action, $linkname)
    {
        return '<a href="' . $action . '" target="_blank" itemprop="url" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif;  font-size: 12px; color: #626ed4; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block;  text-transform: capitalize;  margin: 0;">' . $linkname . '</a>';
    }

    public function sendEmail($toEmail, $subject = '', $mailbody = '', $bcc = "", $cc = "", $attachement = "")
    {
        $email = \Config\Services::email();

        $config['protocol'] = 'smtp';
        $config['mailPath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordWrap'] = true;

        $email->initialize($config);

        $email->setFrom('stylo@gmail.com', SITE_NAME);
        $email->setTo($toEmail);

        if ($cc) {
            $email->setCC($cc);
        }
        if ($bcc) {
            $email->setBCC($bcc);
        }

        if ($attachement) {
            if (is_array($attachement)) {
                foreach ($attachement as $filepath) {
                    $email->attach($filepath);
                }
            } else {
                $email->attach($attachement);
            }
        }

        $email->setSubject($subject);
        $email->setMessage($mailbody);

        if (!$email->send()) {
            
            return false;
        }

        return true; 
    }
}
