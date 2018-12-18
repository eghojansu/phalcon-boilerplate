<?php

namespace Application\Models;

use Phalcon\Mvc\Model;

class Message extends Model {
	public $id;
	public $mailer;
	public $recipient;
	public $message;
}