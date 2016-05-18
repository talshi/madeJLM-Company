<?php

class Student extends User {
    public function __construct()
    {
        
        parent::__construct();
        $this->config->userTableName = 'student';
        // Start object construction
        $this->start();
    }
    public function userData()
    {
        // header('Content-Type: text/html; charset=utf-8');
        if ((bool) $this->session->signed) {
            $db_action = new DB_Action();
            // get student skills
            $sql = 'SELECT student_skills.id,student_skills.skill_id,student_skills.years,skills.name
					FROM student_skills INNER JOIN skills ON student_skills.skill_id=skills.id
					WHERE student_id=' . $this->_data['ID'] . ' ORDER BY id ASC';
            $this->_data['skils'] = $db_action->getQuery($sql);
            // print_r($this->_data);
            return $this->_data;
        }
        return false;
    }
    public function uploadProfile($profile)
    {
        $this->log->channel('update profile picture');

        if (empty($profile))
            $this->log->error(2);

        if (strpos($profile, 'data:image/jpeg;base64,') === false)
            $this->log->error('Profile picture must be jpeg');

        //Check for errors
        if ($this->log->hasError()) {
            return false;
        }

        define('UPLOAD_DIR', 'uploads/profiles/');
        $base64img = str_replace('data:image/jpeg;base64,', '', $profile);
        $profile = base64_decode($base64img);
        $profile_location = UPLOAD_DIR . $this->ID . '.jpg';
        file_put_contents($profile_location, $profile);

        $this->log->report('upload profile complete');

        //Prepare Info for SQL Insertion
        $data = array();
        $data['id'] = $this->ID;
        $data['profile'] = UPLOAD_DIR . $this->ID . '.jpg?' .time();

        //Prepare User Update Query
        $sql = "UPDATE _table_ SET profile=:profile WHERE ID=:id";

        //Check for Changes
        if ($this->table->runQuery($sql, $data)) {
            $this->log->report('Information Updated');

            if ($this->clone === 0) {
                $this->session->update = true;
            }

            // Update the current object with the updated information
            $this->_data = array_merge($this->_data, $data);

            // Clear the updates stack
            $this->_updates = new Collection();

            return true;
        } else {
            $this->log->error(2);
            return false;
        }
    }
    //status,$reason = null, $description = null
    public function changeStatus($info) {
        // checking if get all info we need
        if (!isset($info['status']) ||
            ($info['status'] == 0 &&
                (!isset($info['reason']) ||
                    ($info['reason'] == 9 &&
                        (!isset($info['description']) ||
                            trim($info['description']) == ''))))) {
            $this->log->error(2);
            return false;
        }
        // checking if status is change
        if ($this->status == $info['status']) {
            $this->log->error(2);
            return false;
        }
        $data = array('id' => $this->ID, 'status' => $info['status']);

        $sql = "UPDATE _table_ SET status=:status  WHERE ID=:id";

        if ($this->table->runQuery($sql, $data)) {

            $this->log->report('Information Updated(ChangeStatus)');
            // יפה זה חשוב - זה בעצם דואג לעדכן את הסשיין! כל הכבוד שעליתם על זה לבד
            if ($this->clone === 0) {
                $this->session->update = true;
            }

            // Update the current object with the updated information
            $this->_data = array_merge($this->_data, $data);

            // Clear the updates stack
            $this->_updates = new Collection();

            if ($info['status'] == 0) {
                $data = array(
                    'student_id' => $this->_data['ID'],
                    'reason' => $info['reason']
                );
                if (isset($info['description'])) {
                    $data['description'] = $info['description'];
                }
                $into = array();
                foreach ($data as $index => $val) {
                    $into[] = $index;
                }

                $intoStr = implode(', ', $into);
                $values = ':' . implode(', :', $into);

                $sql = "INSERT INTO student_turn_off ({$intoStr}) VALUES({$values})";

                $db_action = new DB_Action();

                if ($db_action->runQuery($sql, $data)) {
                    $this->log->report('Information Updated(ChangeStatus)');
                } else {
                    $this->log->error(2);
                    return false;
                }
            }
        } else {
            $this->log->error(2);
            return false;
        }
        return true;
    }
}
?>