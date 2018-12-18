<?php

namespace Application\Controllers;

use Application\Core\User;
use Application\Models\Message;
use Phalcon\Mvc\View;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\StringLength;

class IndexController extends ControllerBase 
{
    public function indexAction() 
    {
		$this->view->setVar('messages', Message::find());
	}

	public function createAction() 
	{
		$this->view->setVar('app_page_title', 'New Message');
		$this->view->setVar('post', $_POST);

		if ($this->request->isPost()) {
			if (0 === count($errors = $this->validate($_POST))) {
				$message = new Message();
				$message->mailer = $_POST['mailer'];
				$message->recipient = $_POST['recipient'];
				$message->message = $_POST['message'];
				$message->save();

				$this->flashSession->success('Message has been created.');

				return $this->response->redirect()->send();
			}

			$this->view->setVar('errors', $errors);
		}

		$this->view->pick('index/form');
	}

	public function updateAction() 
	{
		$id = $this->dispatcher->getParam('id');
		$message = $this->load($id);

		$this->view->setVar('app_page_title', 'Edit Message');
		$this->view->setVar('post', $message->toArray());

		if ($this->request->isPost()) {
			if (0 === count($errors = $this->validate($_POST))) {
				$message->mailer = $_POST['mailer'];
				$message->recipient = $_POST['recipient'];
				$message->message = $_POST['message'];
				$message->save();

				$this->flashSession->success('Message has been updated.');

				return $this->response->redirect()->send();
			}

			$this->view->setVar('post', $_POST);
			$this->view->setVar('errors', $errors);
		}

		$this->view->pick('index/form');
	}

	public function deleteAction() 
	{
		$id = $this->dispatcher->getParam('id');
		$message = $this->load($id);

		$this->view->setVar('app_page_title', 'Delete Message');
		$this->view->setVar('message', $message);

		if ($this->request->isPost()) {
			$message->delete();

			$this->flashSession->warning('Message has been deleted.');

			return $this->response->redirect()->send();
		}
	}

    private function validate(array $data) 
    {
    	$validation = new Validation();
    	$validation->add('mailer', new StringLength(array(
    		'min' => 1,
    		'messageMinimum' => 'Mailer should not be blank.',
    	)));
    	$validation->add('mailer', new Email(array(
    		'message' => 'Mailer is not an email.',
    		'allowEmpty' => true,
    	)));
    	$validation->add('recipient', new StringLength(array(
    		'min' => 1,
    		'messageMinimum' => 'Recipient should not be blank.',
    	)));
    	$validation->add('recipient', new Email(array(
    		'message' => 'Recipient is not an email.',
    		'allowEmpty' => true,
    	)));
    	$validation->add('message', new StringLength(array(
    		'min' => 1,
    		'max' => 70,
    		'messageMinimum' => 'Message should not be blank.',
    		'messageMaximum' => 'Message too long. It should be less than 70 characters.',
    	)));

    	return $validation->validate($data);
    }

    private function load($id) 
    {
    	$message = Message::findFirst($id);

    	if (!$message) {
    		$this->flashSession->error(sprintf('Message "#%s" not found.', $id));

			return $this->response->redirect()->send();
    	}

    	return $message;
    }
}
