<?php
    class telegram_bot_api
    {
        private $token = '';


        public function __construct($token)
        {
            $this->token = $token;

        }

        public function get_updates()
        {
            $data = json_decode(file_get_contents("https://api.telegram.org/bot" . $this->token . "/getUpdates"), true);
            return $data;
        }
        public function sendMessage($chat_id, $text)
        {
            $data = json_decode(file_get_contents("https://api.telegram.org/bot". $this->token. "/sendMessage?chat_id=$chat_id&text=$text"), true);

            if ($data['ok'] == true) {
                return 'success';
            }
            else {
                return 'fail';
            }
        }
    }
?>

