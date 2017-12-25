<?php
/**
 * This file is part of microhost.
 *
 * Copyright (C) 2017 Liam Svanåsbakken Crouch <http://petterroea.com/> and contributors.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3.0 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once "Database.php";

class ApiKeyHandler {
	public static function generateApiKey($name) {
		$key = sha512(mt_rand()+","+time());

		$connection = Database::getConnection();

		$statement = $connecton->prepare("INSERT INTO `apiKeys`(`key`, `name`) VALUES (?, ?)");
		$statement->bind_param("ss", $key, $name);
		$statement->execute();

		return $key;
	}
	public static function isValidApiKey($key) {
		$connection = Database::getConnection();

		$statement = $connection->prepare("SELECT `id` FROM `apiKeys` WHERE `key`=?;");

		//echo mysqli_error($connection);
		$statement->bind_param("s", $key);
		$statement->execute();
		$statement->store_result();

		return $statement->num_rows > 0;
	}

	public static function getKeyData($key) {
		$connection = Database::getConnection();

		$statement = $connection->prepare("SELECT `id`, `name` FROM `apiKeys` WHERE `key`=?;");
		$statement->bind_param("s", $key);
		$statement->execute();
		$result = $statement->get_result();

		$row = $result->fetch_array();
		if($row==null) {
			return false;
		}
		return ["name" => $row["name"], "id" => $row["id"]];
	}
}

?>