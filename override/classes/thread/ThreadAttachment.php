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

class ThreadAttachmentCore extends ObjectModel
{
    /** @var int parent id */
    public $id_thread;

    /** @var int depth of thread */
    public $id_attachment;

    /** @var array Errors displayed after post processing */
    public $errors = array();
	
    public static $definition = array(
        'table' => 'thread_attachment',
        'primary' => 'id_thread_attachment',
        'multilang' => false,
        'fields' => array(
        	'id_thread'	=>	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
        	'id_attachment'	=>	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
        )
    );

    /**
     * add attachments common
     *
     * @param not null values
     * @return bool
     */
    public static function addAttachment($threadAttachment, $location, $id, $type) 
    {
        if(!is_array($threadAttachment))
            $threadAttachment = array($threadAttachment);

        $errors = array();

        // $logger = new FileLogger();
        // $logger->setFilename('test.txt');
        // $logger->logError('------Step 0----');

        foreach($threadAttachment['tmp_name'] as $key => $tmp_name) 
        {
            $file_name = trim(str_replace([" ", "-", "(", ")"], "_", $threadAttachment['name'][$key]));
            $file_tmp = $threadAttachment['tmp_name'][$key];
            $file_size = $threadAttachment['size'][$key];

            $ext = pathinfo($file_name, PATHINFO_EXTENSION);

            if(!in_array($ext, Thread::THREAD_ATTACHMENT_EXTENSIONS)) {
                // Accepted extensions defined at Thread.php as THREAD_ATTACHMENT_EXTENSIONS
                $errors[] = "File format not supported.";
            }
            else if($file_size > (5 * 1024 * 1024)) { 
                // Accepted attachment size less than or equal to 2 MB 
                $errors[] = "File size is too large for a file ".$file_name;
            }
            else {
                // Get mime type of file
                $finfo = new finfo;
                $mime = $finfo->file($file_tmp, FILEINFO_MIME);

                // Add attachments to thread
                $attachment = new Attachment();
                $attachment->file = $ext;
                $attachment->mime = $mime;
                $attachment->file_name = $file_name;
                $attachment->file_size = $file_size;
                $attachment->name[1] = $file_name;
                $attachment->id_source = 1;
                $attachment->description[1] = strip_tags('Thread_'.$id.'_'.$file_name);

                if($attachment->add()) 
                {
                    $new_file_name = $attachment->id.($ext ? '.'.$ext : "");

                    if(!move_uploaded_file($file_tmp, "$location/$new_file_name")) {
                        $errors[] = "Unable to add attachment ".$file_name;
                    }
                    else {
                        switch ($type) {
                            case Thread::THREAD_ATTACHMENT:
                                $threadAttachmentObj = new ThreadAttachment();
                                $threadAttachmentObj->id_thread = $id;
                                $threadAttachmentObj->id_attachment = $attachment->id;
                                if(!$threadAttachmentObj->add()) {
                                    $errors[] = "Unable to add attachment ".$file_name;
                                }
                                break;

                            case Thread::THREAD_POST_ATTACHMENT:
                                $threadPostAttachmentObj = new ThreadPostAttachment();
                                $threadPostAttachmentObj->id_post = $id;
                                $threadPostAttachmentObj->id_attachment = $attachment->id;
                                if(!$threadPostAttachmentObj->add()) {
                                    $errors[] = "Unable to add attachment ".$file_name;
                                }
                                break;
                            
                            default:
                                break;
                        }
                    }
                }
            }
        }
            
        if(!empty($errors))
            return $errors;

        return true;
    }

    /**
     * remove attachments common
     *
     * @param not null values
     * @return bool
     */
    public static function removeAttachment($id_attachment, $type) 
    {
        $response = false;

        if($type == Thread::THREAD_ATTACHMENT) {
            $response = Db::getInstance()->delete('thread_attachment', 'id_attachment = '.intval($id_attachment).'');
        }
        else if($type == Thread::THREAD_POST_ATTACHMENT) {
            $response = Db::getInstance()->delete('thread_post_attachment', 'id_attachment = '.intval($id_attachment).'');
        }

        if($response) 
        {
            $attachment = new Attachment(intval($id_attachment));

            //unlink uploaded file
            Tools::deleteFile(Thread::THREAD_ATTACHMENT_LOCATION.'/'.$attachment->id.'.'.$attachment->file);

            return Db::getInstance()->delete('attachment', 'id_attachment = '.intval($id_attachment).'');
        }
    }

    /**
     * Add Drive Attachments
     */
    public static function addGoogleDriveAttachment($attachments, $id, $type) {
        $errors = array();
        foreach ($attachments as $key => $attach) {
            $attach = Tools::jsonDecode($attach, true);
            $filename = trim(str_replace([" ", "-", "(", ")"], "_", $attach['name']));
            $filetype = substr(strstr($filename, '.'), 1);
            $attachment = new Attachment();
            $attachment->file = $filetype;
            $attachment->mime = $attach['mimeType'];
            $attachment->file_name = $filename;
            $attachment->file_size = (int)$attach['sizeBytes'];
            $attachment->id_source = 2;
            $attachment->file_id = $attach['id'];
            $attachment->name[1] = $filename;
            $attachment->description[1] = strip_tags('Thread_'.$id_thread.'_'.$filename);

            if($attachment->add()) 
            { 
                switch ($type) {
                    case Thread::THREAD_ATTACHMENT:
                        $threadAttachmentObj = new ThreadAttachment();
                        $threadAttachmentObj->id_thread = $id;
                        $threadAttachmentObj->id_attachment = $attachment->id;
                        if(!$threadAttachmentObj->add()) {
                            $errors[] = "Unable to add attachment ".$file_name;
                        }
                        break;

                    case Thread::THREAD_POST_ATTACHMENT:
                        $threadPostAttachmentObj = new ThreadPostAttachment();
                        $threadPostAttachmentObj->id_post = $id;
                        $threadPostAttachmentObj->id_attachment = $attachment->id;
                        if(!$threadPostAttachmentObj->add()) {
                            $errors[] = "Unable to add attachment ".$file_name;
                        }
                        break;
                    
                    default:
                        break;
                }
            }
        }

        if(!empty($errors)) {
            return $errors;
        }

        return true;
    }
}