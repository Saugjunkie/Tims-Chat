<?php
namespace wcf\page;
use \wcf\system\WCF;

/**
 * Shows information about Tims chat.
 *
 * @author 	Tim Düsterhus
 * @copyright	2010-2011 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	timwolla.wcf.chat
 * @subpackage	page
 */
class ChatCopyrightPage extends AbstractPage {
	public $neededModules = array('CHAT_ACTIVE');
	//public $neededPermissions = array('user.chat.canEnter');
	
	/**
	 * @see	\wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		//     ###
		//   ##   ##
		//  #       #
		//  # ##### #
		// # #     # #
		// # # * * # #
		// # #     # #
		// #  #   #  #
		//  #  ###  #
		//  #       #
		//   #######
		//   # # # #
		//   # # # #
		//   # # # #
		
		if (isset($_GET['sheep'])) $this->useTemplate = false;
	}
	
	/**
	 * @see	\wcf\page\IPage::show()
	 */
	public function show() {
		// guests are not supported
		if (!WCF::getUser()->userID) {
			throw new \wcf\system\exception\PermissionDeniedException();
		}
		
		parent::show();
		if ($this->useTemplate) exit;
		@header('Content-type: image/png');
		echo file_get_contents(__FILE__, null, null, __COMPILER_HALT_OFFSET__);
		exit;
	}
}
__halt_compiler();�PNG

   IHDR   �   �  KAt   sRGB ���   bKGD � � �����   	pHYs     ��   tIME�	��e�  IDATx����u�:�a��&���W�>�ƾ99+������w�c�h�$�m��y�;�ll߶m��������x�ѣ���y��F�	�û}���x������������秅�Z��[Mk�߽��Pc'�e�~t{��ik<o����u�%�i�|.\~6o�{)�c-�J��#�4����������O|�۩��Ml���\#�CjG�}���DO����t��������HCð�y�\���|%8����Ū�,Ŏ�;���z2�aG;.mLV�Ξ��S_�N�����
?U�$ep�t��A�|m��L��< )|�FVj?s]|Qe����2<K��V��F]:^�=�C}�1���%�F?�0O�D	]�	k��U�h>*�JX"<�U»��UB��0�R���8Lc��tJ��i%���Ө% �UUMJ*��R,�N�1�a���'gMଽ�kjQ�]g5�_�3Y|�ɜE��]Tq���*��+]��Y=|E74/M8�gg�������5`7L	ꚳ*x�uƊ�7�tp5T:����_X��!�}!ѥ���9�X�"��  ���>�KQJ,bk倿���d��B7$��JʧN��	���X+r�Z�+o�kqA�,b�X3V�I����H�ͮ�x�"��.Jk�L3�E,bK���z�g�X�Z6௬�{��9�X�j���:�~=��O�:��".(Jk5g����U�IU}�a��X�@_�k���,ݐX���E,b�X �     @k�8�K����2��c������*Ew���*?�wȁ��c���X�<��e?�6���
|��c�����Gn��?iw%�N$���i�$�Z�<�NI�+>������c���~��d+3$�L_cլw�N�����B����̐X`,0�Xh���nhq�X��ܳ �c���,���c����L����) �c���m�Ɵ M)l���%� �c�� �c�� �c���X$ c��     �T�q&�Nq�    IEND�B`�