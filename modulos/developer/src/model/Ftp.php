<?php
namespace Developer\model;

class Ftp
{

    private $conn_id = 0;
    function __construct() {

    }

    public function setConn_id($conn_id)
    {
        $this->conn_id = $conn_id;
    }

    public function getConn_id()
    {
        return  $this->conn_id;
    }

    public function connect($host,$user,$pass)
    {
        $conn_id = ftp_connect($host);

        $this->conn_id = $conn_id;

        $result = ftp_login( $conn_id, $user,  $pass);

        ftp_pasv($conn_id, true);

        return $result;
    }

    public function ls($path = ".")
    {

        return ftp_rawlist($this->conn_id,"-A ".$path);
    }



    public function close()
    {
        ftp_close($this->conn_id);
    }

    public function chdir($path)
    {
        return ftp_chdir($this->conn_id,$path);
    }


    public function rename($name,$new_name)
    {
       return ftp_rename($this->conn_id,$name,$new_name);
    }

    public function mkdir($new_name)
    {
        return ftp_mkdir($this->conn_id,$new_name);
    }

    public function get( $local_file, $server_file)
    {
        return ftp_get($this->conn_id,$local_file, $server_file,FTP_BINARY);
    }

    public function put( $server_file,$local_file)
    {
        return ftp_put($this->conn_id, $server_file,$local_file,FTP_BINARY);
    }

    public function rmdir($name)
    {
        return ftp_rmdir($this->conn_id,$name);
    }

    public function delete($path)
    {
        return ftp_delete($this->conn_id,$path);
    }

    public function root()
    {
       return ftp_cdup($this->conn_id);
    }

    public function chmod($permiso,$file)
    {
       return ftp_chmod($this->conn_id,$permiso,$file);
    }

    public function size($file)
    {
       return ftp_size($this->conn_id,$file);
    }

    public function fput($file,$temp)
    {
       return ftp_fput($this->conn_id,$file,$temp,FTP_BINARY);
    }

    public function pwd()
    {
        return ftp_pwd($this->conn_id);
    }

    public function isConnect()
    {
        return is_array(ftp_nlist($this->conn_id, "."));
    }

}
