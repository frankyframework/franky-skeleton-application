<?php
function shellFontColor($txt,$color = "default")
{
    global $argv;

    if(!empty($argv))
    {
        $colors = array(
            "verde" => "32",
            "rojo" => "31",
            "amarillo" => "33",
            "azul" => "34",
            "default" => "0"
            );
        return "\033[".$colors[$color]."m".$txt."\033[".$colors["default"]."m";
    }
    else
    {
        $colors = array(
            "verde" => "green",
            "rojo" => "red",
            "amarillo" => "yellow",
            "azul" => "blue",
            "default" => ""
            );
            return "<p style='color:".$colors[$color]."'>".htmlentities($txt)."</p>";
    }
}


function shellTable($cols = array(),$rows = array())
{
    global $argv;
    global $MyRequest;
    $html = "";
    if(!empty($argv))
    {
        if(!empty($cols))
        {
            $html = "\t|";
            foreach($cols as $col)
            {
                $html .= shellFontColor($col,"azul")."\t|";
            }
            $html .= "\n";

        }
        if(!empty($rows))
        {

            foreach($rows as $row => $_row)
            {
                $html .= "\t|";

                $html .= implode("\t|",$_row);


                $html .= "\t|\n";
            }


        }

    }
    else
    {
        $html .= "<table>";
        if(!empty($cols))
        {

            foreach($cols as $col)
            {
                $html .= "<th>".shellFontColor($col,"azul")."</th>";
            }


        }
        if(!empty($rows))
        {

            foreach($rows as $row => $_row)
            {
                $html .= "<tr>";
                foreach ($_row as $__row)
                {
                    $html .= "<td>".shellFontColor($__row)."</td>";
                }
                $html .= "</tr>";
            }
        }
         $html .= "</table>";
    }

    return $html;
}

function headerShell()
{
    
echo "
______ _____            _   _ _  ____     __
|  ____|  __ \     /\   | \ | | |/ /\ \   / /
| |__  | |__) |   /  \  |  \| | ' /  \ \_/ / 
|  __| |  _  /   / /\ \ | . ` |  <    \   /  
| |    | | \ \  / ____ \| |\  | . \    | |   
|_|    |_|  \_\/_/    \_\_| \_|_|\_\   |_|   
\n\n";
}

function helpShell($rules)
{
    if(!empty($rules))
    {
        $html =  "Lista de parametros:\n\n";

        foreach($rules as $rule)
        {
            $html .= ($rule["required"] == true ? "[*]" : "[ ]").$rule["var"].": ".$rule["description"]." \n";
        }
    }
    return $html;
}



function SplitSQL($site, $file, $delimiter = ';')
{
    set_time_limit(0);

    $ibd  = new Franky\Database\IBD(new \Franky\Database\configure,'conexion_bd',new \Franky\Database\Debug);

    if (is_file($file) === true)
    {
        $file = fopen($file, 'r');

        if (is_resource($file) === true)
        {
            $query = array();

            while (feof($file) === false)
            {
                $query[] = fgets($file);

                if (preg_match('~' . preg_quote($delimiter, '~') . '\s*$~iS', end($query)) === 1)
                {
                    $query = trim(implode('', $query));

                    if ($ibd->Execute($query) != IBD_SUCCESS)
                    {
                        echo shellFontColor("[error] ".$query,'rojo'). "\n";
                    }

                    else
                    {
                       echo shellFontColor("[success] ".$query,'verde'). "\n";
                    }

                    while (ob_get_level() > 0)
                    {
                        ob_end_flush();
                    }

                    flush();
                }

                if (is_string($query) === true)
                {
                    $query = array();
                }
            }

            return fclose($file);
        }
    }

    return false;
}

