<!DOCTYPE HTML>
<html>
<head>
    
    <!-- Подключаем библиотеки -->
    <script src="//comet-server.ru/CometServerApi.js" type="text/javascript"></script>
    <script src="jquery.min.js" type="text/javascript"></script>
</head>
<body>
<h1>Страница 1 (Страница пользователя)</h1>
    <!-- Просто ссылка на андминку -->
    <a href='admin.php' target="_blank" >Перейти к админке admin.php</a><br>
    
    
    <!-- Блоки видимостью которых мы будем управлять -->
    <div id="timerHolder" style="display: none;margin-top:10px; border:1px solid #000;padding:10px;">
        Таймер видим.
    </div>
    
    <!-- Блоки видимостью которых мы будем управлять -->
    <div id="banerHolder" style="display: block;margin-top:10px; border:1px solid #000;padding:10px;">
        <img src="https://comet-server.ru/Logo.png"><br>
        Банер видим.
    </div>
    
    <!-- Блоки видимостью которых мы будем управлять -->
    <div id="textHolder" style="display: none;margin-top:10px; border:1px solid #000;padding:10px;">
        Текст
    </div>
    
    <script type="text/javascript">
        
    var timerValue = 60;
    $(document).ready(function(){
        /** 
         * Подписываемся на получение сообщения из канала adminControl с именем события timer
         */
        CometServer().subscription("adminControl.timer", function(event){
            console.log(["event", event])
            if(event.data.display === 'none'){
                console.log("Мы получили команду спрятать таймер");
                $("#timerHolder").hide(); // Изменям видимость блока с таймером
            }
            else
            {
                console.log("Мы получили команду показать таймер");
                $("#timerHolder").show(); // Изменям видимость блока с таймером
                timerValue = 60;
            }
        })
        
        /** 
         * Подписываемся на получение сообщения из канала adminControl с именем события baner
         */
        CometServer().subscription("adminControl.baner", function(event){
            console.log(["event", event])
            if(event.data.display === 'none'){
                console.log("Мы получили команду спрятать банер");
                $("#banerHolder").hide(); // Изменям видимость блока с банером
            }
            else
            {
                console.log("Мы получили команду показать банер");
                $("#banerHolder").show(); // Изменям видимость блока с банером
            }
        })
         
        /** 
         * Подписываемся на получение сообщения из канала adminControl с именем события baner
         */
        CometServer().subscription("ChatExample1.text", function(event){
            console.log("Мы получили команду показать блок текста с содержимым:", event.data.text);
            $("#textHolder").html( $("#textHolder").html() +"<hr>"+$('<div/>').text(event.data.text).html() ).show();
        })
         
        setInterval(function()
        { 
            // Для таймера
            if(timerValue <= 0)
            {
                $("#timerHolder").html("Таймер:Время истекло");
            }
            else
            {
                $("#timerHolder").html("Таймер:"+timerValue);
                timerValue--;
            } 
        },1000)
         
        /** 
         * Подключение к комет серверу. Для возможности принимать команды.
         * dev_id ваш публичный идентифиукатор разработчика
         */
        CometServer().start({dev_id:15 })
    })
    
    </script>
</body>
</html>
