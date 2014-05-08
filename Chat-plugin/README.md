<h3>Готовый движок чата на JavaScript для любого сайта.</h3>
HTML чат без серверной части работать не будет. Для работы чата требуется комет сервер который будет отправлять push уведомления всем участникам чата. Но для этого чата комет сервер предоставляется бесплатно, вам даже регистрироваться там не обязательно. В таком случаии чат будет общий для всех сайтов которые его вставят. Это даже не плохо, особенно для сайтов с небольшой посещаемостью. А те кто хотят иметь чат только для своего сайта или своей группы сайтов должны <a hrtef="https://comet-server.ru" >зарегистрироваться и бесплатно получить идентификатор разработчика</a> на comet-server.ru а затем его указать в коде инициализации чата ( вместо dev_id: 3 указать свой полученный id).

<a hrtef="https://comet-server.ru/%D1%80%D0%B0%D0%B7%D0%B4%D0%B5%D0%BB/15/subject/8" >Подробности и живой пример работы чата смотреть здесь</a>

<h3>Встраиваем чат в html вашего сайта.</h3>
В HTML код вставляем вот такой скрипт.

<pre>
&lt;script type=&quot;text/javascript&quot; src=&quot;https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js&quot; &gt;&lt;/script&gt;
&lt;script type=&quot;text/javascript&quot; src=&quot;https://comet-server.ru/CometServerApi.js&quot; &gt;&lt;/script&gt;
&lt;script type=&quot;text/javascript&quot; src=&quot;https://comet-server.ru/doc/html_chat.js&quot; &gt;&lt;/script&gt;
&lt;link   type=&quot;text/css&quot; rel=&quot;stylesheet&quot; href=&quot;https://comet-server.ru/doc/html_chat.css&quot;&gt;&lt;/link&gt;
<pre>

Осталось настроить сам чат и запустить, для этого пишем небольшой скрипт.
<pre>
&lt;style&gt;
/* Здесь настроим css стили для чата*/
.holder-html-chat{ border: 1px solid #ccc;padding:10px;background-color: #fff;width: 600px;}
.html-chat-history{ max-width: 600px; overflow: auto;max-height: 900px; border: 1px solid #ccc;padding: 5px;}
.html-chat-js-name{ margin-top:10px; }
.html-chat-js-input{ max-width: 600px;max-height: 100px;width: 600px;margin-top:10px; }
.html-chat-js-button-holder{ margin-bottom: 0px;margin-top: 10px; }
.html-chat-js-button-holder input{ width: 220px; }
.html-chat-js-answer{ float:right; }
.html-chat-js-answer a{ color: #777;font-size: 12px; font-family: cursive;}
.html-chat-js-answer a:hover{ color: #338;font-size: 12px; font-family: cursive;}
.html-chat-msg{ margin: 0px; }
&lt;/style&gt;

&lt;script&gt;

   /**
    * Чат работает на comet-server.ru
    * По любым вопросам обращайтесь support@comet-server.ru или на сайт comet-server.ru
    */
    $(document).ready(function()
    {
       // Запуск api комет сервера
       CometServer().start({dev_id: 3 }) // Идентификатор разработчика на comet-server.ru

       // Запуск чата. Передаём ему элемент в котором надо создать окно чата.
       htmljs_Chat_Init( $(&quot;#html-chat&quot;) )
    });
&lt;/script&gt;
<pre>
