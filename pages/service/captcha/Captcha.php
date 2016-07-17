<?php
class Captcha extends AbstractAction {

	/**
	 * (non-PHPdoc)
	 *
	 * @see AbstractRequestController::view()
	 */
	public function view() {
		
		$this->vb->code=rand(10000,99999);
		$this->setSession("code", $this->vb->code);
		
	}
	
	public function display() {
		global $vb;
		
		$codeArray = str_split($vb->code);
		$formattedCode = "";
		foreach ( $codeArray as $digits ) {
			$formattedCode .= $digits . " ";
		}
		$im = imagecreatetruecolor(140, 30);
		$bg = imagecolorallocate($im, 22, 86, 165);
		$fg = imagecolorallocate($im, 255, 255, 255);
		imagefill($im, 0, 0, $bg);
		imagestring($im, 15, 30, 8,  $formattedCode, $fg);
		header("Cache-Control: no-cache, must-revalidate");
		header('Content-type: image/png');
		imagepng($im);
		imagedestroy($im);
	}
	
	public function page(){
		
	}
	
	/**
	 */
	public function isRestricted() {
		return false;
	}
	
	/**
	 */
	public function isService() {
		return true;
	}
	
}
