
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

// Тут выводим список сообщений при нажатии на пользователя
document.querySelectorAll('.user-item').forEach(function(userItem) {
    userItem.addEventListener('click', function(event) {
        event.preventDefault();
        var recipientId = this.getAttribute('data-user-id'); // Получаем ID выбранного пользователя
        var selectedUserName = this.getAttribute('data-user-name'); // Получаем имя выбранного пользователя
        var container = document.getElementById('chatBox'); // Нууу тип все сообщения

        document.querySelectorAll('.user-item').forEach(function(item) {
            item.classList.remove('selected');
        });
        this.classList.add('selected');
        if (recipientId) {
            document.getElementById('incoming_id').value = recipientId;
            SelUserName = document.getElementById('selected-user-name').innerHTML = selectedUserName;
            loadMessages(recipientId, container);
            setTimeout(() => {
              container.scrollTop = container.scrollHeight;
            }, 500);
            document.getElementById('chat-box').style.display = 'block';
            document.getElementById('chatBox').style.display = 'flex';
        }else {
            document.querySelectorAll('overflow_masssages').style.display = 'none';
            document.getElementById('chat-box').style.display = 'none';
        }
    });
});

function loadMessages(recipientId, container){
  if (recipientId, container !== undefined) {
    // Сохраняем переданные данные
    userId_copy = recipientId;
    container_copy = container;
  }
  // Тут загружаем историю сообщений для выбранного пользователя
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'src/get_mess.php?user_id=' + userId_copy, true);
  xhr.onload = function() {
    if (xhr.status === 200){
        var messages = xhr.response;
        container_copy.innerHTML = messages;
    } else {
        console.error('Ошибка при загрузке сообщений');
    }
  };    
  xhr.send();
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
            document.getElementById('message').value = '';
          }
      };
      xhr.send('incoming_id=' + encodeURIComponent(incomingId) + '&message=' + encodeURIComponent(message));
      setTimeout(() => {
        loadMessages();
          container.scrollTop = container.scrollHeight;
      }, 500);
      
  });
});

