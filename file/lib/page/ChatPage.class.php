<?php
namespace wcf\page;
use \wcf\data\chat;
use \wcf\system\cache\CacheHandler;
use \wcf\system\WCF;

/**
 * Shows the chat-interface
 *
 * @author 	Tim Düsterhus
 * @copyright	2010-2011 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	timwolla.wcf.chat
 * @subpackage	page
 */
class ChatPage extends AbstractPage {
	public $chatVersion = '';
	public $neededModules = array('CHAT_ACTIVE');
	//public $neededPermissions = array('user.chat.canEnter');
	public $newestMessages = array();
	public $room = null;
	public $roomID = 0;
	public $rooms = array();
	public $smilies = array();
	public $userData = array();
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'chatVersion' => $this->chatVersion,
			'newestMessages' => $this->newestMessages,
			'room' => $this->room,
			'roomID' => $this->roomID,
			'rooms' => $this->rooms,
			'smilies' => $this->smilies
		));
	}
	
	/**
	 * Reads chat-version. Used to avoid caching of JS-File when Tims Chat is updated.
	 */
	public function readChatVersion() {
		CacheHandler::getInstance()->addResource(
			'packages',
			WCF_DIR.'cache/cache.packages.php',
			'wcf\system\cache\builder\PackageCacheBuilder'
		);
		$packages = CacheHandler::getInstance()->get('packages');
		foreach ($packages as $package) {
			if ($package->package != 'timwolla.wcf.chat') continue;
			$this->chatVersion = $package->packageVersion;
			return;
		}
	}
	
	/**
	 * @see	\wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		$this->readRoom();		
		$this->userData['color'] = \wcf\util\ChatUtil::readUserData('color');
		\wcf\util\ChatUtil::writeUserData(array('roomID' => $this->room->roomID));
		$this->newestMessages = chat\message\ChatMessageList::getNewestMessages($this->room, CHAT_LASTMESSAGES);
		\wcf\util\ChatUtil::writeUserData(array('lastSeen' => end($this->newestMessages)->messageID));
		
		if (CHAT_DISPLAY_JOIN_LEAVE) {
			$messageAction = new chat\message\ChatMessageAction(array(), 'create', array(
				'data' => array(
					'roomID' => $this->room->roomID,
					'sender' => WCF::getUser()->userID,
					'username' => WCF::getUser()->username,
					'time' => TIME_NOW,
					'type' => chat\message\ChatMessage::TYPE_JOIN,
					'message' => '',
					'color1' => $this->userData['color'][1],
					'color2' => $this->userData['color'][2]
				)
			));
			$messageAction->executeAction();
			$return = $messageAction->getReturnValues();
		}
		
		$this->readDefaultSmileys();
		$this->readChatVersion();
	}
	
	/**
	 * Reads the smilies in the default category.
	 */
	public function readDefaultSmileys() {
		$smilies = \wcf\data\smiley\SmileyCache::getInstance()->getSmilies();
		$this->smilies = $smilies[null];
	}
	
	/**
	 * @see	\wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if ($this->action == 'Message') {
			new ChatMessagePage();
			exit;
		}
		else if ($this->action == 'Log') {
			//TODO: Initialise LogPage
			exit;
		}
		else if ($this->action == 'RefreshRoomList') {
			new ChatRefreshRoomListPage();
			exit;
		}
		else if ($this->action == 'Send') {
			new \wcf\form\ChatForm();
			exit;
		}
		else if ($this->action == 'Copyright') {
			new ChatCopyrightPage();
			exit;
		}
		
		if (isset($_REQUEST['id'])) $this->roomID = (int) $_REQUEST['id'];
		if (isset($_REQUEST['ajax'])) $this->useTemplate = false;
	}
	
	/**
	 * Reads room data.
	 */
	public function readRoom() {
		$this->rooms = chat\room\ChatRoom::getCache();
		
		if ($this->roomID === 0) {
			// no room given
			try {
				// redirect to first chat-room
				$this->rooms->seek(0);
				\wcf\util\HeaderUtil::redirect(\wcf\system\request\LinkHandler::getInstance()->getLink('Chat', array(
					'object' => $this->rooms->current()
				)));
				exit;
			}
			catch (\OutOfBoundsException $e) {
				// no valid room found
				throw new \wcf\system\exception\IllegalLinkException();
			}
		}
		
		$this->room = $this->rooms->search($this->roomID);
		if (!$this->room) throw new \wcf\system\exception\IllegalLinkException();
		if (!$this->room->canEnter()) throw new \wcf\system\exception\PermissionDeniedException();
	}
	
	/**
	 * @see	\wcf\page\IPage::show()
	 */
	public function show() {
		// guests are not supported
		if (!WCF::getUser()->userID) {
			throw new \wcf\system\exception\PermissionDeniedException();
		}
		\wcf\system\menu\page\PageMenu::getInstance()->setActiveMenuItem('wcf.header.menu.chat');
		
		// remove index breadcrumb
		WCF::getBreadcrumbs()->remove(0);
		parent::show();
		// break if not ajax
		if ($this->useTemplate) exit;
		@header('Content-type: application/json');
		
		echo \wcf\util\JSON::encode(array(
			'title' => $this->room->getTitle(),
			'topic' => WCF::getLanguage()->get($this->room->topic)
		));
		exit;
	}
}
