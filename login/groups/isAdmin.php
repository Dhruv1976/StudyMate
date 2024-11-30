<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");


if ($_GET) {
    session_start();
    $name = $_GET['username'];
    if (!empty($_GET['ingroup']) && !empty($name)) {
        include ('dbconnect.php');
        $adminQ = fetchQuery('select admin_id,admin_name from groups where groupname = "' . $_GET['ingroup'] . '"', "study_mate");

        if ($adminQ) {
            $md =array(
                
                'result' => ($adminQ[0]['admin_name'] == $name) ? "true": "false"
            ); 
            // echo $st.$md.$ed;
            echo json_encode($md);
        }
        else {}
    } else {
        $md =array(
            'result' => " no full data found."
        ); 
        // echo $st.$md.$ed;
        echo json_encode($md);
    
    }

}

?>