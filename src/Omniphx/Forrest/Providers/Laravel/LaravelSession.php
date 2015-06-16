<?php namespace Omniphx\Forrest\Providers\Laravel;

use Omniphx\Forrest\Interfaces\StorageInterface;
use Omniphx\Forrest\Exceptions\MissingKeyException;
use Illuminate\Config\Repository as Config;
use Illuminate\Session\SessionManager as Session;

class LaravelSession extends LaravelStorageProvider implements StorageInterface {

	public $path;

	protected $session;

	public function __construct(Config $config, Session $session)
	{
		$this->path = $config->get('forrest.storage.path');

		$this->session = $session;
	}

	/**
	 * Store into session.
	 * @param $key
	 * @param $value
	 * @return void
	 */
	public function put($key, $value)
	{
		return $this->session->put($this->path.$key, $value);
	}

	/**
	 * Get from session
	 * @param $key
	 * @return mixed
	 */
	public function get($key)
	{
		if ($this->session->has($this->path.$key)) {
			return $this->session->get($this->path.$key);
		}

		throw new MissingKeyException(sprintf("No value for requested key: %s",$key));
	}

	/**
	 * Check if storage has a key
	 * @param $key
	 * @return boolean
	 */
	public function has($key)
	{
		return $this->session->has($this->path.$key);
	}

}