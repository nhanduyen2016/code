<?php

class dl_alfafile_net extends Download {

	public function CheckAcc($cookie){
		$data = $this->lib->curl("https://alfafile.net/user", "lang=en;{$cookie}", "");
        if (stristr($data, "Premium, till")) return array (true, "Premium Until: ".$this->lib->cut_str($data, "Premium, till","</span>")."<br/>Bandwidth available: ". $this->lib->cut_str($data, 'sp_bandwidth_used">', '</span'));
        elseif (stristr($data, 'Free')) return array (false, "accfree");
        else return array (false, "accinvalid");
	}
	
	public function Login($user, $pass){
		$data = $this->lib->curl("https://alfafile.net/user/login/?url=%2F", "lang=en", "email={$user}&password={$pass}&remember_me=1");
		$cookie = "lang=en;".$this->lib->GetCookies($data);
		return $cookie;
	}
	
    public function Leech($url) {
		$data = $this->lib->curl($url,$this->lib->cookie,"");
        if(stristr($data, "<strong>404</strong>")) $this->error("dead", true, false, 2);
		elseif(!$this->isredirect($data)) {
			if(preg_match('/href="(https?:\/\/.+alfafile\.net\/dl\/.+)" class/i', $data, $link)) return trim($link[1]);
		}
		else return trim($this->redirect);
		return false;
	}

}

/*
* Open Source Project
* Vinaget by ..::[H]::..
* Version: 2.7.0
* Alfafile Download Plugin 
* Downloader Class By [FZ]
* Fix check acc by Sky™ [28.03.2016]
*/
?>