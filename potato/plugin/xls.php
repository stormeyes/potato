<?php
namespace potato\plugin;
use potato\lib\baseModel as baseModel;

class xls extends baseModel{
    function generateBySQL($sql,$file_name = 'export'){
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$file_name.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $result=mysqli_query($this->connection,$sql);
        echo mysqli_error($this->connection);
        $sep = "\t"; //tabbed character
        //start of printing column names as names of MySQL fields
        for ($i = 0; $i < mysqli_num_fields($result); $i++) {
            while ($property = mysqli_fetch_field($result)) {
                echo $property->name. "\t";
            }
        }
        print("\n");
        //end of printing column names
        //start while loop to get data
        while($row = mysqli_fetch_row($result))
        {
            $schema_insert = "";
            for($j=0; $j<mysqli_num_fields($result);$j++)
            {
                if(!isset($row[$j]))
                    $schema_insert .= " ".$sep;
                elseif ($row[$j] != "")
                    //在长数字前加上'可以让excel关闭对长数字的科学计数法表示
                    $schema_insert .= "'$row[$j]".$sep;
                else
                    $schema_insert .= "".$sep;
            }
            $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
            $schema_insert .= "\t";
            print(trim($schema_insert));
            print "\n";
        }
    }
} 