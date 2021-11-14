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

class ThreadCore extends ObjectModel
{
    /** @var int parent id */
    public $id_parent = 0;

    /** @var int thread source */
    public $id_source;

    /** @var int is private thread */
    public $mode = 0;

    /** @var int thread owner */
    public $id_employee;

    /** @var int is active */
    public $active = 1;

    /** @var datetime thread added time */
    public $date_add;

    /** @var string thread name */
    public $name;

    /** @var text thread description */
    public $description = NULL;

    /** @var int status of thread */
    public $id_state;

    /** @var int assignee id */
    public $id_assignee;

    /** @var int thread priority */
    public $priority;

    /** @var datetime timeline of thread */
    public $timeline;

    /** @var datetime thread last updated */
    public $date_upd;

    /** @var array Errors displayed after post processing */
    public $errors = array();

    /** Thread attachment extensions var **/
    const THREAD_ATTACHMENT_EXTENSIONS = array("jpeg", "jpg", "png", "gif", "pdf", "doc", "docx", "xls", "xlsx", "csv");

    /** Thread attachment and posts location **/
    const THREAD_ATTACHMENT_LOCATION = 'docs/thread/thread_attachments';

    /** Attachment types **/
    const THREAD_ATTACHMENT = 1;
    const THREAD_POST_ATTACHMENT = 2;

    /** Changes, Requests and Post Flags categorization for mail alerts **/
    const CATEGORY_NEW_THREAD = 1;
    const CATEGORY_THREAD_UPDATE = 2;
    const CATEGORY_THREAD_REQUEST = 3;
    const CATEGORY_THREAD_POST = 4;
    const CATEGORY_SUB_THREAD = 5;
    const CATEGORY_BULK_UPDATE = 6;


    public static $definition = array(
        'table' => 'thread',
        'primary' => 'id_thread',
        'multilang' => true,
        'multilang_shop' => true,
        'fields' => array(
            /* Thread master */
        	'id_parent'	=>	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
        	'id_source'	=>	array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
        	'mode'	=>	array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
        	'id_employee'	=>	array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
        	'active'	=>	array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
        	'date_add' =>	array('type' => self::TYPE_DATE, 'validate' => 'isDate'),

            /* Lang fields */
        	'name' =>	array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCatalogName', 'required' => true, 'size' => 128),
            'description' =>	array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'id_state'	=>	array('type' => self::TYPE_INT, 'lang' => true, 'required' => true, 'validate' => 'isUnsignedId'),
            'id_assignee'	=>	array('type' => self::TYPE_INT, 'lang' => true, 'required' => true,'validate' => 'isUnsignedId'),
            'priority'	=>	array('type' => self::TYPE_INT, 'lang' => true, 'required' => true, 'validate' => 'isUnsignedId'),
            'timeline'	=>	array('type' => self::TYPE_DATE, 'lang' => true, 'required' => true, 'validate' => 'isDate'),
            'date_upd'	=>	array('type' => self::TYPE_DATE, 'lang' => true, 'validate' => 'isDate'),
        )
    );

    /**
     * add threads
     *
     * @param mixed $null_values
     * @return bool
     */
    public function add($autodate = true, $null_values = false)
    {
        $ret = parent::add($autodate, $null_values);

        Hook::exec('actionThreadAdd', array('thread' => $this));

        return $ret;
    }

    /**
     * update thread positions in parent
     *
     * @param mixed $null_values
     * @return bool
     */
    public function update($null_values = false)
    {
        if ($this->id_parent == $this->id) {
            throw new PrestaShopException('a thread cannot be its own parent');
        }

        $ret = parent::update($null_values);
        Hook::exec('actionThreadUpdate', array('thread' => $this));

        return $ret;
    }

    public function addAttachment($attachment, $attachment_source) {        
        switch ($attachment_source) {
            case '1':
                return ThreadAttachment::addAttachment($attachment, $this::THREAD_ATTACHMENT_LOCATION, $this->id, $this::THREAD_ATTACHMENT);
                break;
            case '2':
                return ThreadAttachment::addGoogleDriveAttachment($attachment, $this->id, $this::THREAD_ATTACHMENT);
                break;
            default:
                break;
        }
    }

    public function addFollower($threadFollowers) 
    {        
        if(!is_array($threadFollowers)) {
            $threadFollowers = explode(',', $threadFollowers);
        }

        foreach ($threadFollowers as $key => $value) {
            $follower = new ThreadFollower(); // Intialize follower object        
            $follower->id_thread = $this->id;
            $follower->id_follower = $value;
            if(!$follower->add()) {
                $this->errors[] = "Unable to add follower to thread.";
            }
        }

        if(empty($this->errors)) {
            return true;
        }
        else {
            return false;
        }
    }

    public function removeFollower($follower) {
        return Db::getInstance()->delete('thread_followers', 'id_thread = '.intval($this->id).' AND id_follower = '.intval($follower).'');
    }

    public static function getAllThreads($id_employee = 0, $active = true) 
    {
        $sql = 'SELECT 
                    th.*, thl.`name` AS title, CONCAT(emp.`firstname`, " ", emp.`lastname`) AS assignee,
                    ths.`name` AS thread_state, thl.`timeline`, thl.`priority`,
                    IF(th.`id_parent` != 0, 1, 0) AS subthread
                FROM `'._DB_PREFIX_.'thread` th
                LEFT JOIN `'._DB_PREFIX_.'thread_lang` thl ON th.`id_thread` = thl.`id_thread`
                LEFT JOIN `'._DB_PREFIX_.'employee` emp ON thl.`id_assignee` = emp.`id_employee`
                LEFT JOIN `'._DB_PREFIX_.'thread_followers` thf ON th.`id_thread` = thf.`id_thread`
                LEFT JOIN `'._DB_PREFIX_.'thread_state` ths ON thl.`id_state` = ths.`id_state`
                WHERE thl.`id_lang` = 1
                AND th.`active` = '.boolval($active).'
                AND (
                    th.`id_employee` = '.$id_employee.' 
                    OR thl.`id_assignee` = '.$id_employee.' 
                    OR thf.`id_follower` = '.$id_employee.'
                )
                GROUP BY th.`id_thread`';
        return Db::getInstance()->executeS($sql);
    }

    public function getAttachments() 
    {
        $sql = 'SELECT
                    a.*, al.* 
                FROM `'._DB_PREFIX_.'thread_attachment` ta
                LEFT JOIN `'._DB_PREFIX_.'attachment` a ON ta.`id_attachment` = a.`id_attachment`
                LEFT JOIN `'._DB_PREFIX_.'attachment_lang` al ON a.`id_attachment` = al.`id_attachment` AND al.`id_lang` = 1
                WHERE ta.`id_thread` = '.intval($this->id).'';
        return Db::getInstance()->executeS($sql);
    }

    public function getDetails() 
    {
        if (!$this->context) {
            $this->context = Context::getContext();
        }

        $id_employee = $this->context->employee->id;

        $sql = 'SELECT 
                    th.*, thl.`name` AS title, CONCAT(emp.`firstname`, " ", emp.`lastname`) AS assignee,
                    CONCAT(emp1.`firstname`, " ", emp1.`lastname`) AS owner, 
                    emp1.`id_employee` AS owner_id, thl.`id_assignee`,
                    ths.`name` AS thread_state, ths.`id_state`, thl.`timeline`, 
                    thl.`priority`, thl.`description`, IF(th.`id_parent` != 0, 1, 0) AS subthread, 
                    IF(th.`mode` = 1, "Charter", "Public") AS mode, th.`mode` AS mode_id,
                    IF(th.`id_employee` = '.$id_employee.' OR thl.`id_assignee` = '.$id_employee.', true, false) AS can_edit
                FROM `'._DB_PREFIX_.'thread` th
                LEFT JOIN `'._DB_PREFIX_.'thread_lang` thl ON th.`id_thread` = thl.`id_thread`
                LEFT JOIN `'._DB_PREFIX_.'employee` emp ON thl.`id_assignee` = emp.`id_employee`
                LEFT JOIN `'._DB_PREFIX_.'employee` emp1 ON th.`id_employee` = emp1.`id_employee`
                LEFT JOIN `'._DB_PREFIX_.'thread_state` ths ON thl.`id_state` = ths.`id_state`
                WHERE thl.`id_lang` = 1 AND th.`id_thread` = '.intval($this->id).'';
        return Db::getInstance()->executeS($sql);
    }

    /**
     * Return an array of all children of the current thread
     *
     * @param int $id_lang
     * @return PrestaShopCollection Collection of Thread
     */
    public function getAllChildren()
    {
        $sql = new DbQuery();
        $sql->select('th.*, thl.`name` AS title, CONCAT(emp.`firstname`, " ", emp.`lastname`) AS assignee,
            CONCAT(emp1.`firstname`, " ", emp1.`lastname`) AS owner,
            ths.`name` AS thread_state, thl.id_state, thl.`timeline`, thl.`priority`, thl.`description`');
        $sql->from('thread', 'th');
        $sql->leftJoin('thread_lang', 'thl', 'th.`id_thread` = thl.`id_thread`');
        $sql->leftJoin('employee', 'emp', 'thl.`id_assignee` = emp.`id_employee`');
        $sql->leftJoin('employee', 'emp1', 'th.`id_employee` = emp1.`id_employee`');
        $sql->leftJoin('thread_state', 'ths', 'thl.`id_state` = ths.`id_state`');
        $sql->where('thl.`id_lang` = 1 AND th.`id_parent` = '.intval($this->id).'');
        $result = Db::getInstance()->executeS($sql);

        if(sizeof($result) > 0) {
            foreach ($result as $key => $value) {
                $result[$key]['can_access'] = $this->getThreadAccess($value['id_thread']);
            }
        }

        return $result;
    }

    /**
     * Return parent detail of the thread
     */
    public function getParentDetails() {
        $sql = new DbQuery();
        $sql->select('th.*, thl.`name` AS title, CONCAT(emp.`firstname`, " ", emp.`lastname`) AS assignee,
            CONCAT(emp1.`firstname`, " ", emp1.`lastname`) AS owner,
            ths.`name` AS thread_state, thl.`timeline`, thl.`priority`, thl.`description`');
        $sql->from('thread', 'th');
        $sql->leftJoin('thread_lang', 'thl', 'th.`id_thread` = thl.`id_thread`');
        $sql->leftJoin('employee', 'emp', 'thl.`id_assignee` = emp.`id_employee`');
        $sql->leftJoin('employee', 'emp1', 'th.`id_employee` = emp1.`id_employee`');
        $sql->leftJoin('thread_state', 'ths', 'thl.`id_state` = ths.`id_state`');
        $sql->where('thl.`id_lang` = 1 AND th.`id_thread` = '.intval($this->id_parent).'');
        $result = Db::getInstance()->executeS($sql);

        if(sizeof($result) > 0) {
            foreach ($result as $key => $value) {
                $result[$key]['can_access'] = $this->getThreadAccess($value['id_thread']);
            }
        }

        return $result;
    }

    /**
     * Return array of all followers of thread
     */
    public function getFollowers() 
    {
        $sql = 'SELECT 
                    tf.`id_thread_follower`, tf.`id_thread`, tf.`id_follower`, 
                    CONCAT(emp.`firstname`, " ", emp.`lastname`) AS follower_name,
                    emp.`email`
                FROM `'._DB_PREFIX_.'thread_followers` tf
                LEFT JOIN `'._DB_PREFIX_.'employee` emp ON tf.`id_follower` = emp.`id_employee`
                WHERE tf.`id_thread` = '.intval($this->id).'';
        return Db::getInstance()->executeS($sql);
    }

    /**
     * Return whether user can access thread or not
     */
    public function getThreadAccess($id_thread) {
        if(!$this->context) {
            $this->context = Context::getContext();
        }

        $can_access = true;
        $employee_id = $this->context->employee->id;
        $thread = new Thread(intval($id_thread));
        $thread_followers = $thread->getFollowers();

        if($thread->mode == 0) {
            return $can_access;
        }
        else {
            if($thread->id_employee == $employee_id) {
                return $can_access;
            }
            else if($thread->id_assignee[1] == $employee_id) {
                return $can_access;
            }
            else if(sizeof($thread_followers) > 0) {
                foreach ($thread_followers as $follower) {
                    if($follower['id_follower'] == $employee_id) {
                        return $can_access;
                    }
                }
            }
        }
            
        return !$can_access;
    }

    /**
     * Return array of all statuses of thread
     */
    public static function getAvailableStates($active = true) 
    {
        return Db::getInstance()->executeS('SELECT * FROM `'._DB_PREFIX_.'thread_state` WHERE active = '.boolval($active).'');
    }

    /**
     * Return array of all activities of thread
     */
    public function getActivities() 
    {
        if(!$this->context) {
            $this->context = Context::getContext();
        }

        $activities = Db::getInstance()->executeS('SELECT ta.*, tat.`code`, tat.`name` AS activity_name,
            CONCAT(emp.`firstname`, " ", emp.`lastname`) AS activity_triggered_person, 
            IF(emp.`id_employee` = '.$this->context->employee->id.', 1, 0) AS can_edit
            FROM `'._DB_PREFIX_.'thread_activity` ta
            LEFT JOIN `'._DB_PREFIX_.'employee` emp ON ta.`id_employee` = emp.`id_employee`
            LEFT JOIN `'._DB_PREFIX_.'thread_activity_types` tat ON ta.`id_activity_type` = tat.`id_activity_type`
            WHERE ta.`id_thread` = '.intval($this->id).' ORDER BY ta.`id_activity` ASC'
        );

        foreach ($activities as $key => $activity) 
        {
            switch ($activity['id_activity_type']) 
            {
                case ThreadActivity::THREAD_DETAIL_CHANGE: // Thread Changes
                    $activities[$key]['changes'] = Db::getInstance()->executeS('SELECT tc.*, tct.`name` AS change_type_name 
                    FROM `'._DB_PREFIX_.'thread_changes` tc 
                    LEFT JOIN `'._DB_PREFIX_.'thread_change_types` tct ON tc.`id_change_type` = tct.`id_change_type`
                    WHERE tc.`id_activity` = '.intval($activity['id_activity']).' 
                    ORDER BY tc.`id_change` ASC');
                    break;
                
                case ThreadActivity::THREAD_POST: // Thread Posts
                    $activities[$key]['posts'] = ThreadPost::getThreadPostDetails($activity['id_activity']);
                    break;

                case ThreadActivity::THREAD_CHANGE_REQEST: // Thread Requests
                    $activities[$key]['requests'] = Db::getInstance()->executeS('SELECT tr.*, trt.`name` AS request_type_name
                    FROM `'._DB_PREFIX_.'thread_requests` tr 
                    LEFT JOIN `'._DB_PREFIX_.'thread_request_types` trt ON tr.`id_request_type` = trt.`id_request_type`
                    WHERE tr.id_activity = '.intval($activity['id_activity']).'
                    ORDER BY tr.`id_request` ASC');
                    break;

                default:
                    break;
            }
        }

        return $activities;
    }

    /**
     * Return last done activity ID same as current activity else return false
     */
    public function continueActivity($id_employee, $id_activity_type) 
    {
        $lastActivity = Db::getInstance()->getRow('SELECT ta.* 
            FROM `'._DB_PREFIX_.'thread_activity` ta
            WHERE ta.`id_thread` = '.intval($this->id).' 
            AND ta.`id_activity` = (SELECT MAX(ta1.`id_activity`) FROM `'._DB_PREFIX_.'thread_activity` ta1 
            WHERE ta1.`id_thread` = '.intval($this->id).')');

        if(($id_employee == $lastActivity['id_employee'] && $id_activity_type == $lastActivity['id_activity_type'])) {
            return $lastActivity['id_activity'];
        }
        
        return false;
    }

    /**
     * Adding activity for thread
     * New entry created if not matched with previously created activity
     */
    public function addActivity($id_employee, $id_activity_type, $id_change_type = null, $object = null) 
    {
        $id_activity = $this->continueActivity($id_employee, $id_activity_type);

        if(!$id_activity) {
            $activity = new ThreadActivity();
            $activity->id_thread = $this->id;
            $activity->id_activity_type = $id_activity_type;
            $activity->id_employee = $id_employee;
            if($activity->add()) {
                $id_activity = $activity->id;
            }
        }

        if($id_activity_type == ThreadActivity::THREAD_DETAIL_CHANGE) {
            return $this->addChange($id_activity, $id_change_type, $object);
        }
        else if($id_activity_type == ThreadActivity::THREAD_POST) {
            return $this->addPost($id_activity, $object);
        }
        else if($id_activity_type == ThreadActivity::THREAD_CHANGE_REQEST) {
            return $this->addRequest($id_activity, $id_change_type, $object);
        }
        else {
            return false;
        }
    }

    /**
     * Add thread changes
     * Trigger mail and notify about chages
     */
    public function addChange($id_activity, $id_change_type, $object) 
    {
        if (!$this->context) {
            $this->context = Context::getContext();
        }

        $change = new ThreadChange();
        $change->id_activity = $id_activity;
        $change->id_change_type = $id_change_type;


        $response = true;
        $content = '';
        $mail_vars = $this->getMailVars();

        $content = '<p>Changes by ' . $mail_vars['owner_name'] . ':</p><br />';

        // Identify value which type of change
        if($id_change_type == ThreadChangeType::ASSIGNEE_CHANGE) {
            $assignee_old = new Employee(intval($object->id_assignee[1]));
            $assignee_new = new Employee(intval($this->id_assignee[1]));
            $change->old_value = strip_tags($assignee_old->firstname.' '.$assignee_old->lastname);
            $change->new_value = strip_tags($assignee_new->firstname.' '.$assignee_new->lastname);
            $mail_vars['data']['{content_main}'] = $content . '<p>Assigned to: '.$change->old_value.' => '.$change->new_value.'</p>';
            $response = $change->add();
            // Notify changes through SMS( High Priority / Important cases)
            if($response) {
                $msgtxt = 'Hello '.$mail_vars['assignee_name'].' , You have been assigned to flight #'.$this->id.': '.$this->name[$this->context->language->id].' by ' . $mail_vars['owner_name'];
                SMSAlert::sendSMSAlert($mail_vars['assignee']->mobile, $msgtxt);
            }
        }
        else if($id_change_type == ThreadChangeType::DESCRIPTION_CHANGE) {
            $change->old_value = $object->description[1];
            $change->new_value = $this->description[1];
            $mail_vars['data']['{content_main}'] = $content . '<p>Description changed to: '.$change->old_value.' => '.$change->new_value.'</p>';
            $response = $change->add();
        }
        else if($id_change_type == ThreadChangeType::TITLE_CHANGE) {
            $change->old_value = strip_tags($object->name[1]);
            $change->new_value = strip_tags($this->name[1]);
            $mail_vars['data']['{content_main}'] = $content . '<p>Name changed to: '.$change->old_value.' => '.$change->new_value.'</p>';
            $response = $change->add();
        }
        else if($id_change_type == ThreadChangeType::STATE_CHANGE) {
            $state_old = new ThreadState(intval($object->id_state[1]));
            $state_new = new ThreadState(intval($this->id_state[1]));
            $change->old_value = $state_old->name;
            $change->new_value = $state_new->name;
            $mail_vars['data']['{content_main}'] = $content . '<p>Status changed to: '.$change->old_value.' => '.$change->new_value.'</p>';
            $response = $change->add();
            
            // Notify changes through SMS( High Priority / Important cases)
            if($response) {
                $msgtxt = 'Hello '.$mail_vars['assignee_name'].' , Your flight #'.$this->id.': '.$this->name[$this->context->language->id].' status changed to '.$change->old_value.' => '.$change->new_value.' by ' . $mail_vars['owner_name'];
                SMSAlert::sendSMSAlert($mail_vars['assignee']->mobile, $msgtxt);
            }
        }
        else if($id_change_type == ThreadChangeType::TIMELINE_CHANGE) {
            $change->old_value = $object->timeline[1];
            $change->new_value = $this->timeline[1];
            $mail_vars['data']['{content_main}'] = $content . '<p>Landing time changed to: '.$change->old_value.' => '.$change->new_value.'</p>';
            $response = $change->add();
            
            // Notify changes through SMS( High Priority / Important cases)
            if($response) {
                $msgtxt = 'Hello '.$mail_vars['assignee_name'].' , Your flight #'.$this->id.': '.$this->name[$this->context->language->id].' landing time changed to '.$change->old_value.' => '.$change->new_value.' by ' . $mail_vars['owner_name'];
                SMSAlert::sendSMSAlert($mail_vars['assignee']->mobile, $msgtxt);
            }
        }
        else if($id_change_type == ThreadChangeType::PRIORITY_CHANGE) {
            $change->old_value = $this->getPriorityById($object->priority[1]);
            $change->new_value = $this->getPriorityById($this->priority[1]);
            $mail_vars['data']['{content_main}'] = $content . '<p>Speed Changed to: '.$change->old_value.' => '.$change->new_value.'</p>';
            $response = $change->add();
            // Notify changes through SMS( High Priority / Important cases)
            if($response) {
                if($priority == 3 || $priority == 4) {
                    $msgtxt = 'Hello '.$mail_vars['assignee_name'].' , Your flight #'.$this->id.': '.$this->name[$this->context->language->id].' speed changed to '.$change->old_value.' => '.$change->new_value.' by ' . $mail_vars['owner_name'];
                    SMSAlert::sendSMSAlert($mail_vars['assignee']->mobile, $msgtxt);
                }
            }
        }
        else if($id_change_type == ThreadChangeType::MODE_CHANGE) {
            $change->old_value = $this->getModeById($object->mode);
            $change->new_value = $this->getModeById($this->mode);
            $mail_vars['data']['{content_main}'] = $content . '<p>Mode changed to: '.$change->old_value.' => '.$change->new_value.'</p>';
            $response = $change->add();

            // Notify changes through SMS( High Priority / Important cases)
            if($response) {
                $msgtxt = 'Hello '.$mail_vars['assignee_name'].' , Your flight #'.$this->id.': '.$this->name[$this->context->language->id].' mode has been set to '.$change->old_value.' => '.$change->new_value.' by ' . $mail_vars['owner_name'];
                SMSAlert::sendSMSAlert($mail_vars['assignee']->mobile, $msgtxt);
            }
        }
        else {
            return false;
        }

        
        if($response) {
            // Notify changes through Mail
            Mail::Send($this->context->language->id, 
                $mail_vars['template'], 
                $mail_vars['subject'], 
                $mail_vars['data'], 
                $mail_vars['assignee']->email, 
                $mail_vars['assignee_name']
            );

            // Notify changes to followers
            if(!empty($mail_vars['followers'])) {
                foreach ($mail_vars['followers'] as $key => $follower) {
                    if($mail_vars['assignee']->email != $follower['email']) {
                        Mail::Send(
                            $this->context->language->id, 
                            $mail_vars['template'], 
                            $mail_vars['subject'], 
                            $mail_vars['data'], 
                            $follower['email'], 
                            $follower['follower_name']
                        );
                    }
                }
            }
        }

        return $response;
    }

    /** 
     * Add thread post
     * Trigger mail and notify about post
     */
    public function addPost($id_activity, $object) 
    {
        $post = new ThreadPost();
        $post->id_activity = $id_activity;
        $post->post_value = $object['detail'];
        if($post->add()) {
            if(isset($object['attachments'])) { // Add attachments if exists
                $post->addAttachment($object['attachments'], 1);
            }

            if(isset($object['driveAttachments'])) {
               $post->addAttachment($object['driveAttachments'], 2); 
            }
            
            $mail_vars = $this->getMailVars();

            $mail_vars['data']['{content_main}'] = '<p>Post added by ' . $mail_vars['from_name'] . '</p><br />
            <p>Post: </p><br /><p>'.$post->post_value.'</p><br />';

            // Notify to pilot
            if($this->context->employee->id != $mail_vars['assignee']->email) {
                Mail::Send($this->context->language->id, 
                    $mail_vars['template'],
                    $mail_vars['subject'],
                    $mail_vars['data'], 
                    $mail_vars['assignee']->email,
                    $mail_vars['assignee_name']
                );
            }

            // Notify to owner
            if($this->context->employee->id != $mail_vars['owner']->email) {
                Mail::Send($this->context->language->id, 
                    $mail_vars['template'],
                    $mail_vars['subject'],
                    $mail_vars['data'],
                    $mail_vars['owner']->email,
                    $mail_vars['owner_name']
                );
            }

            return true;
        }
    }

    /** 
     * Add timeline request
     * Trigger mail and notify about timeline request
     */
    public function addRequest($id_activity, $id_request_type, $object) 
    {
        $request = new ThreadRequest();
        $request->id_activity = $id_activity;
        $request->id_request_type = $id_request_type;
        $request->value = $object['value'];
        $request->id_employee = $this->context->employee->id;
        $request->comment = $object['comment'];
        
        if($request->add()) {
            $mail_vars = $this->getMailVars();
            $mail_vars['data']['{content_main}'] = '<p>Landing time change requested by '. $mail_vars['from_name'] . '</p><br />
                <p>Landing time: '.$this->timeline[$this->context->language->id].' => '.$request->value.'</p>';

            // Notify changes through Mail
            Mail::Send($this->context->language->id, 
                $mail_vars['template'],
                $mail_vars['subject'], 
                $mail_vars['data'], 
                $mail_vars['owner']->email, 
                $mail_vars['owner_name']
            );

            $msgtxt = 'Hello '.$mail_vars['owner_name'].' , Landing time requested to '.$this->timeline[$this->context->language->id].' => '.$request->value.' for your flight #'.$this->id.': '.$this->name[$this->context->language->id].'. Requested by ' . $mail_vars['assignee_name'];
            SMSAlert::sendSMSAlert($owner->mobile, $msgtxt);

            // Assign ticket back to owner
            /*$activity = new ThreadActivity(intval($id_activity));
            $thread = new Thread(intval($activity->id_thread));
            $thread->id_assignee[1] = $thread->id_employee;
            return $thread->update();*/
            return true;
        }
    }

    /**
     * Get Mail Vars
     */
    public function getMailVars() {
        $data = array();
        $subject = '[Kortex][Threads] #' . $this->id . ': ' . $this->name[$this->context->language->id];
        $from_name = $this->context->employee->firstname.' '.$this->context->employee->lastname;
        $status = new ThreadState(intval($this->id_state[$this->context->language->id]));
        $owner = new Employee(intval($this->id_employee));
        $owner_name = $owner->firstname . ' ' . $owner->lastname; 
        $assignee = new Employee($this->id_assignee[$this->context->language->id]);
        $assignee_name = $assignee->firstname.' '.$assignee->lastname;
        $priority = $this->priority[$this->context->language->id];
        $followers = $this->getFollowers();

        $data = [
            '{thread_name}' => '#'.$this->id.': '.$this->name[$this->context->language->id],
            '{thread_status}' => $status->name,
            '{thread_scheduled}' => $this->date_add,
            '{thread_owner}' => $owner->firstname . ' ' . $owner->lastname,
            '{thread_priority}' => $this->getPriorityById($priority),
            '{thread_assignee}' => $assignee->firstname . ' ' . $assignee->lastname,
            '{thread_timeline}' => $this->timeline[$this->context->language->id],
            '{date}' => date('Y-m-d H:i:s'),
            '{to_name}' => $assignee_name
        ];

        return array('template' => 'thread_notification',
            'subject' => $subject,
            'from_name' => $from_name,
            'status' => $status,
            'owner' => $owner,
            'assignee' => $assignee,
            'owner_name' => $owner_name,
            'assignee_name' => $assignee_name,
            'priority' => $priority,
            'followers' => $followers,
            'data' => $data
        );
    }

    /**
     * Get priority text
     */
    public function getPriorityById($priority) {
        return ($priority == 1 ? 'Single Engine' : ( $priority == 2 ? 'Multi Engine' : ( $priority == 3 ? 'Airline Jet' : 'Special Military' )));
    }

    /**
     * Get mode text
     */
    public function getModeById($mode) {
        return ($mode == 1 ? 'Charter' : 'Public');
    }

    /*** Filter threads ***/
    public static function getFilteredThreads($id_employee = 0, $active = true, $orderBy = null, $orderWay = null, $filters = null) 
    {
        $dataLimit = ($filters['limit'] && ($filters['offset'] == 0 || $filters['offset'])) ? ' LIMIT '.$filters['offset'].', '.$filters['limit'].'' : "";

        $status = '';
        if($filters['analyticStatus']) {
            $status = 'AND res.`id_state` = '.intval($filters['analyticStatus']).'';
            if($filters['analyticStatus'] == ThreadState::DELAYED) {
                $status = 'AND res.`id_state` NOT IN('.ThreadState::LANDED.') AND res.`timeline` < "'.date('Y-m-d H:i:s').'"';
            }
        }
        else if($filters['status']){
            $status = 'AND res.`id_state` IN('.$filters['status'].')';
        }

        $sql = 'SELECT * FROM  ( SELECT 
                        th.*, thl.`name` AS title, thl.`id_assignee`, thl.`id_lang`, thl.`id_state`,
                        CONCAT(emp.`firstname`, " ", emp.`lastname`) AS assignee,
                        ths.`name` AS thread_state, thl.`timeline`, thl.`priority`,
                        IF(th.`id_parent` != 0, 1, 0) AS subthread,
                        IF(th.`mode` = 0, "Charter", "Public") AS flight_mode,
                        IF(thl.`priority` = 1, "Single Engine", IF(thl.`priority` = 2, "Multi Engine", IF(thl.`priority` = 3, "Airline Jet", IF(thl.`priority` = 4, "Special Military", "")))) AS priority_text,
                        thf.`id_follower`
                    FROM `'._DB_PREFIX_.'thread` th
                    LEFT JOIN `'._DB_PREFIX_.'thread_lang` thl ON th.`id_thread` = thl.`id_thread`
                    LEFT JOIN `'._DB_PREFIX_.'employee` emp ON thl.`id_assignee` = emp.`id_employee`
                    LEFT JOIN `'._DB_PREFIX_.'thread_followers` thf ON th.`id_thread` = thf.`id_thread`
                    LEFT JOIN `'._DB_PREFIX_.'thread_state` ths ON thl.`id_state` = ths.`id_state`
                ) res
                WHERE res.`id_lang` = 1
                AND res.`active` = '.boolval($active).'
                '.($filters['mode'] != "" ? 'AND res.mode IN('.$filters['mode'].')' : '').'
                '.$status.'
                '.($filters['priority'] ? 'AND res.`priority` IN('.$filters['priority'].')' : '').'
                '.($filters['assignedSelf'] ? 'AND res.`id_assignee` = '.$id_employee.'' : 'AND (
                    res.`id_employee` = '.$id_employee.' OR 
                    res.`id_follower` = '.$id_employee.' OR 
                    res.`id_assignee` = '.$id_employee.' OR
                    res.`mode` = 0
                )').'
                '.($filters['q'] ? 'AND (res.`id_thread` LIKE "%'.$filters['q'].'%" OR
                    res.title LIKE "%'.$filters['q'].'%" OR
                    res.assignee LIKE "%'.$filters['q'].'%" OR
                    res.thread_state LIKE "%'.$filters['q'].'%" OR
                    res.`timeline` LIKE "%'.$filters['q'].'%" OR
                    res.flight_mode LIKE "%'.$filters['q'].'%" OR
                    res.priority_text LIKE "%'.$filters['q'].'%")' : '').'
                GROUP BY res.`id_thread`
                '.($orderBy ? 'ORDER BY '.$orderBy : '').'
                '.($orderWay ? $orderWay : '').'';
        $result = Db::getInstance()->executeS($sql.$dataLimit);
        $total = count(Db::getInstance()->executeS($sql));

        return array('result' => $result, 'total' => $total);
    }

    /** Get thread analytics **/
    public static function getFlightCountByStatus($id_state, $id_employee) {
        $sql = 'SELECT COUNT(*) AS total FROM (
            SELECT th.`id_thread` FROM `'._DB_PREFIX_.'thread` th 
            LEFT JOIN `'._DB_PREFIX_.'thread_lang` thl ON th.`id_thread` = thl.`id_thread`
            LEFT JOIN `'._DB_PREFIX_.'thread_followers` thf ON th.`id_thread` = thf.`id_thread`
            WHERE thl.`id_state` = '.intval($id_state).' AND 
            (
                th.`id_employee` = '.intval($id_employee).' OR 
                thf.`id_follower` = '.intval($id_employee).' OR 
                thl.`id_assignee` = '.intval($id_employee).'
            )
            AND th.`active` = 1 GROUP BY th.`id_thread`) t';
        return Db::getInstance()->getValue($sql);
    }

    public static function getFlightsCountByDelay($id_employee) {
        $sql = 'SELECT COUNT(*) AS total FROM (
            SELECT th.`id_thread` FROM `'._DB_PREFIX_.'thread` th 
            LEFT JOIN `'._DB_PREFIX_.'thread_lang` thl ON th.`id_thread` = thl.`id_thread`
            LEFT JOIN `'._DB_PREFIX_.'thread_followers` thf ON th.`id_thread` = thf.`id_thread`
            WHERE (
                th.`id_employee` = '.intval($id_employee).' OR 
                thf.`id_follower` = '.intval($id_employee).' OR 
                thl.`id_assignee` = '.intval($id_employee).'
            )
            AND thl.`id_state` NOT IN('.ThreadState::LANDED.')
            AND thl.`timeline` < "'.date('Y-m-d H:i:s').'"
            AND th.`active` = 1 GROUP BY th.`id_thread`
        ) t';
        return Db::getInstance()->getValue($sql);
    }
}