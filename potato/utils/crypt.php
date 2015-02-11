<?php
namespace potato\utils;
use potato\lib\configer as Config;

class crypt {
    static $lockstream = 'stlDEFABCNOPyzghijQRSTUwxkVWXYZabcdefIJK67nopqr89LMmGH012345uv';

    static function decrypt($string){
        $lockLen = strlen(self::$lockstream);
        //获得字符串长度
        $txtLen = strlen($string);
        //截取随机密锁值
        $randomLock = $string[$txtLen - 1];
        //获得随机密码值的位置
        $lockCount = strpos(self::$lockstream,$randomLock);
        //结合随机密锁值生成MD5后的密码
        $password = md5(Config::$setting['crypt']['salt'].$randomLock);
        //开始对字符串解密
        $txtStream = substr($string,0,$txtLen-1);
        $tmpStream = '';
        $i=0;$j=0;$k = 0;
        for($i=0; $i<strlen($txtStream); $i++){
            $k = ($k == strlen($password)) ? 0 : $k;
            $j = strpos(self::$lockstream,$txtStream[$i]) - $lockCount - ord($password[$k]);
            while($j < 0){
                $j = $j + ($lockLen);
            }
            $tmpStream .= self::$lockstream[$j];
            $k++;
        }
        return base64_decode($tmpStream);
    }

    static function encrypt($string){
        //随机找一个数字，并从密锁串中找到一个密锁值
        $lockLen = strlen(self::$lockstream);
        $lockCount = rand(0,$lockLen-1);
        $randomLock = self::$lockstream[$lockCount];
        //结合随机密锁值生成MD5后的密码
        $password = md5(Config::$setting['crypt']['salt'].$randomLock);
        //开始对字符串加密
        $txtStream = base64_encode($string);
        $tmpStream = '';
        $i=0;$j=0;$k = 0;
        for ($i=0; $i<strlen($txtStream); $i++) {
            $k = ($k == strlen($password)) ? 0 : $k;
            $j = (strpos(self::$lockstream,$txtStream[$i])+$lockCount+ord($password[$k]))%($lockLen);
            $tmpStream .= self::$lockstream[$j];
            $k++;
        }
        return $tmpStream.$randomLock;
    }
}