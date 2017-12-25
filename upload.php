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

require_once "api/ApiKeyHandler.php";
require_once "api/Settings.php";
require_once "api/UploadHandler.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	//http_response_code(405);
	//die("Invalid method: " . $_SERVER["REQUEST_METHOD"]);
}

if(!isset($_POST["key"])) {
	http_response_code(400);
	die("Key field is missing");
}

if(!ApiKeyHandler::isValidApiKey($_POST["key"])) {
	http_response_code(403);
	die("Invalid api key");
}

$api_key = $_POST["key"];

$data = ApiKeyHandler::getKeyData($api_key);

$file = $_FILES["f"];
$name = $file["name"];
$size = $file["size"];
$nameHash = substr(hash("sha512", mt_rand()), 0, 8);

$temp = explode('.', $name);
$extension = strtolower(end($temp));

if($size>Settings::getSettingValue("max_upload_size")) {
	http_response_code(400);
	die("Uploaded file is too large");
}

if($file["error"] != 0) {
	http_response_code(500);
	die("Internal server error: " . $file["error"]);
}

$upload_path = Settings::getSettingValue("upload_serve_path");
$path =  sprintf("%s/%s.%s", $upload_path, hash("sha256", mt_rand() . "a"), $extension);

//Makes sure there isn't any trickery that attempts to place the file outside the containing folder...
/*if(strpos(realpath($path), realpath($upload_path)) === false) {
	http_response_code(400);
	die("Security error: " . $path . " vs " . realpath($upload_path));
}*/


move_uploaded_file($file['tmp_name'], $path);

UploadHandler::RegisterUpload($path, $nameHash, $name, $extension, $data["id"]);

echo json_encode(["hash" => $nameHash, "extension" => $extension]);

http_response_code(200);

?>