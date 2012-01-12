<?php
/**
 * Move Board up or down in position.
 * @author gizmore
 */
final class Forum_Move extends GWF_Method
{
	public function getUserGroups() { return 'moderator'; }
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($bid = Common::getGet('up'))) {
			return $this->move($this->_module, -1, $bid);
		}
		if (false !== ($bid = Common::getGet('down'))) {
			return $this->move($this->_module, +1, $bid);
		}
		return GWF_HTML::err('ERR_PARAMETER', array(_FILE__, __LINE__, 'move'));
	}
	
	private function move(Module_Forum $module, $dir=-1, $bid)
	{
		if (false === ($board = GWF_ForumBoard::getBoard($bid))) {
			return $this->_module->error('err_board');
		}
		
		if ($board->isRoot()) {
			return GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'board_is_root'));
		}
		
		$myPos = $board->getVar('board_pos');
		$pid = $board->getVar('board_pid');
		
		
		$cmp = $dir === 1 ? '>' : '<';
		$orderby = $dir === 1 ? 'board_pos ASC' : 'board_pos DESC';
		if (false === ($swap = $board->selectFirst('1', "board_pid=$pid AND board_pos$cmp$myPos", $orderby))) {
			return $this->_module->requestMethodB('Forum');
		}
		
		$swapPos = $swap->getVar('board_pos');
		
		if (false === ($board->saveVar('board_pos', $swapPos))) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		if (false === ($swap->saveVar('board_pos', $myPos))) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		$this->cleanupPositions();
		
		$this->_module->setCurrentBoard(GWF_ForumBoard::getBoard($pid));
		
		GWF_ForumBoard::init(true, true);
		

		return $this->_module->requestMethodB('Forum');
	}
	
	private function cleanupPositions()
	{
		$table = GDO::table('GWF_ForumBoard');
		if (false === ($result = $table->select('*', '', 'board_pos ASC'))) {
			return;
		}
		$pos = 1;
		while (false !== ($row = $table->fetch($result, GDO::ARRAY_O)))
		{
			$row->saveVar('board_pos', $pos++);
		}
		$table->free($result);
		return;
	}
}

?>