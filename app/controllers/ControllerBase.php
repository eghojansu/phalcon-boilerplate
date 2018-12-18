<?php

namespace Application\Controllers;

use Application\Core\Log;
use Application\Queue\BasicServer;
use Application\Utils\CustomUtil;
use Application\Utils\Slug;
use Phalcon\Db\Column;
use Phalcon\Mvc\Controller;

/**
 * @property Slug $slug
 **/
class ControllerBase extends Controller {
	protected $data;
	/** @var  BasicServer $basic_server */
	protected $basic_server;
	/** @var  string $sentry_dsn */
	protected $sentry_dsn;

	const AUTH_SESSION = 'auth';
	const IMPERSONATE_SESSION = 'impersonate-auth';
	const REMEMBER_ME_COOKIE = "remember-me";

	public function onConstruct() {
		$config           = $this->di->getShared( 'config' );
		try {
			if ( APPLICATION_ENV === ENV_STAGING || APPLICATION_ENV == ENV_PRODUCTION ) {
				$this->sentry_dsn = "https://" . $config->get( 'sentry' )->credential->key . "@sentry.io/" . $config->get( 'sentry' )->credential->projectId;
				$this->view->setVar( 'sentry_dsn', $this->sentry_dsn );
			}
		} catch ( \Throwable $exc ) {
			$this->di->getShared( 'sentry' )->logException( $exc, [], 3 );
		}
		$this->view->setLayout( 'base' );
		$this->basic_server = new BasicServer( $config->get( 'beanstalk' )->basic_worker_name );

		$this->view->setVar('app_name', 'Basic CRUD - Eko Kurniawan');
		$this->view->setVar('app_page_title', 'Home');

		$db = $this->di->get('db');

		if (!$db->tableExists('message')) {
			$db->createTable(
			    'message',
			    null,
			    [
			       'columns' => [
			            new Column(
			                'id',
			                [
			                    'type'          => Column::TYPE_INTEGER,
			                    'size'          => 10,
			                    'notNull'       => true,
			                    'autoIncrement' => true,
			                    'primary'       => true,
			                ]
			            ),
			            new Column(
			                'mailer',
			                [
			                    'type'    => Column::TYPE_VARCHAR,
			                    'size'    => 70,
			                    'notNull' => true,
			                ]
			            ),
			            new Column(
			                'recipient',
			                [
			                    'type'    => Column::TYPE_VARCHAR,
			                    'size'    => 70,
			                    'notNull' => true,
			                ]
			            ),
			            new Column(
			                'message',
			                [
			                    'type'    => Column::TYPE_TEXT,
			                    'notNull' => true,
			                ]
			            ),
			        ]
			    ]
			);
		}
	}

	public function beforeExecuteRoute($dispatcher){

    }

	protected function _registerUserSession( $user ) {

	}

	protected function _registerImpersonateUserSession( $user ) {

	}

	protected function _registerAuthCookies( $user ) {

	}

	/**
	 * register submit hash to prevent re-submit
	 *
	 * @param  [type] $posts [description]
	 *
	 * @return [type]       [description]
	 */
	protected function _registerSubmit( $posts ) {
		$posted = '';

		foreach ( $posts as $post ) {
			$posted .= $post;
		}

		$this->session->set(
			"hash_submit", md5( $posted ) );
	}

	/**
	 * get registered hash submit
	 *
	 * @param  [type] $posts [description]
	 *
	 * @return [type]       [description]
	 */
	protected function _checkSubmitHash( $posts ) {
		$posted = '';

		foreach ( $posts as $post ) {
			$posted .= $post;
		}

		$hash        = md5( $posted );
		$hash_submit = $this->session->get( 'hash_submit' );

		if ( $hash_submit == $hash ) {
			return 0;
		}

		return 1;
	}

	protected function _slug( $string, $delimiter = '-' ) {
		$slug = new Slug;

		return $slug->generate( $string,$delimiter );
	}

	public function getDispatcherParams() {
		$data = [];

		if ( $this->dispatcher->getParams() ) {
			$params = $this->dispatcher->getParams();

			foreach ( $params as $key => $value ) {
				if ( $key != 'namespaces' ) {
					$data['form_value'][ $key ] = $value;
				}
			}
		}

		return $data;
	}

	public function redirect( $redirect = '' ) {
		$this->response->redirect( getenv( 'STATIC_BASE_URI' ) . $redirect );
		try {
			$this->response->send();
		} catch ( \Throwable $e ) {

		}
	}

	protected function addLoginLogs( $data, $uuid = 1, $ruid = 1, $type = 'INFO' ) {
	}

	protected function addAccessLogs( $data, $uuid = 1, $ruid = 1, $type = 'INFO' ) {
	}
}
