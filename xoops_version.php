<?php

//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://www.xoops.org>                             //
//  ------------------------------------------------------------------------ //
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

$moduleDirName = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

// ------------------- Informations ------------------- //
$modversion = [
    'version' => 2.01,
    'module_status' => 'Alpha 1',
    'release_date' => '2020/05/19',
    'name' => _MI_CHESS,
    'description' => _MI_CHESS_DES,
    'official' => 0,
    //1 indicates official XOOPS module supported by XOOPS Dev Team, 0 means 3rd party supported
    'author' => '<a target="_blank" href="http://Dave-L.com/">Dave Lerner</a>, Mamba',

    'credits' => 'XOOPS Development Team',
    'author_mail' => 'author-email',
    'author_website_url' => 'https://xoops.org',
    'author_website_name' => 'XOOPS',
    'license' => 'GPL 2.0 or later',
    'license_url' => 'www.gnu.org/licenses/gpl-2.0.html/',
    // ------------------- Folders & Files -------------------
    'release_info' => 'Changelog',
    'release_file' => XOOPS_URL . "/modules/$moduleDirName/docs/changelog.txt",

    'manual' => 'link to manual file',
    'manual_file' => XOOPS_URL . "/modules/$moduleDirName/docs/install.txt",
    // images
    'image' => 'assets/images/logoModule.png',
    'iconsmall' => 'assets/images/iconsmall.png',
    'iconbig' => 'assets/images/iconbig.png',
    'dirname' => $moduleDirName,
    //Frameworks
    //    'dirmoduleadmin'      => 'Frameworks/moduleclasses/moduleadmin',
    //    'sysicons16'          => 'Frameworks/moduleclasses/icons/16',
    //    'sysicons32'          => 'Frameworks/moduleclasses/icons/32',
    // Local path icons
    'modicons16' => 'assets/images/icons/16',
    'modicons32' => 'assets/images/icons/32',
    //About
    'demo_site_url' => 'https://xoops.org',
    'demo_site_name' => 'XOOPS Demo Site',
    'support_url' => 'https://xoops.org/modules/newbb/viewforum.php?forum=28/',
    'support_name' => 'Support Forum',
    'submit_bug' => 'https://github.com/XoopsModules25x/' . $moduleDirName . '/issues',
    'module_website_url' => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    // ------------------- Min Requirements -------------------
    'min_php' => '7.1',
    'min_xoops' => '2.5.10',
    'min_admin' => '1.2',
    'min_db' => ['mysql' => '5.5'],
    // ------------------- Admin Menu -------------------
    'system_menu' => 1,
    'hasAdmin' => 1,
    'adminindex' => 'admin/index.php',
    'adminmenu' => 'admin/menu.php',
    // ------------------- Install/Update -------------------
    'onInstall' => 'include/install.php',
//    'onInstall' => 'include/oninstall.php',
//    'onUpdate' => 'include/onupdate.php',
    //  'onUninstall'         => 'include/onuninstall.php',
    // -------------------  PayPal ---------------------------
    'paypal' => [
        'business' => 'xoopsfoundation@gmail.com',
        'item_name' => 'Donation : ' . _MI_CHESS_NAME,
        'amount' => 0,
        'currency_code' => 'USD',
    ],
    // ------------------- Search ---------------------------
    'hasSearch' => 0,
    //    'search'              => [
    //        'file' => 'include/search.inc.php',
    //        'func' => 'pedigree_search',
    //    ],
    // ------------------- Comments -------------------------
    'hasComments' => 1,
    'comments' => [
        'itemName' => 'game_id',
        'pageName' => 'game.php',
    ],
    // ------------------- Mysql -----------------------------
    'sqlfile' => ['mysql' => 'sql/mysql.sql'],
    // ------------------- Tables ----------------------------
    'tables' => [
        $moduleDirName . '_' . 'games',
        $moduleDirName . '_' . 'challenges',
        $moduleDirName . '_' . 'ratings',
    ],
];

// ------------------- Help files ------------------- //
$modversion['help'] = 'page=help';
$modversion['helpsection'] = [
    ['name' => _MI_CHESS_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_CHESS_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_CHESS_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_CHESS_SUPPORT, 'link' => 'page=support'],
];

// Config
$grouparray = [];
$memberHandler = xoops_getHandler('member');
$groups = $memberHandler->getGroups();
foreach ($groups as $group) {
    if (XOOPS_GROUP_ANONYMOUS != $group->getVar('groupid')) {
        $grouparray[$group->getVar('name')] = $group->getVar('groupid');
    }
}

$modversion['config'][] = [
    'name' => 'groups_play',
    'title' => '_MI_CHESS_GROUPS_PLAY',
    'description' => '_MI_CHESS_GROUPS_PLAY_DES',
    'formtype' => 'group_multi',
    'valuetype' => 'array',
    'default' => [XOOPS_GROUP_ADMIN, XOOPS_GROUP_USERS],
];

$modversion['config'][] = [
    'name' => 'groups_delete',
    'title' => '_MI_CHESS_GROUPS_DELETE',
    'description' => '_MI_CHESS_GROUPS_DELETE_DES',
    'formtype' => 'group_multi',
    'valuetype' => 'array',
    'default' => [],
];

$modversion['config'][] = [
    'name' => 'allow_setup',
    'title' => '_MI_CHESS_ALLOW_SETUP',
    'description' => '_MI_CHESS_ALLOW_SETUP_DES',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 0,
];

$modversion['config'][] = [
    'name'        => 'max_items',
    'title'       => '_MI_CHESS_MAX_ITEMS',
    'description' => '_MI_CHESS_MAX_ITEMS_DES',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10,
];

$modversion['config'][] = [
    'name'        => 'rating_system',
    'title'       => '_MI_CHESS_RATING_SYSTEM',
    'description' => '_MI_CHESS_RATING_SYSTEM_DES',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => [
        _MI_CHESS_RATING_SYSTEM_NONE   => 'none',
        _MI_CHESS_RATING_SYSTEM_CXR    => 'cxr',
        _MI_CHESS_RATING_SYSTEM_LINEAR => 'linear',
    ],
    'default'     => 'cxr',
];

$modversion['config'][] = [
    'name'        => 'initial_rating',
    'title'       => '_MI_CHESS_INITIAL_RATING',
    'description' => '_MI_CHESS_INITIAL_RATING_DES',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 1200,
];

$modversion['config'][] = [
    'name'        => 'allow_unrated_games',
    'title'       => '_MI_CHESS_ALLOW_UNRATED',
    'description' => '_MI_CHESS_ALLOW_UNRATED_DES',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];


// Menu
$modversion['hasMain'] = 1;

$modversion['sub'][1]['name'] = _MI_CHESS_SMNAME1;
$modversion['sub'][1]['url'] = 'help.php';

$modversion['sub'][2]['name'] = _MI_CHESS_SMNAME2;
$modversion['sub'][2]['url'] = 'index.php';

// Conditional menu items
global $xoopsModule, $xoopsModuleConfig, $xoopsUser;
if (is_object($xoopsModule) && 'chess' == $xoopsModule->getVar('dirname')) {
    // Display create-game menu item if current user has the play-chess right.

    if (!empty($xoopsModuleConfig['groups_play']) && is_array($xoopsModuleConfig['groups_play'])
        && (            in_array(XOOPS_GROUP_ANONYMOUS, $xoopsModuleConfig['groups_play'])
            || (                is_object($xoopsUser) && count(array_intersect($xoopsUser->getGroups(), $xoopsModuleConfig['groups_play'])) > 0)
        )
    ) {
        $modversion['sub'][3]['name'] = _MI_CHESS_SMNAME3;
        $modversion['sub'][3]['url'] = 'create.php';
    }

    // Display ratings menu item if ratings system is enabled.

    if ('none' != $xoopsModuleConfig['rating_system']) {
        $modversion['sub'][4]['name'] = _MI_CHESS_SMNAME4;
        $modversion['sub'][4]['url'] = 'ratings.php';
    }

    // Display my-games menu item if current user is logged in.

    if (is_object($xoopsUser)) {
        $modversion['sub'][5]['name'] = _MI_CHESS_SMNAME5;
        $modversion['sub'][5]['url'] = 'player_stats.php?player_uid=' . $xoopsUser->getVar('uid');
    }
}

// Page Awareness
$modversion['pages'][] = [
    ['name' => _MI_CHESS_SMNAME1, 'url' => 'help.php'],
    ['name' => _MI_CHESS_SMNAME2, 'url' => 'index.php'],
    ['name' => _MI_CHESS_SMNAME3, 'url' => 'create.php'],
    ['name' => _MI_CHESS_SMNAME4, 'url' => 'ratings.php'],
    ['name' => _MI_CHESS_SMNAME5, 'url' => 'player_stats.php'],
];

// Templates
$modversion['templates'] = [
    ['file' => 'chess_games.tpl', 'description' => _MI_CHESS_INDEX],
    ['file' => 'chess_game_main.tpl', 'description' => _MI_CHESS_GAME],
    ['file' => 'chess_game_moveform.tpl', 'description' => _MI_CHESS_MOVE_FORM],
    ['file' => 'chess_game_promote_popup.tpl', 'description' => _MI_CHESS_PROMOTE_POPUP],
    ['file' => 'chess_game_board.tpl', 'description' => _MI_CHESS_BOARD],
    ['file' => 'chess_game_prefsform.tpl', 'description' => _MI_CHESS_PREFS_FORM],
    ['file' => 'chess_game_arbitrateform.tpl', 'description' => _MI_CHESS_ARBITER_FORM],
    ['file' => 'chess_help.tpl', 'description' => _MI_CHESS_HELP],
    ['file' => 'chess_ratings.tpl', 'description' => _MI_CHESS_RATINGS],
    ['file' => 'chess_player_stats.tpl', 'description' => _MI_CHESS_PLAYER_STATS],
];
// Blocks
$modversion['blocks'][] = [
    'file' => 'blocks.php',
    'name' => _MI_CHESS_GAMES,
    'description' => _MI_CHESS_GAMES_DES,
    'show_func' => 'b_chess_games_show',
    // options: maximum number of games to display | 1=show games in play only/2=show concluded games only/3=show both | 1=show rated games only/2=show rated and unrated games
    'options' => '4|3',
    'edit_func' => 'b_chess_games_edit',
    'template' => 'chess_block_games.tpl',
];

$modversion['blocks'][] = [
    'file' => 'blocks.php',
    'name' => _MI_CHESS_CHALLENGES,
    'description' => _MI_CHESS_CHALLENGES_DES,
    'show_func' => 'b_chess_challenges_show',
    // options: maximum number of challenges to display | 1=show open challenges only/2=show individual challenges only/3=show both
    'options' => '4|3',
    'edit_func' => 'b_chess_challenges_edit',
    'template' => 'chess_block_challenges.tpl',
];
$modversion['blocks'][] = [
    'file'        => 'blocks.php',
    'name'        => _MI_CHESS_PLAYERS,
    'description' => _MI_CHESS_PLAYERS_DES,
    'show_func'   => 'b_chess_players_show',
    // options: maximum number of players to display | 1=show non-provisional ratings only/2=show all ratings
    'options'     => '4|1',
    'edit_func'   => 'b_chess_players_edit',
    'template'    => 'chess_block_players.tpl',
];


// Notification
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'chess_notify_item_info';

$modversion['notification']['category'][] = [
    'name' => 'game',
    'title' => _MI_CHESS_NCAT_GAME,
    'description' => _MI_CHESS_NCAT_GAME_DES,
    'subscribe_from' => 'game.php',
    'item_name' => 'game_id',
    'allow_bookmark' => 1,
];

$modversion['notification']['category'][] = [
    'name' => 'global',
    'title' => _MI_CHESS_NCAT_GLOBAL,
    'description' => _MI_CHESS_NCAT_GLOBAL_DES,
    'subscribe_from' => ['index.php', 'game.php'],
];

$modversion['notification']['event'][] = [
    'name' => 'notify_game_move',
    'category' => 'game',
    'title' => _MI_CHESS_NEVT_MOVE,
    'caption' => _MI_CHESS_NEVT_MOVE_CAP,
    'description' => _MI_CHESS_NEVT_MOVE_DES,
    'mail_template' => 'notify_game_move',
    'mail_subject' => _MI_CHESS_NEVT_MOVE_SUB,
];

$modversion['notification']['event'][] = [
    'name' => 'notify_challenge_user',
    'category' => 'global',
    'title' => _MI_CHESS_NEVT_CHAL_USER,
    'caption' => _MI_CHESS_NEVT_CHAL_USER_CAP,
    'description' => _MI_CHESS_NEVT_CHAL_USER_DES,
    'mail_template' => 'notify_challenge_user',
    'mail_subject' => _MI_CHESS_NEVT_CHAL_USER_SUB,
];

$modversion['notification']['event'][] = [
    'name' => 'notify_challenge_open',
    'category' => 'global',
    'title' => _MI_CHESS_NEVT_CHAL_OPEN,
    'caption' => _MI_CHESS_NEVT_CHAL_OPEN_CAP,
    'description' => _MI_CHESS_NEVT_CHAL_OPEN_DES,
    'mail_template' => 'notify_challenge_open',
    'mail_subject' => _MI_CHESS_NEVT_CHAL_OPEN_SUB,
];

$modversion['notification']['event'][] = [
    'name' => 'notify_accept_challenge',
    'category' => 'global',
    'title' => _MI_CHESS_NEVT_ACPT_CHAL,
    'caption' => _MI_CHESS_NEVT_ACPT_CHAL_CAP,
    'description' => _MI_CHESS_NEVT_ACPT_CHAL_DES,
    'mail_template' => 'notify_accept_challenge',
    'mail_subject' => _MI_CHESS_NEVT_ACPT_CHAL_SUB,
];

$modversion['notification']['event'][] = [
    'name' => 'notify_request_arbitration',
    'category' => 'global',
    'title' => _MI_CHESS_NEVT_RQST_ARBT,
    'caption' => _MI_CHESS_NEVT_RQST_ARBT_CAP,
    'description' => _MI_CHESS_NEVT_RQST_ARBT_DES,
    'mail_template' => 'notify_request_arbitration',
    'mail_subject' => _MI_CHESS_NEVT_RQST_ARBT_SUB,
    'admin_only' => 1,
];
