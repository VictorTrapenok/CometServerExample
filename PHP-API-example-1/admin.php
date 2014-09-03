<?php

// Подключаем библиотеку с API комет сервера
include './CometServerApi.php';

$comet = CometServerApi::getInstance();

/**
 * Выполняем авторизацию
 * Первый параметр это ваш публичный идентификатор разработчика
 * Первый параметр это ваш секретный ключ разработчика
 */
$comet->authorization(15, "lPXBFPqNg3f661JcegBY0N0dPXqUBdHXqj2cHf04PZgLHxT6z55e20ozojvMRvB8");

// Если была передана переменная timer в GET параметр то надо отправить событие с именем timer в канал adminControl
if( isset($_GET['timer']))
{
    $r = $comet->send_to_pipe("adminControl", "timer", Array( "display" => $_GET['timer']));
    echo $r->getData();
    exit;
}

// Если была передана переменная baner в GET параметр то надо отправить событие с именем baner в канал adminControl
if( isset($_GET['baner']))
{
    $r = $comet->send_to_pipe("adminControl", "baner", Array( "display" => $_GET['baner']));
    echo $r->getData();
    exit;
}
 
// Если была передана переменная baner в POST параметр то надо отправить событие с именем text в канал adminControl
if( isset($_POST['text']))
{
    $r = $comet->send_to_pipe("ChatExample1", "text", Array( "text" => $_POST['text']));
    var_dump($r);
    exit;
}
    
// Если в GET и POST параметрах небыло ни переменной baner ни timer ни text ни redirect_url то надо отобразить станицу админки.
?>
<!DOCTYPE HTML>
<html>
<head>
    <!-- Подключаем библиотеки -->
    <script src="//comet-server.ru/CometServerApi.js" type="text/javascript"></script>
    <script src="jquery.min.js" type="text/javascript"></script>
</head>
<body>
    
<h1>Страница 2 (Панель управления)</h1>
    <input type="button" value="Показать таймер" onclick="SendCommand('timer', 'block');" >
    <input type="button" value="Спрятать таймер" onclick="SendCommand('timer', 'none');"  >
    <br>
    
    <input type="button" value="Показать банер" onclick="SendCommand('baner', 'block');"  >
    <input type="button" value="Спрятать банер" onclick="SendCommand('baner', 'none');"  >
    
    <br> 
    <input type="text" id="text" placeholder="text"> 
    
    <input type="button" value="Отправить текст" onclick="SendText($('#text').val());"  ><br> 
    
    <script type="text/javascript">
          
          
/**
 * Отправляет команду в админку через AJAX запрос
 * @param {string} name Имя команды
 * @param {string} value Значение команды
 */
function SendCommand(name, value)
{
     
    $.ajax({
             url: "/1/admin.php?"+name+"="+value,
             type: "GET",
             success: function(data)
             {
                 console.log("Отправлено:" +data)
             }
    });
}
     
function SendText(text)
{
     
    $.ajax({
             url: "/1/admin.php",
             type: "POST",
             data:{
                    "text":text
             },
             success: function(data)
             {
                 console.log("Отправлено:" +data)
             }
    });
}     

    </script>
</body>
</html>
