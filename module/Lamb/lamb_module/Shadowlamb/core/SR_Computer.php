<?php
abstract class SR_Computer
{
	#################
	### Overrides ###
	#################
	public function getMaxAttempts() { return 2; }
	public function getMinHits() { return 2; }
	public function getComputerLevel(SR_Player $player) { return 0.5; }
	public function onCommand(SR_Player $player, array $args) {}
	
	public function onFailed(SR_Player $player, $hits, $n)
	{
		$message = sprintf('Your %s. hacking attemp against the %s box failed with %s hits.', $n, $this->getName(), $hits);
		echo "$message\n";
		$player->message('Your hacking attempt failed.');
	}
	
	public function onHacked(SR_Player $player, $hits)
	{
		$message = sprintf('You have hacked the %s box with %s hits.', $this->getName(), $hits);
		echo "$message\n";
	}
	
	###############
	### Factory ###
	###############
	private static $COMPUTERS = array();
	/**
	 * Get a computer by name.
	 * @param string $computer
	 * @return SR_Computer
	 */
	public static function getInstance($computer)
	{
		if (!isset(self::$COMPUTERS[$computer]))
		{
			$classname = 'PC_'.$computer;
			if (!class_exists($classname))
			{
				return false;
			}
			self::$COMPUTERS[$computer] = new $classname();
			self::$COMPUTERS[$computer]->setName($computer);
		}
		return self::$COMPUTERS[$computer];
	}
	
	############
	### Name ###
	############
	private $name;
	
	public function getName() { return $this->name; }
	public function setName($name) { $this->name = $name; }
	
	###############
	### Hacking ###
	###############
	private $hackers = array();
	
	public function onReset(SR_Party $party)
	{
		echo "Resetting\n";
		foreach ($party->getMembers() as $player)
		{
			$this->onResetPlayer($player);
		}
	}
	
	public function onResetPlayer(SR_Player $player)
	{
		unset($this->hackers[$player->getID()]);
	}
	
	public function onHack(SR_Player $player, SR_Cyberdeck $cyberdeck)
	{
		$bot = Shadowrap::instance($player);
		if ($this->hasHacked($player))
		{
			$bot->reply('Not again');
			return false;
		}
		
		$pid = $player->getID();
		
		$com = $player->get('computers');
		$cyb = $cyberdeck->getCyberdeckLevel();
		$atk = Shadowfunc::diceFloat(0, $com*2.0 + $cyb*2.0 + 2.0, 2);
		
		$com = $this->getComputerLevel($player);
		$def = Shadowfunc::diceFloat(0, $com*3.2  + 3.0 , 2);
		
		$hits = round(($atk-$def) * 10 - $this->getMinHits());
		
		if ($hits > 0)
		{
			$this->hackers[$pid] = $this->getMaxAttempts();
			return $this->onHacked($player, $hits);
		}
		
		return $this->onFailed($player, $hits, $this->hackers[$pid]);
	}
	
	public function hasHacked(SR_Player $player)
	{
		$pid = $player->getID();
		
		if (!isset($this->hackers[$pid]))
		{
			$this->hackers[$pid] = 1;
		}
		else
		{
			$this->hackers[$pid]++;
		}
		
		return $this->hackers[$pid] > $this->getMaxAttempts();
	}
}
?>