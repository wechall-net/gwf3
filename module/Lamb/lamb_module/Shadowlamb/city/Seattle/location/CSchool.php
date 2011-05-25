<?php
final class Seattle_CSchool extends SR_School
{
	public function getFoundPercentage() { return 00.00; }
	public function getFoundText(SR_Player $player) { return "You find a small school \"Caesums school of cryptography and applied math\". You wonder if you should improve your math skills."; }
	public function getNPCS(SR_Player $player) { return array('talk' => 'Seattle_Caesum'); }
	public function getEnterText(SR_Player $player) { return "You enter the school."; }
	public function getHelpText(SR_Player $player) { $c = LambModule_Shadowlamb::SR_SHORTCUT; return "You can use {$c}talk, {$c}learn, {$c}courses, {$c}view and {$c}buy here."; }
	public function getFields(SR_Player $player)
	{
		return array(
			array('math', 5000),
			array('cryptography', 5000),
			array('steganography', 5000),
		);
	}
}
?>