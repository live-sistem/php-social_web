
// Обработка нажатий по кнопкам  
// Друзья
// Заявки                           
// Сообщения
const buttons = document.querySelectorAll('.btn_colec');
const blocks = document.querySelectorAll('#blok_1, #blok_2, #blok_3, #blok_4');

let messageInterval;
buttons.forEach((button, index) => {
  button.addEventListener('click', () => {
    // Скрываем все блоки
    blocks.forEach(block => {
      block.classList.remove('show');  // Убираем класс 'show' у всех блоков
    });
    // Добавляем класс 'show' к нужному блоку, соответствующему нажатой кнопке
    blocks[index].classList.add('show');
  });
});




// Тут выводим список сообщений
document.querySelectorAll('.user-item').forEach(function(userItem) {
    userItem.addEventListener('click', function(event) {
        event.preventDefault();
        var recipientId = this.getAttribute('data-user-id'); // Получаем ID выбранного пользователя
        var selectedUserName = this.querySelector('#name').textContent; // Получаем имя выбранного пользователя
        var container = document.getElementById('chatBox');
        // history.pushState({}, '', '../profile.php?user_id=' + recipientId);
        // Подсвечиваем выбранного пользователя
        document.querySelectorAll('.user-item').forEach(function(item) {
            item.classList.remove('selected');
        });
        this.classList.add('selected');

        if (recipientId) {
            // Показываем второй блок
            document.getElementById('chat-box').style.display = 'block';

            document.getElementById('selected-user-name').textContent = selectedUserName;

            document.getElementById('incoming_id').value = recipientId;

            loadMessages(recipientId, container);

            // function startMessageUpdate(recipientId, container) {

            //   if (messageInterval){
            //     clearInterval(messageInterval)
            //   }
            //   messageInterval = setInterval(function() {
            //     loadMessages(recipientId, container);  // Загружаем новые сообщения
            //   }, 500);

            //   container.scrollTop = container.scrollHeight; // не работате 
            
            // }
            // startMessageUpdate(recipientId, container);
            
        } else {
            // Если пользователь не выбран, скрываем второй блок
            document.getElementById('chat-box').style.display = 'none';
        }
    });
});

function loadMessages(recipientId, container){
  if (recipientId, container !== undefined) {
    // Сохраняем переданные данные
    cipientId_copy = recipientId;
    container_copy = container;
  }
  // Тут загружаем историю сообщений для выбранного пользователя
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'src/get_mess.php?user_id=' + cipientId_copy, true);
  xhr.onload = function() {
    if (xhr.status === 200){
        var messages = xhr.response;
        container_copy.innerHTML = messages;
        
    } else {
        console.error('Ошибка при загрузке сообщений');
    }
  };    
  // Отправляем запрос
  xhr.send();

  setInterval(() => container.scrollTop = container.scrollHeight, 200);

  
}

// Обработка запроса на отправку нового сообщения
document.addEventListener('DOMContentLoaded', function() {
  var container = document.getElementById('chatBox');

  const sendMessageButton = document.getElementById('send-message-btn');
  
  sendMessageButton.addEventListener('click', function(event) {
      event.preventDefault();

      const incomingId = document.getElementById('incoming_id').value;
      const message = document.getElementById('message').value;

      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'src/insert_mess.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhr.onload = function() {
          if (xhr.status === 200) {
            console.log(incomingId)
            document.getElementById('message').value = '';
          }
      };
      xhr.send('incoming_id=' + encodeURIComponent(incomingId) + '&message=' + encodeURIComponent(message));
      
      loadMessages();
      
      
  });
});

