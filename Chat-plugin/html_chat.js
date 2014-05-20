var htmljs_Chat_timer = new Date();
var htmljs_Chat_masgArray = {};

function web_send_msg()
{
    // Получение значений из элементов ввода.
    var text = $("#WebChatTextID").val();
    var name = $("#WebChatNameID").val();
    
    // Очистка формы
    $("#WebChatTextID").val("");  
    
    // Зпишем время в момент отправки сообщения
    htmljs_Chat_timer = new Date();
    
    // Добавление отправленного сообщения к списку сообщений.
    $("#WebChatFormForm").append("<p class='html-chat-msg' ><b>"+htmljs_Chat_HtmlEncode(name)+": </b>"+htmljs_Chat_HtmlEncode(text)+"</p>");
    
    // Используем случайное число чтоб нечайно не всавить два раза одно и тоже сообщение
    var randomId = ""+Math.floor(Math.random()*10) + "" + (Math.random()*10) + "" + (Math.random()*10) + "" + (Math.random()*10);
    randomId = randomId.replace(/[^0-9]/img, "");
    
    htmljs_Chat_masgArray[randomId] = true;
    
    // Отправка сообщения в канал чата
    CometServer().web_pipe_send("web_chat_pipe.msg", {"text":text, "name":name, "randomId":randomId});
    
    // Уведомим остальные вкладки о том что мы добавили сообщение в чат
    comet_server_signal().send_emit("AddToChat", {"text":text, "name":name, "randomId":randomId});
}

   
// Функция выполнится в после загрузки страницы
function htmljs_Chat_Init( holder )
{
    // Создание формы для чата. Вёрстка.
    var html =  "<div class=\"holder-html-chat\" >"
	          + "<div id=\"WebChatFormForm\" class=\"html-chat-history\" ></div>"
		  + "<input type=\"text\" id=\"WebChatNameID\" class=\"html-chat-js-name\"  placeholder=\"Укажите ваше имя...\" >"
	          + "<textarea id = \"WebChatTextID\" placeholder = \"Отправте сообщение в online чат...\" class=\"html-chat-js-input\" ></textarea>"

                  + "<div class=\"html-chat-js-button-holder\">"
                  +    "<input type=\"button\"  onclick=\"web_send_msg();\" value=\"Отправить\" >"
                  +    " <div class=\"html-chat-js-answer\"  ><a href=\"http://comet-server.ru\" id=\"answer\" target='__blank' >Работает на comet-server.ru</a></div>"
                  + "</div>"
             +  "</div>";
    $(holder).html(html);

    // Подписываемся на канал в который и будут отпавлятся сообщения чата. 
    CometServer().subscription("web_chat_pipe.msg", function(msg){
        console.log(["msg", msg]);
        
        if(!msg.data.randomId)
        {
            // Сообщение какоето не правильное, не имеющие randomId
            return;
        }
        
        msg.data.randomId = ""+msg.data.randomId;
        msg.data.randomId.replace(/[^0-9]/img, "");
        
        if(htmljs_Chat_masgArray[msg.data.randomId] && !msg.data.history)
        {
            // Сообщение уже вставлено
            return;
        }
        
        if(!msg.data.history)
        {
            htmljs_Chat_masgArray[msg.data.randomId] = true;
        }
        
        // Добавление полученого сообщения к списку сообщений.
        $("#WebChatFormForm").append("<p><b>"+htmljs_Chat_HtmlEncode(msg.data.name)+": </b>"+htmljs_Chat_HtmlEncode(msg.data.text)+"</p>");
    });
    
    // Подписываемся на событие добавления сообщения в чат нами, для того чтобы если чат открыт в нескольких вкладках
    // наше сообщение добавленое на одной вкладке отобразилось на всех остальных без перезагрузки страницы
    comet_server_signal().connect("AddToChat", function(msg){
        console.log(["msg", msg]);
        
        if(htmljs_Chat_masgArray[msg.randomId])
        {
            // Сообщение уже вставлено
            return;
        }
        
        htmljs_Chat_masgArray[msg.randomId] = true;
        
        // Добавление полученого сообщения к списку сообщений.
        $("#WebChatFormForm").append("<p><b>"+htmljs_Chat_HtmlEncode(msg.name)+": </b>"+htmljs_Chat_HtmlEncode(msg.text)+"</p>");
    });

    // Подписываемся на канал в который и будут отпавлятся уведомления о доставке отправленых сообщений.
    CometServer().subscription("#web_chat_pipe", function(p)
    {
        // Зпишем время в момент получения отчёта о доставке сообщения
        var etime = new Date();
        
        console.log(["answer_to_web_chat_pipe", p]);
        $("#answer").html("Сообщение доставлено "+p.data.number_messages+" получателям за "+ (etime.getTime() - htmljs_Chat_timer.getTime() )+"ms");
        if(p.data.error!= "") $("#answer").html(" "+p.data.error);
    });
    
    CometServer().subscription("chatControl.clean", function(event){
        console.log("Мы получили команду очистить чат");
        $("#WebChatFormForm").html( '' );
    });
    
    // Просим отправить последние сообщения которые были отправлены в канал. Это позволит загрузить историю сообщений в чат.    
    CometServer().get_pipe_log('web_chat_pipe');
}


function htmljs_Chat_HtmlEncode(s)
{
  var el = document.createElement("div");
  el.innerText = el.textContent = s;
  s = el.innerHTML;
  return s;
}
