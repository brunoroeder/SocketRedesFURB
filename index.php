 <?php

 require 'User.class.php';
 require 'Message.class.php';



 $login = new User();
 $message = new Message();


//bruno

 $login->login('9361', 'gtuxv');

//heizle
// '9951'
//'drrsa'


 var_dump($login->getUserList());
 // var_dump($message->sendMessage('Teste!', 9951));
 var_dump($message->getMessagesList());
