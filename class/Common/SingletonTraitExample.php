<?php

namespace XoopsModules\Chess\Common;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 *
 * @copyright      XOOPS Project  (https://xoops.org)
 * @license        GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author         Michael Beck <mambax7@gmailc.com>
 */

/**
 *  example of class definitions using SingletonTrait
 */
class DBFactory {
    /**
     * we are adding the trait here
     **/
    use SingletonTrait;

    /**
     * This class will have a single db connection as an example
     **/
    protected $db;


    /**
     * as an example we will create a PDO connection
     **/
    protected function __construct(){
        $this->db =
            new PDO('mysql:dbname=foodb;port=3305;host=127.0.0.1','foouser','foopass');
    }
}

/**
 * Class DBFactoryChild
 * @package XoopsModules\Chess\Common
 */
class DBFactoryChild extends DBFactory {
    /**
     * we repeating the inst so that it will differentiate it
     * from UserFactory singleton
     **/
    protected static $inst = null;
}


/**
 * example of instanciating the classes
 */
$uf0 = DBFactoryChild::getInstance();
var_dump($uf0);
$uf1 = DBFactory::getInstance();
var_dump($uf1);
echo $uf0 === $uf1;
