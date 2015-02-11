<?php

namespace potato\utils;

use potato\lib\configer as Configer;

class mail {
    /* Public Variables */
    public static $smtp_port;
    public static $time_out;
    public static $host_name;
    public static $log_file;
    public static $relay_host;
    public static $debug;
    public static $auth;
    public static $user;
    public static $pass;

    /* Private Variables */
    public  static $sock;

    /* Constractor */
    static function construct($relay_host = "", $smtp_port = 25,$auth = false,$user,$pass)
    {
        self::$debug = FALSE;
        self::$smtp_port = $smtp_port;
        self::$relay_host = $relay_host;
        self::$time_out = 30; //is used in fsockopen()
#
        self::$auth = $auth;//auth
        self::$user = $user;
        self::$pass = $pass;
#
        self::$host_name = "localhost"; //is used in HELO command
        self::$log_file ="";

        self::$sock = FALSE;
    }

    /* Main Function */
    static function sendmail($to, $subject = "", $body = "", $mailtype,$additional_headers = "utf-8", $cc = "", $bcc = "")
    {
        self::construct(
            Configer::$setting['mail']['smtp']['server'],
            Configer::$setting['mail']['smtp']['server_port'],
            true,
            Configer::$setting['mail']['smtp']['username'],
            Configer::$setting['mail']['smtp']['password']
        );
        self::$debug = true;
        $mail_from = self::get_address(self::strip_comment(Configer::$setting['mail']['smtp']['from_mail']));
        $subject ="=?".$additional_headers."?B?".base64_encode($subject)."?=";
        $body = preg_replace("/(^|(\r\n))(\\.)/", "\\1.\\3", $body);
        $header = "MIME-Version:1.0\r\n";
        if($mailtype=="HTML"){
            $header .= "Content-Type:text/html;Charset=\"".$additional_headers."\"\r\n";
        }
        $header .= "To: ".$to."\r\n";
        if ($cc != "") {
            $header .= "Cc: ".$cc."\r\n";
        }
        $header .= "From: ".Configer::$setting['mail']['smtp']['from_mail']."<".Configer::$setting['mail']['smtp']['from_mail'].">\r\n";
        $header .= "Subject: ".$subject."\r\n";
        $header .= $additional_headers;
        $header .= "Date: ".date("r")."\r\n";
        $header .= "X-Mailer:By Redhat (PHP/".phpversion().")\r\n";

        list($msec, $sec) = explode(" ", microtime());
        $header .= "Message-ID: <".date("YmdHis", $sec).".".($msec*1000000).".".$mail_from.">\r\n";
        $TO = explode(",", self::strip_comment($to));

        if ($cc != "") {
            $TO = array_merge($TO, explode(",", self::strip_comment($cc)));
        }

        if ($bcc != "") {
            $TO = array_merge($TO, explode(",", self::strip_comment($bcc)));
        }

        $sent = TRUE;
        foreach ($TO as $rcpt_to) {
            $rcpt_to = self::get_address($rcpt_to);
            if (!self::smtp_sockopen($rcpt_to)) {
                self::log_write("Error: Cannot send email to ".$rcpt_to."\n");
                $sent = FALSE;
                continue;
            }
            if (self::smtp_send(self::$host_name, $mail_from, $rcpt_to, $header, $body)) {
                self::log_write("E-mail has been sent to <".$rcpt_to.">\n");
            } else {
                self::log_write("Error: Cannot send email to <".$rcpt_to.">\n");
                $sent = FALSE;
            }
            fclose(self::$sock);
            self::log_write("Disconnected from remote host\n");
        }
        return $sent;
    }

    /* Private Functions */

    static function smtp_send($helo, $from, $to, $header, $body = "")
    {
        if (!self::smtp_putcmd("HELO", $helo)) {
            return self::smtp_error("sending HELO command on smtp_putcmd");
        }
#auth
        if(self::$auth){
            if (!self::smtp_putcmd("AUTH LOGIN", base64_encode(self::$user))) {
                return self::smtp_error("sending HELO command on auth login");
            }

            if (!self::smtp_putcmd("", base64_encode(self::$pass))) {
                return self::smtp_error("sending HELO command on second smtp_putcmd");
            }
        }
#
        if (!self::smtp_putcmd("MAIL", "FROM:<".$from.">")) {
            return self::smtp_error("sending MAIL FROM command");
        }

        if (!self::smtp_putcmd("RCPT", "TO:<".$to.">")) {
            return self::smtp_error("sending RCPT TO command");
        }

        if (!self::smtp_putcmd("DATA")) {
            return self::smtp_error("sending DATA command");
        }

        if (!self::smtp_message($header, $body)) {
            return self::smtp_error("sending message");
        }

        if (!self::smtp_eom()) {
            return self::smtp_error("sending <CR><LF>.<CR><LF> [EOM]");
        }

        if (!self::smtp_putcmd("QUIT")) {
            return self::smtp_error("sending QUIT command");
        }

        return TRUE;
    }

    static function smtp_sockopen($address)
    {
        if (self::$relay_host == "") {
            return self::smtp_sockopen_mx($address);
        } else {
            return self::smtp_sockopen_relay();
        }
    }

    static function smtp_sockopen_relay()
    {
        self::log_write("Trying to ".self::$relay_host.":".self::$smtp_port."\n");
        self::$sock = @fsockopen(self::$relay_host, self::$smtp_port, $errno, $errstr, self::$time_out);
        if (!(self::$sock && self::smtp_ok())) {
            self::log_write("Error: Cannot connenct to relay host ".self::$relay_host."\n");
            self::log_write("Error: ".$errstr." (".$errno.")\n");
            return FALSE;
        }
        self::log_write("Connected to relay host ".self::$relay_host."\n");
        return TRUE;
    }

    static function smtp_sockopen_mx($address)
    {
        $domain = preg_replace("/^.+@([^@]+)$/", "\\1", $address);
        if (!@getmxrr($domain, $MXHOSTS)) {
            self::log_write("Error: Cannot resolve MX \"".$domain."\"\n");
            return FALSE;
        }
        foreach ($MXHOSTS as $host) {
            self::log_write("Trying to ".$host.":".self::$smtp_port."\n");
            self::$sock = @fsockopen($host, self::$smtp_port, $errno, $errstr, self::$time_out);
            if (!(self::$sock && self::smtp_ok())) {
                self::log_write("Warning: Cannot connect to mx host ".$host."\n");
                self::log_write("Error: ".$errstr." (".$errno.")\n");
                continue;
            }
            self::log_write("Connected to mx host ".$host."\n");
            return TRUE;
        }
        self::log_write("Error: Cannot connect to any mx hosts (".implode(", ", $MXHOSTS).")\n");
        return FALSE;
    }

    static function smtp_message($header, $body)
    {
        fputs(self::$sock, $header."\r\n".$body);
        self::smtp_debug("> ".str_replace("\r\n", "\n"."> ", $header."\n> ".$body."\n> "));

        return TRUE;
    }

    static function smtp_eom()
    {
        fputs(self::$sock, "\r\n.\r\n");
        self::smtp_debug(". [EOM]\n");

        return self::smtp_ok();
    }

    static function smtp_ok()
    {
        $response = str_replace("\r\n", "", fgets(self::$sock, 512));
        self::smtp_debug($response."\n");

        if (!preg_match("/^[23]/", $response)) {
            fputs(self::$sock, "QUIT\r\n");
            fgets(self::$sock, 512);
            self::log_write("Error: Remote host returned \"".$response."\"\n");
            return FALSE;
        }
        return TRUE;
    }

    static function smtp_putcmd($cmd, $arg = "")
    {
        if ($arg != "") {
            if($cmd=="") $cmd = $arg;
            else $cmd = $cmd." ".$arg;
        }

        fputs(self::$sock, $cmd."\r\n");
        self::smtp_debug("> ".$cmd."\n");

        return self::smtp_ok();
    }

    static function smtp_error($string)
    {
        self::log_write("Error: Error occurred while ".$string.".\n");
        return FALSE;
    }

    static function log_write($message)
    {
        self::smtp_debug($message);

        if (self::$log_file == "") {
            return TRUE;
        }

        $message = date("M d H:i:s ").get_current_user()."[".getmypid()."]: ".$message;
        if (!@file_exists(self::$log_file) || !($fp = @fopen(self::$log_file, "a"))) {
            self::smtp_debug("Warning: Cannot open log file \"".self::$log_file."\"\n");
            return FALSE;
        }
        flock($fp, LOCK_EX);
        fputs($fp, $message);
        fclose($fp);

        return TRUE;
    }

    static function strip_comment($address)
    {
        $comment = "/\\([^()]*\\)/";
        while (preg_match($comment, $address)) {
            $address = preg_replace($comment, "", $address);
        }

        return $address;
    }

    static function get_address($address)
    {
        $address = preg_replace("/([ \t\r\n])+/", "", $address);
        $address = preg_replace("/^.*<(.+)>.*$/", "\\1", $address);

        return $address;
    }

    static function smtp_debug($message)
    {
        if (self::$debug) {
            echo $message."<br>";
        }
    }

    static function get_attach_type($image_tag) { //

        $filedata = array();
        //add by kongkongyzt on 15/2/10
        $image_data = '';
        $img_file_con=fopen($image_tag,"r");
        unset($image_data);
        while ($tem_buffer=AddSlashes(fread($img_file_con,filesize($image_tag)))){
            $image_data.=$tem_buffer;
        }
        fclose($img_file_con);

        $filedata['context'] = $image_data;
        $filedata['filename']= basename($image_tag);
        $extension=substr($image_tag,strrpos($image_tag,"."),strlen($image_tag)-strrpos($image_tag,"."));
        switch($extension){
            case ".gif":
                $filedata['type'] = "image/gif";
                break;
            case ".gz":
                $filedata['type'] = "application/x-gzip";
                break;
            case ".htm":
                $filedata['type'] = "text/html";
                break;
            case ".html":
                $filedata['type'] = "text/html";
                break;
            case ".jpg":
                $filedata['type'] = "image/jpeg";
                break;
            case ".tar":
                $filedata['type'] = "application/x-tar";
                break;
            case ".txt":
                $filedata['type'] = "text/plain";
                break;
            case ".zip":
                $filedata['type'] = "application/zip";
                break;
            default:
                $filedata['type'] = "application/octet-stream";
                break;
        }

        return $filedata;
    }

}