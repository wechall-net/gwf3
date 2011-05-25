<?php
abstract class SR_Grenade extends SR_Usable
{
	public abstract function onThrow(SR_Player $player, SR_Player $target);
	
	public function isItemFriendly() { return false; }
	public function isItemOffensive() { return true; }
	
	public function onItemUse(SR_Player $player, array $args)
	{
		if (!$player->getParty()->isFighting()) {
			$player->message('This item works only in combat.');
			return false;
		}
		
		if ( (count($args) === 0) || (false === ($target = $this->getOffensiveTarget($player, $args[0]))) ) {
			$player->message('You need a valid target to throw a '.$this->getName().'. Try 1,2,..,N to enumerate enemies.');
			return false;
		}
		$this->announceUsage($player, $target);
		
		$this->onThrow($player, $target);
		
		return true;
	}
	
	/**
	 * Compute the distances to an explosion.
	 * Imagaine the game like this
	 * A
	 *  B   E
	 *       F
	 *    CD
	 * ---0m---
	 * @param SR_Player $target
	 * @param unknown_type $radius
	 * @param unknown_type $atk
	 * @param unknown_type $atk_delta
	 */
	public static function computeDistances(SR_Player $target, $inaccuracy=3)
	{
		$party = $target->getParty();
		$members = $party->getMembers();
		
		$coords = array();
		$x = $y = 0;
		foreach ($members as $m)
		{
			$m instanceof SR_Player;
			$y = $m->getDistance();
			$coords[$m->getID()] = array($x, $y);
			$x += SR_Party::X_COORD_INC;
		}
		
		$handicap = rand(-$inaccuracy*10, +$inaccuracy*10);
		$handicap/= 10;
		$g_x = $coords[$target->getID()][0] + $handicap;

		$handicap = rand(-$inaccuracy*10, +$inaccuracy*10);
		$handicap/= 10;
		$g_y = $coords[$target->getID()][1] + $handicap;
		
		echo sprintf("Grenade has coords %.02f / %.02f\n", $g_x, $g_y);
		
		$back = array();
		foreach ($coords as $uid => $data)
		{
			list($p_x, $p_y) = $data;
			$d = Shadowfunc::calcDistanceB($g_x, $g_y, $p_x, $p_y);
			$p = Shadowrun4::getPlayerByPID($uid);
			$back[] = array($uid, $d);
			echo sprintf("%s has coords %.02f / %.02f (distance: %.02f)\n", $p->getName(), $p_x, $p_y, $d);
		}
		return $back;
	}
}
?>