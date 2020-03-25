<?php

class DM_Wordpress_Mailer_PHPMailer
{
	protected $mailer;

	static public function factory()
	{
		return new DM_Wordpress_Mailer_PHPMailer();
	}

	public function __construct()
	{
		$mailer = new PHPMailer();

		if ($from = DM_Wordpress_Config::get('Mail.From'))
		{
			$mailer->From = (string) $from;
		}
		if ($fromName = DM_Wordpress_Config::get('Mail.FromName'))
		{
			$mailer->FromName = (string) $fromName;
		}
		if ($host = DM_Wordpress_Config::get('Mail.Host'))
		{
			$mailer->Host = (string) $host;
			$mailer->isSMTP();
		}
		if ($smtpAuth = DM_Wordpress_Config::get('Mail.SmtpAuth'))
		{
			$mailer->SMTPAuth = (bool) $smtpAuth;
			if ($username = DM_Wordpress_Config::get('Mail.Username'))
			{
				$mailer->Username = (string) $username;
			}
			if ($password = DM_Wordpress_Config::get('Mail.Password'))
			{
				$mailer->Password = (string) $password;
			}
		}
		if ($port = DM_Wordpress_Config::get('Mail.Port'))
		{
			$mailer->Port = (int) $port;
		}
		if ($smtpSecure = DM_Wordpress_Config::get('Mail.SMTPSecure'))
		{
			$mailer->SMTPSecure = (string) $smtpSecure;
		}
		$mailer->CharSet = 'UTF-8';
		$mailer->isHTML(false);

		$this->mailer = $mailer;
	}

	public function from($email, $name = NULL)
	{
		if ($email)
		{
			$this->mailer->From = (string) $email;
		}
		if ($name)
		{
			$this->mailer->FromName = (string) $name;
		}
		return $this;
	}

	public function to($email, $name = NULL)
	{
		$this->mailer->addAddress((string) $email, $name ? (string) $name : NULL);
		return $this;
	}

	public function cc($email, $name = NULL)
	{
		$this->mailer->addCC((string) $email, $name ? (string) $name : NULL);
		return $this;
	}

	public function bcc($email, $name = NULL)
	{
		$this->mailer->addBCC((string) $email, $name ? (string) $name : NULL);
		return $this;
	}

	public function reply_to($email, $name = NULL)
	{
		$this->mailer->addReplyTo((string) $email, $name ? (string) $name : NULL);
		return $this;
	}

	public function attachment($file, $name = NULL)
	{
		$this->mailer->addAttachment((string) $file, $name ? (string) $name : NULL);
	}

	public function subject($subject)
	{
		$this->mailer->Subject = (string) $subject;
		return $this;
	}

	public function html($html)
	{
		$this->mailer->isHTML(true);
		$this->mailer->Body = (string) $html;
		return $this;
	}

	public function text($text)
	{
		$this->mailer->AltBody = (string) $text;
		return $this;
	}

	public function send()
	{
		return $this->mailer->send();
	}

	public function error()
	{
		return $this->mailer->ErrorInfo;
	}
}