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

class Settings {
	private static $setting_defaults = ["max_upload_size" => 8*1024*1024, "upload_serve_path" => "/var/www/uploads"];
	public static function getSettingValue($key) {
		$connection = Database::getConnection();

		$statement = $connection->prepare("SELECT `id` FROM `settings` WHERE `key`=?;");
		//echo mysqli_error($connection);
		$statement->bind_param("s", $key);
		$statement->store_result();
		$result = $statement->get_result();

		if($statement->num_rows == 0) {
			return self::$setting_defaults[$key];
		}

		return $result->fetch_array()["value"];
	}
}

?>