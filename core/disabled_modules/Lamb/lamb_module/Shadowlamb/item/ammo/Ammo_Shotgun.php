<?php
final class Item_Ammo_Shotgun extends SR_Ammo
{
	public function getItemLevel() { return 10; }
	public function getItemPrice() { return .67; }
	public function getItemWeight() { return 3; }
	public function getItemDefaultAmount() { return 40; }
	public function getItemDescription() { return 'Ammo for shotguns.'; }
}
?>