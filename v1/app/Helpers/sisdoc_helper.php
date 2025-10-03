<?php
function pre($txt,$stop=true)
    {
        echo '<pre>';
        print_r($txt);
        echo '</pre>';
        if ($stop == true)
            {
                exit;
            }
    }