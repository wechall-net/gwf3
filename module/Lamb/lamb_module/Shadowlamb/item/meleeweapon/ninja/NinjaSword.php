<?php
final class Item_NinjaSword extends SR_MeleeWeapon
{
	public function getAttackTime() { return 40; }
	public function getItemLevel() { return 12; }
	public function getItemWeight() { return 1030; }
	public function getItemPrice() { return 4096; }
	public function getItemDescription() { return 'A black, slim and deadly sword. Sweet.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 9.5, 
			'min_dmg' => 3.5,
			'max_dmg' => 13.5,
		);
	}
}
?>