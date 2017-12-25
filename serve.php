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

require_once "api/UploadHandler.php";
require_once "api/Settings.php";

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
	http_response_code(405);
	die("Invalid method");
}

if($_GET["hash"]==null) {
	http_response_code(400);
	die("Image hash is missing");
}

$hash = $_GET["hash"];

$upload = UploadHandler::GetUpload($hash);

if($upload == null) {
	http_response_code(404);
	die("Upload doesn't exist");
}

#header(sprintf('Content-Disposition: attachment; filename="%s"', $upload->getFilename()));

//Detect images
$imageTypes = ["gif" => "gif", "jpeg" => "jpeg", "jpg" => "jpeg", "png" => "png", "svg" => "svg+xml", "webp" => "webp"];

$contentType = "text/plain";

if(array_key_exists($upload->getExtension(), $imageTypes)) {
	$contentType = "image/" . $imageTypes[$upload->getExtension()];
}

header(sprintf('Content-Type:%s;', $contentType));

#echo $upload->getPath();
readfile($upload->getPath());

?>