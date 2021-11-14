<?php
/* ***** BEGIN LICENSE BLOCK *****
 *  
 * This file is part of FirePHP (http://www.firephp.org/).
 * 
 * Software License Agreement (New BSD License)
 * 
 * Copyright (c) 2006-2010, Christoph Dorn
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 * 
 *     * Redistributions of source code must retain the above copyright notice,
 *       this list of conditions and the following disclaimer.
 * 
 *     * Redistributions in binary form must reproduce the above copyright notice,
 *       this list of conditions and the following disclaimer in the documentation
 *       and/or other materials provided with the distribution.
 * 
 *     * Neither the name of Christoph Dorn nor the names of its
 *       contributors may be used to endorse or promote products derived from this
 *       software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * ***** END LICENSE BLOCK *****
 * 
 * @copyright   Copyright (C) 2007-2009 Christoph Dorn
 * @author      Christoph Dorn <christoph@christophdorn.com>
 * @license     http://www.opensource.org/licenses/bsd-license.php
 * @package     FirePHPCore
 */
if(!class_exists('FirePHP_AS4')) {
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'FirePHP_AS4.class.php';
}
function fb_AS4()
{
    $instance = FirePHP_AS4::getInstance(true);
    $args = func_get_args();
    return call_user_func_array(array($instance,'fb_AS4'),$args);
}
class FB_AS4
{
    public static function setEnabled($Enabled)
    {
        $instance = FirePHP_AS4::getInstance(true);
        $instance->setEnabled($Enabled);
    }
    public static function getEnabled()
    {
        $instance = FirePHP_AS4::getInstance(true);
        return $instance->getEnabled();
    }  
    public static function setObjectFilter($Class, $Filter)
    {
      $instance = FirePHP_AS4::getInstance(true);
      $instance->setObjectFilter($Class, $Filter);
    }
    public static function setOptions($Options)
    {
        $instance = FirePHP_AS4::getInstance(true);
        $instance->setOptions($Options);
    }
    public static function getOptions()
    {
        $instance = FirePHP_AS4::getInstance(true);
        return $instance->getOptions();
    }
    public static function send()
    {
        $instance = FirePHP_AS4::getInstance(true);
        $args = func_get_args();
        return call_user_func_array(array($instance,'fb_AS4'),$args);
    }
    public static function group($Name, $Options=null)
    {
        $instance = FirePHP_AS4::getInstance(true);
        return $instance->group($Name, $Options);
    }
    public static function groupEnd()
    {
        return self::send(null, null, FirePHP_AS4::GROUP_END);
    }
    public static function log($Object, $Label=null)
    {
        return self::send($Object, $Label, FirePHP_AS4::LOG);
    } 
    public static function info($Object, $Label=null)
    {
        return self::send($Object, $Label, FirePHP_AS4::INFO);
    } 
    public static function warn($Object, $Label=null)
    {
        return self::send($Object, $Label, FirePHP_AS4::WARN);
    } 
    public static function error($Object, $Label=null)
    {
        return self::send($Object, $Label, FirePHP_AS4::ERROR);
    } 
    public static function dump($Key, $Variable)
    {
        return self::send($Variable, $Key, FirePHP_AS4::DUMP);
    } 
    public static function trace($Label)
    {
        return self::send($Label, FirePHP_AS4::TRACE);
    } 
    public static function table($Label, $Table)
    {
        return self::send($Table, $Label, FirePHP_AS4::TABLE);
    } 
}
