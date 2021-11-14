<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class ThreadPostCore extends ObjectModel
{
    /** @var int thread id */
    public $id_activity;

    /** @var text post value */
    public $post_value;

    /** @var int is deleted */
    public $delete;

    /** @var date added **/
    public $date_add;
	
    public static $definition = array(
        'table' => 'thread_post',
        'primary' => 'id_post',
        'multilang' => false,
        'fields' => array(
            'id_activity'   =>  array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'post_value' =>    array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml'),
            'delete' =>    array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'date_add'  =>  array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        )
    );

    /** attachment location **/
    const THREAD_POST_ATTACHMENT_LOCATION = 'docs/thread/thread_post_attachments';

    public static function getThreadPostDetails($id_activity) {
        $sql = new DbQuery();
        $sql->select('tp.*');
        $sql->from('thread_post', 'tp');
        $sql->where('tp.`id_activity` = '.intval($id_activity).'');
        $sql->orderBy('tp.`id_post` ASC');
        $posts = Db::getInstance()->executeS($sql);

        foreach ($posts as $key => $post) {
            $posts[$key]['attachments'] = ThreadPost::getAttachments($post['id_post']);
        }

        return $posts;
    }

    public static function getAttachments($id_post) {
        $sql = new DbQuery();
        $sql->select('a.*, al.*');
        $sql->from('thread_post_attachment', 'tpa');
        $sql->leftJoin('attachment', 'a', 'tpa.`id_attachment` = a.`id_attachment`');
        $sql->leftJoin('attachment_lang', 'al', 'a.`id_attachment` = al.`id_attachment`');
        $sql->where('tpa.`id_post` = '.intval($id_post).'');
        return Db::getInstance()->executeS($sql);
    }

    public function addAttachment($attachment, $attachment_source) {
        if($attachment_source == '1') {
            return ThreadAttachment::addAttachment($attachment, ThreadPost::THREAD_POST_ATTACHMENT_LOCATION, $this->id, Thread::THREAD_POST_ATTACHMENT);
        }
        elseif ($attachment_source == '2') {
            return ThreadAttachment::addGoogleDriveAttachment($attachment, $this->id, Thread::THREAD_POST_ATTACHMENT);
        }
    }
}