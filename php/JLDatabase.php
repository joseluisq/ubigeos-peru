<?php

/**
 * JLDatabase
 * Database handler class based in PDO.
 * @package 		JLDatabase
 * @version     1.0
 * @copyright   Copyright (C) 2011 Jose Luis Quintana
 * @author      Jose Luis Quintana <joseluisquintana20@gmail.com>
 * @link        http://joseluisquintana.pe/
 * @access      public
 *
 * @property PDO $_dbh PHP Data Object
 */
class JLDatabase {

	const DRIVER_MSSQL = 'mssql'; // FreeTDS / DMicrosoft SQL Server / Sybase
	const DRIVER_MSSYBASE = 'sybase';
	const DRIVER_MSDBLIB = 'dblib';
	const DRIVER_FIREBIRD = 2; // Firebird / Interbase 6
	const DRIVER_IBM = 3; // IBM DB2
	const DRIVER_INFORMIX = 4; // IBM Informix Dynamic Server
	const DRIVER_MYSQL = 'mysql'; // MySQL 3.x / 4.x / 5.x
	const DRIVER_OCI = 'oci'; // Oracle Call Interface
	const DRIVER_ODBC = 7; // ODBC v3 (IBM DB2, unixODBC and win32 ODBC)
	const DRIVER_PGSQL = 'pgsql'; // PostgreSQL
	const DRIVER_SQLITE = 9; // SQLite 3 and SQLite 2
	const PORT_MYSQL = '3306';
	const PORT_PGSQL = '5432';
	const PORT_OCI = '1521';

	private static $_instance = null;
	private static $_dbh = null;
	private $_dsn = null;
	private $_options = null;
	private $_driver = null;
	private $_username = null;
	private $_password = null;
	private $_databasename = null;
	private $_hostname = null;
	private $_port = null;
	private $_charset = 'utf8';
	private $_collation = 'utf8_bin';
	private $_is_connected = false;

	private function buildDsn() {
		$dns = $this->_dsn;

		if ($this->_dsn == null) {
			$driver = $this->_driver;
			$hostname = $this->_hostname;
			$databasename = $this->_databasename;

			switch ($driver) {
				case self::DRIVER_MYSQL:
					$port = ($this->_port) ? self::PORT_MYSQL : $this->_port;
					$dns = "$driver:host=$hostname;port=$port;dbname=$databasename";
					break;

				case self::DRIVER_PGSQL:
					$port = ($this->_port) ? self::PORT_PGSQL : $this->_port;
					$dns = "$driver:host=$hostname;port=$port;dbname=$databasename";
					break;

				case self::DRIVER_MSSQL;
				case self::DRIVER_MSSYBASE;
				case self::DRIVER_MSDBLIB;
				//$port = ($this->_port) ? self::PORT_MSSQL : $this->_port;
					$dns = "$driver:host=$hostname;dbname=$databasename";
					break;

				case self::DRIVER_OCI:
					$port = ($this->_port) ? self::PORT_OCI : $this->_port;
					$dns = "$driver:dbname=//$hostname:$port/$databasename";
					break;
				default:
					die('Sorry, the driver is not supported.');
					break;
			}
		}

		$this->_dsn = $dns;

		return $dns;
	}

	private function buildOptions() {
		$charset = $this->_charset;
		$options = $this->_options;

		if (is_null($options) && $this->_driver == 'mysql') {
			$options = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $charset,
				PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => TRUE);
		}

		return $options;
	}

	private function setConnection() {
		$dsn = $this->buildDsn();
		$options = $this->buildOptions();

		try {
			$dbh = new PDO($dsn, $this->_username, $this->_password, $options);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->_is_connected = true;
			$this->_dsn = $dsn;
			$this->_options = $options;
			self::$_dbh = $dbh;
		} catch (PDOException $e) {
			die('<b>Connection failed:</b> ' . $e->getMessage());
		}
	}

	/**
	 * JLDatabase::getInstance()
	 * Get a unique Instance to the JLDatabase class
	 * @return JLDatabase
	 */
	public static function getInstance() {
		if (self::$_instance == null) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function isConnected() {
		return $this->_is_connected;
	}

	public function connect() {
		if (!$this->_is_connected) {

			$this->setConnection();
		}

		return $this->_is_connected;
	}

	public function setPort($port) {
		$this->_port = $port;
	}

	public function setCharset($charset) {
		$this->_charset = $charset;
	}

	public function setCollation($collation) {
		$this->_collation = $collation;
	}

	public function setDriver($driver) {
		$this->_driver = $driver;
	}

	public function setUserName($username) {
		$this->_username = $username;
	}

	public function setPassword($password) {
		$this->_password = $password;
	}

	public function setDatabaseName($databasename) {
		$this->_databasename = $databasename;
	}

	public function setOptions($options) {
		$this->_options = $options;
	}

	public function setHostName($hostname) {
		$this->_hostname = $hostname;
	}

	public function setDSN($dsn) {
		$this->_dsn = $dsn;
	}

	/**
	 * @return PDO Php data object
	 */
	public function getConnection() {
		return self::$_dbh;
	}

	public function getDriver() {
		return $this->_driver;
	}

	public function getUserName() {
		return $this->_username;
	}

	public function getPassword() {
		return $this->_password;
	}

	public function getDatabaseName() {
		return $this->_databasename;
	}

	public function getOptions() {
		return $this->_options;
	}

	public function getHostName() {
		return $this->_hostname;
	}

	public function getPort() {
		return $this->_port;
	}

	public function getDSN() {
		return $this->_dsn;
	}

}
