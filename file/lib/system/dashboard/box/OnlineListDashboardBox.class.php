<?php
namespace chat\system\dashboard\box;
use chat\data;

/**
 * Dashboard box that shows chatters.
 * 
 * @author	Tim Düsterhus
 * @copyright	2010-2014 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.chat
 * @subpackage	system.dashboard.box
 */
class OnlineListDashboardBox extends \wcf\system\dashboard\box\AbstractContentDashboardBox {
	/**
	 * all rooms in the current installation
	 * @var array<\chat\data\room\Room>
	 */
	public $rooms = array();
	
	/**
	 * @see	wcf\system\dashboard\box\IDashboardBox::init()
	 */
	public function init(\wcf\data\dashboard\box\DashboardBox $box, \wcf\page\IPage $page) {
		parent::init($box, $page);
		
		if (!MODULE_CHAT) return;
		if (!\wcf\system\WCF::getUser()->userID) return;
		
		$this->rooms = data\room\RoomCache::getInstance()->getRooms();
		
		foreach ($this->rooms as $key => $room) {
			if (!$room->canEnter()) unset($this->rooms[$key]);
		}
	}
	
	/**
	 * @see	wcf\system\dashboard\box\AbstractContentDashboardBox::render()
	 */
	protected function render() {
		if (!MODULE_CHAT) return false;
		if (!\wcf\system\WCF::getUser()->userID) return false;
		
		\wcf\system\WCF::getTPL()->assign(array(
			'rooms' => $this->rooms
		));
		
		return \wcf\system\WCF::getTPL()->fetch('dashboardBoxOnlineList', 'chat');
	}
}
