<?php
/**********************
 * class.devhost.php
 * An API for uploading files to d-h.st
 * @author Weidi Zhang <weidiz999@yahoo.com>
 * @license LGPL
 *********************/
set_time_limit(0);

class DevHost
{
	private $token;
	
	public function UserAuth($username, $password) {
		$dvhLogin = $this->getPage("http://d-h.st/api/user/auth?user=" . $username . "&pass=" . $password);
		$respXml = simplexml_load_string($dvhLogin);
		
		if ($respXml->response == "Error") {
			return false;
		}
		else {
			$this->token = (string) $respXml->token;
			return true;
		}
	}
	
	public function UploadFile($file /* must be full path */, $description = "", $public = 0, $uploadfolder = 0) {
		$postData = array(
			"action" => "uploadapi",
			"files[]" => "@" . $file,
			"file_description[]" => $description,
			"public" => $public,
			"uploadfolder" => $uploadfolder
		);
		if ($this->token != null) {
			$postData["token"] = $this->token;
		}
		
		print_r($postData);
		
		$response = $this->getPage("http://api.d-h.st/upload", $postData);
		return $response;
	}
	
	private function getPage($url, $postdata = "") {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:12.0) Gecko/20120403211507 Firefox/14.0.1');
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		if ($postdata != "") {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		}
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}
?>