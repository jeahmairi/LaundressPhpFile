<?php
	class DB
	{
		static $db = null;
		static $hostname = "localhost";
		static $dbname = "laundress";
		static $username  = "root";
		static $password = "";

		public static function transact_db($sql, $params=array(), $transactType)
		{
			if(!is_array($params))
				$params = array($params);

			$rows = array();
			try
			{
				$db = new PDO("mysql:host=". self::$hostname ."; dbname=". self::$dbname,  self::$username,  self::$password);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$cmd = $db->prepare($sql);
				$cmd->execute($params);
				if($transactType == "SELECT")
					$rows = $cmd->fetchAll();
				else
					$rows = $db->lastInsertId();				
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
			$db = null;
			unset($db);
			return $rows;
		}
	}
?>
