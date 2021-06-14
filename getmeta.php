<?php
/**
 * JSON beautifier
 * 
 * @param string    The original JSON string
 * @param   string  Return string
 * @param string    Tab string
 * @return string
 */
function pretty_json($json, $ret= "\n", $ind="\t") {

    $beauty_json = '';
    $quote_state = FALSE;
    $level = 0; 

    $json_length = strlen($json);

    for ($i = 0; $i < $json_length; $i++)
    {                               

        $pre = '';
        $suf = '';

        switch ($json[$i])
        {
            case '"':                               
                $quote_state = !$quote_state;                                                           
                break;

            case '[':                                                           
                $level++;               
                break;

            case ']':
                $level--;                   
                $pre = $ret;
                $pre .= str_repeat($ind, $level);       
                break;

            case '{':

                if ($i - 1 >= 0 && $json[$i - 1] != ',')
                {
                    $pre = $ret;
                    $pre .= str_repeat($ind, $level);                       
                }   

                $level++;   
                $suf = $ret;                                                                                                                        
                $suf .= str_repeat($ind, $level);                                                                                                   
                break;

            case ':':
                $suf = ' ';
                break;

            case ',':

                if (!$quote_state)
                {  
                    $suf = $ret;                                                                                                
                    $suf .= str_repeat($ind, $level);
                }
                break;

            case '}':
                $level--;   

            case ']':
                $pre = $ret;
                $pre .= str_repeat($ind, $level);
                break;

        }

        $beauty_json .= $pre.$json[$i].$suf;

    }

    return $beauty_json;

}   
header('Content-Type: application/json');
echo pretty_json(json_encode(get_meta_tags($_GET['url'])));
?>
