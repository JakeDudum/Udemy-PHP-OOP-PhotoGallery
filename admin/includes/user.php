<?php

class User extends Db_object
{
    protected static $db_table = "users";
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name', 'filename');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $filename;
    public $image_placeholder = "http://placehold.it/300x300&text=image";

    public function get_image()
    {
        return empty($this->filename) ? $this->image_placeholder : $this->upload_directory . DS . $this->filename;
    }

    public function upload_photo()
    {
        if (!empty($this->errors)) {
            return false;
        }

        if (empty($this->filename) || empty($this->tmp_path)) {
            $this->errors[] = "the file was not available";
            return false;
        }

        $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;

        if (file_exists($target_path)) {
            $this->errors[] = "The file {$this->filename} already exists";
            return false;
        }

        if (move_uploaded_file($this->tmp_path, $target_path)) {
            unset($this->tmp_path);
            return true;
        } else {
            $this->errors[] = "the file directory probably does not have permission";
            return false;
        }
    }

    public static function verify_user($username, $password)
    {
        global $database;

        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM " . self::$db_table . " WHERE ";
        $sql .= "username = '{$username}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";

        $the_result_array = self::find_this_query($sql);

        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public function ajax_save_user_image($filename, $user_id)
    {
        global $database;

        $filename = $database->escape_string($filename);
        $user_id = $database->escape_string($user_id);

        $this->filename = $filename;
        $this->user_id = $user_id;

        $sql = "UPDATE " . self::$db_table . " SET user_image = '{$this->filename}' ";
        $sql .= " WHERE id = {$this->id} ";
        $update_image = $database->query($sql);

        echo $this->get_image();
    }

    public function delete_photo()
    {
        if ($this->delete()) {
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    }
}
