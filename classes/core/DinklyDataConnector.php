<?php
/**
 * DinklyDataConnector
 *
 * 
 *
 * @package    Dinkly
 * @subpackage CoreClasses
 * @author     Christopher Lewis <lewsid@lewsid.com>
 */
class DinklyDataConnector
{
	/**
	 * Fetch database connection from DB credentials in Config file
	 *
	 * @param int $error_mode int 0 = no errors, 1 = show warnings, 2 = throw exceptions
	 * @return PDO object with chosen error mode
	 */
	public static function fetchDB($error_mode = 1)
	{
		$pdo_err_mode = null;
		if($error_mode == 0) $pdo_err_mode = PDO::ERRMODE_SILENT;
		else if($error_mode == 1) $pdo_err_mode = PDO::ERRMODE_WARNING;
		else if($error_mode == 2) $pdo_err_mode = PDO::ERRMODE_EXCEPTION;

		$creds = DinklyDataConfig::getDBCreds();
		
		$db = new PDO(
				"mysql:host=".$creds['host'].";dbname=".$creds['name'],
				$creds['user'],
				$creds['pass']
		);

		$db->setAttribute(PDO::ATTR_ERRMODE, $pdo_err_mode);

		return $db;
	}
	
	/**
	 * Test function to make check for successful DB connection
	 *
	 * @param int $error_mode Int  1 = show warnings
	 * @return bool true on successful connection false otherwise
	 * @throws Exception if connection failed
	 */
	public static function testDB($error_mode = 1)
	{
		try
		{
			self::fetchDB();
		}
		catch (PDOException $e)
		{
    		echo "Connection failed: " . $e->getMessage() . "\n";
    		return false;
		}

		return true;
	}
}