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

class UploadHandler {
	public static function RegisterUpload($filePath, $hashId, $realFileName, $extension, $uploader) {
		$connection = Database::getConnection();

		$statement = $connection->prepare("INSERT INTO `uploads`(`path`, `hash`, `extension`, `filename`, `uploader`) VALUES (?, ?, ?, ?, ?)");
		$statement->bind_param("ssssi", $filePath, $hashId, $extension, $realFileName, $uploader);
		$statement->execute();
	}
	public static function GetUpload($hash) {
		$connection = Database::getConnection();

		$statement = $connection->prepare("SELECT * FROM `uploads` WHERE `hash`=?;");
		$statement->bind_param("s", $hash);
		$statement->execute();
		//$statement->store_result();
		$result = $statement->get_result();

		return $result->fetch_object("Upload");
	}
}

class Upload {
	private $path;
	private $hash;
	private $filename;
	private $extension;
	private $uploader;


	/*public function __construct($hash, $filename, $path, $extension, $uploader) {
		$this->hash = $hash;
		$this->filename = $filename;
		$this->path = $path;
		$this->extension = $extension;
		$this->uploader = $uploader;
	}*/

	public function getHash() {
		return $this->hash;
	}

	public function getFilename() {
		return $this->filename;
	}

	public function getPath() {
		return $this->path;
	}

	public function getExtension() {
		return $this->extension;
	}
}

?>