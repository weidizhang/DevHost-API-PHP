Dev-Host PHP API
================
Dev-Host PHP API is a class wrapper for uploading files to d-h.st.
It supports anonymous/user accounts and there are customizable options
for uploading your file, including public/non-public, folder, and the description.

Download
========
You can clone this repo.

Example Usage
=============
		require "class.devhost.php";
		$devHost = new DevHost();
		$devHost->UserAuth("username", "password");
		echo $devHost->UploadFile("/home/verywow/muchfile.zip", "wow description", 1 /* public */);