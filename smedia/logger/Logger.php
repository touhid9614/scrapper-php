<?php

namespace sMedia\Logger;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;
use Monolog\Processor\IntrospectionProcessor;

class Logger
{
	protected static $_instance = null;
	/**
	 * loggers
	 *
	 * @var MonologLogger[]
	 */
	public $loggers = [];
	public $paths = [];

	public function __construct()
	{
		$this->_add();
	}

	public function _add($name = 'default', $path = 'php://stdout')
	{
		$formatter = new LineFormatter(null, null, false, true);
		$handler = new StreamHandler($path, MonologLogger::DEBUG);
		$handler->setFormatter($formatter);

		$logger = new MonologLogger($name);
		$logger->pushHandler($handler);
		$logger->pushProcessor(new IntrospectionProcessor(MonologLogger::ERROR, array(), 1));
		$this->loggers[$name] = $logger;
		$this->paths[$path] = $name;

		return $logger;
	}

	public function _get($name)
	{
		if (!isset($this->loggers[$name])) {
			return null;
		}

		return $this->loggers[$name];
	}

	public function _getByPath($path)
	{
		if (!isset($this->paths[$path])) {
			return null;
		}

		return $this->_get($this->paths[$path]);
	}

	public static function add($name, $path)
	{
		return self::instance()->_add($name, $path);
	}

	public static function get($name = 'default')
	{
		return self::instance()->_get($name);
	}

	public static function getByPath($path)
	{
		return self::instance()->_getByPath($path);
	}

	public function _remove($name)
	{
		if (isset($this->loggers[$name])) {
			unset($this->paths[array_search($name, $this->paths)]);
			unset($this->loggers[$name]);
		}
	}

	public static function remove($name)
	{
		self::instance()->_remove($name);
	}

	public function _removeByPath($path)
	{
		if (isset($this->paths[$path])) {
			self::instance()->_remove($this->paths[$path]);
		}
	}

	public static function removeByPath($path)
	{
		self::instance()->_removeByPath($path);
	}

	public static function info($message, $context, $name = 'default')
	{
		self::instance()->get($name)->info($message, $context);
	}

	public static function debug($message, $context, $name = 'default')
	{
		self::instance()->get($name)->debug($message, $context);
	}

	public static function notice($message, $context, $name = 'default')
	{
		self::instance()->get($name)->notice($message, $context);
	}

	public static function alert($message, $context, $name = 'default')
	{
		self::instance()->get($name)->alert($message, $context);
	}

	public static function warning($message, $context, $name = 'default')
	{
		self::instance()->get($name)->warning($message, $context);
	}

	public static function critical($message, $context, $name = 'default')
	{
		self::instance()->get($name)->critical($message, $context);
	}

	public static function emergency($message, $context, $name = 'default')
	{
		self::instance()->get($name)->emergency($message, $context);
	}

	public static function error($message, $context, $name = 'default')
	{
		self::instance()->get($name)->error($message, $context);
	}

	public static function log($level, $message, $context, $name = 'default')
	{
		self::instance()->get($name)->log($level, $message, $context);
	}


	public static function instance(): Logger
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}
