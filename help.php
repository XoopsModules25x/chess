<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

/**
 * Generates Help page.
 *
 * @package chess
 * @subpackage help
 */

/**#@+
 */

include '../../mainfile.php';
$xoopsOption['template_main'] = 'chess_help.html';
$xoopsConfig['module_cache'][$xoopsModule->getVar('mid')] = 0; // disable caching
include_once XOOPS_ROOT_PATH . '/header.php';
require_once XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->getVar('dirname').'/include/functions.inc.php';
if (file_exists(XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->getVar('dirname').'/language/'.$xoopsConfig['language'].'/help.php')) {
	include_once XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->getVar('dirname').'/language/'.$xoopsConfig['language'].'/help.php';
} else {
	include_once XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->getVar('dirname').'/language/english/help.php';
}

$rating_system          = chess_moduleConfig('rating_system');
$rating_system_des_name = '_HE_CHESS_RATINGS_' . strtoupper($rating_system);
if (defined($rating_system_des_name)) {
	$rating_system_des = constant($rating_system_des_name);
} else {
	// missing constant definition - display name of constant for diagnostic use
	$rating_system_des = $rating_system_des_name;
}

$xoopsTpl->assign('chess_allow_setup',         chess_moduleConfig('allow_setup'));
$xoopsTpl->assign('chess_rating_system',       $rating_system);
$xoopsTpl->assign('chess_rating_system_des',   $rating_system_des);
$xoopsTpl->assign('chess_allow_unrated_games', chess_moduleConfig('allow_unrated_games'));
$xoopsTpl->assign('chess_allow_delete',        chess_can_delete());
$xoopsTpl->assign('chess_is_admin',            is_object($xoopsUser) and $xoopsUser->isAdmin($xoopsModule->getVar('mid')));

include_once XOOPS_ROOT_PATH . '/footer.php';

/**#@-*/

?>
