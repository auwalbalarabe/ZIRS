<?php

    require __DIR__.'/firebase_sdk/vendor/autoload.php';
        
    use Kreait\Firebase\Factory;
    $factory = (new Factory)
            ->withServiceAccount('/path/to/firebase_admin_credentials.json') //secret admin sdk credentials
            ->withDatabaseUri('https://PROJECT_ID-default-rtdb.firebaseio.com'); //rtdb url


    $database = $factory->createDatabase();

    $reference = $database->getReference('history/');
    $histories = $reference->getValue();

    if ( count($histories) > 50) {

        //number of messages to be deleted
        $delNum = count($histories) - 50;
        $old_histories = array_slice($histories, 0, $delNum);

        foreach ($old_histories as $old_history) {
            //echo $old_history['history'];
            $database->getReference('history/'. $old_history['id'])->remove();
        }
        echo 'Histories are removed: '. $delNum;

    } else {
        echo 'Histories are not up to 50';
    }


    //var_dump ( $value);

    function give_output($status, $histories) {
        $outputObj = (object)array();

        $outputObj->status = $status;
        $outputObj->history = $histories;
        
        exit(json_encode($outputObj));
    }


?>
