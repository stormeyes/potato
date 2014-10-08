<?php
/*
* result{
    error{
        'code':1,
        'reason':'is empty'    
    },
    error{
        'code':2,
        'reason':'is not match reg'
    }
  }
*
*/

    class form{
        var $GET=array();
        var $POST=array();
        var $attrs;
        var $result;
        var $filter=array(
            'date' => "/^[0-9]{4}[-/][0-9]{1,2}[-/][0-9]{1,2}\$/",
            'number' => "/^[-]?[0-9,]+\$/",
            'not_empty' => "/[a-z0-9A-Z]+/",
            'words' => "/^[A-Za-z]+[A-Za-z \\s]*\$/",
            'phone' => "/^[0-9]{10,11}\$/",
            'zipcode' => "/^[1-9][0-9]{3}[a-zA-Z]{2}\$/",
            'price' => "/^[0-9.,]*(([.,][-])|([.,][0-9]{2}))?\$/",
            'studentnumber'=>"/^[0-9]{13}$/"
        );
        
        function __construct($attrs){
            $this->attrs=$attrs;
        }
        
        function attrChecker($data){
            foreach($this->attrs as $attr=>$reg){
                if($data[$attr]){
                    if(!preg_match($this->filter[$reg],$data[$attr])){
                        //echo var_dump($filter[$reg]);
                        //echo $data[$attr];
                        return jsonify(array('status'=>'error','code'=>'2','error_attr'=>$attr));
                    }
                }else{
                    return jsonify(array('status'=>'error','code'=>'1','error_attr'=>$attr));
                }
            }
            return jsonify(array('status'=>'success'));
        }
    }
?>
