<?php

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright     {@link https://xoops.org/ XOOPS Project}
 * @license       {@link http://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package      Chess
 * @since        2.01
 * @author        XOOPS Development Team
 */

/**
 * Prepares system prior to attempting to install module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_install_chess(\XoopsModule $module)
{
    //    require  dirname(__DIR__) . '/preloads/autoloader.php';

    require __DIR__ . '/common.php';

    $utility = new \XoopsModules\Chess\Utility();

    //check for minimum XOOPS version

    $xoopsSuccess = $utility::checkVerXoops($module);

    // check for minimum PHP version

    $phpSuccess = $utility::checkVerPhp($module);

    if ($xoopsSuccess && $phpSuccess) {
        $moduleTables = &$module->getInfo('tables');

        foreach ($moduleTables as $table) {
            $GLOBALS['xoopsDB']->queryF('DROP TABLE IF EXISTS ' . $GLOBALS['xoopsDB']->prefix($table) . ';');
        }
    }

    return $xoopsSuccess && $phpSuccess;
}

/**
 * Performs tasks required during installation of the module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if installation successful, false if not
 */
function xoops_module_install_chess(\XoopsModule $module)
{
    require_once dirname(__DIR__) . '/preloads/autoloader.php';

    $moduleDirName = basename(dirname(__DIR__));

    /** @var \XoopsModules\Chess\Helper $helper */

    /** @var \XoopsModules\Chess\Utility $utility */

    /** @var \XoopsModules\Chess\Common\Configurator $configurator */

    $helper = \XoopsModules\Chess\Helper::getInstance();

    $utility = new \XoopsModules\Chess\Utility();

    $configurator = new \XoopsModules\Chess\Common\Configurator();

    // Load language files

    $helper->loadLanguage('admin');

    $helper->loadLanguage('modinfo');

    // default Permission Settings ----------------------

    $moduleId = $module->getVar('mid');

    //$moduleName = $module->getVar('name');

    $grouppermHandler = xoops_getHandler('groupperm');

    // access rights ------------------------------------------

    $grouppermHandler->addRight($moduleDirName . '_approve', 1, XOOPS_GROUP_ADMIN, $moduleId);

    $grouppermHandler->addRight($moduleDirName . '_submit', 1, XOOPS_GROUP_ADMIN, $moduleId);

    $grouppermHandler->addRight($moduleDirName . '_view', 1, XOOPS_GROUP_ADMIN, $moduleId);

    $grouppermHandler->addRight($moduleDirName . '_view', 1, XOOPS_GROUP_USERS, $moduleId);

    $grouppermHandler->addRight($moduleDirName . '_view', 1, XOOPS_GROUP_ANONYMOUS, $moduleId);

    //  ---  CREATE FOLDERS ---------------

    if (count($configurator->uploadFolders) > 0) {
        //    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {

        foreach (array_keys($configurator->uploadFolders) as $i) {
            $utility::createFolder($configurator->uploadFolders[$i]);
        }
    }

    //  ---  COPY blank.png FILES ---------------

    if (count($configurator->copyBlankFiles) > 0) {
        $file = dirname(__DIR__) . '/assets/images/blank.png';

        foreach (array_keys($configurator->copyBlankFiles) as $i) {
            $dest = $configurator->copyBlankFiles[$i] . '/blank.png';

            $utility::copyFile($file, $dest);
        }
    }

    /*
        //  ---  COPY test folder files ---------------
    if (count($configurator->copyTestFolders) > 0) {
        //        $file =  dirname(__DIR__) . '/testdata/images/';
        foreach (array_keys($configurator->copyTestFolders) as $i) {
            $src  = $configurator->copyTestFolders[$i][0];
            $dest = $configurator->copyTestFolders[$i][1];
            $utility::xcopy($src, $dest);
        }
    }
    */

    //delete .html entries from the tpl table

    $sql = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix('tplfile') . " WHERE `tpl_module` = '" . $module->getVar('dirname', 'n') . "' AND `tpl_file` LIKE '%.html%'";

    $GLOBALS['xoopsDB']->queryF($sql);

    return true;
}
