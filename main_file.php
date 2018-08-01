<?php
    include 'var/constants.php';
    include 'php/main_class.php';
    include 'php/job_with_database.php';

    $telegram_bot = new telegram_bot_api(TOKEN);
    $bd = new job_with_database(NAME_BD, HOST_BD, LOGIN_BD, PASSWORD_BD);
    $token_bd = $bd->create_token_bd();
    $i = 0;
    while (true) {
        $update = $telegram_bot->get_updates();
        $last_update_id = $bd->get_last_update_id($token_bd);
        foreach ($update as $i => $value) {
            $update_id = $update['result'][$i]['update_id'];
            if ($update_id > $last_update_id) {
                $chat_id = $update['result'][$i]['message']['chat']['id'];
                $messege = 'Good';
                $arr = [
                    "chat_id" => $update['result'][$i]['message']['chat']['id'],
                    "username" => $update['result'][$i]['message']['from']['username'],
                    "first_name" => $update['result'][$i]['message']['from']['first_name'],
                    "last_name" => $update['result'][$i]['message']['from']['last_name'],
                    "update_id" => $update['result'][$i]['update_id'],
                    "date" => $update['result'][$i]['message']['date']
                ];
                $bd->write_message_to_bd($token_bd, $arr);
                $telegram_bot->sendMessage($chat_id, $messege);
            }
        }
        sleep(2);

    }

?>