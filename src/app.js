
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
// Иконка прикрепление файла. 
function updateFileName() {
  var fileInput = document.getElementById('file-upload');
  var fileName = document.getElementById('file-name');
  if (fileInput.files.length > 0) {
      fileName.textContent = "Выбран файл: " + fileInput.files[0].name;
  } else {
      fileName.textContent = "";
  }
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

// Обработка запроса на поиск друга по login
document.getElementById("form_search_for_friends").addEventListener("submit", function(event){
  event.preventDefault();
  const login = document.getElementById("exampleInputEmail").value;
  
  const container_search_users = document.getElementById('result-search-item');
  container_search_users.innerHTML = ''; // Очищаем контейнер перед добавлением новых данных
  
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "src/friends-test.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function(){
    if (xhr.status === 200) {
      var response = xhr.response;
      container_search_users.innerHTML = response;
    }
    else {
      console.log('Ошибка при отправке данных');
    };

  };
  const data = `login=${encodeURIComponent(login)}`;
  xhr.send(data);

  
  });


// Запускаем проверку

// document.addEventListener('DOMContentLoaded', function() {
//   const button123 = document.getElementById('myButton123');
//   button123.addEventListener('click', function() {
//       alert('Кнопка была нажата!');
//   });
// });
// function initBlockLogic() {
//   const block = document.getElementById('search-friends-id');
//   if (block) {
//       console.log('Блок найден, можно выполнять логику');
//       // Ваша бизнес-логика здесь
//   } else {
//       console.error('Блок не найден!');
//       // Можно повторить попытку через некоторое время
//       setTimeout(initBlockLogic, 100); // Проверяем снова через 100 мс
//   }
// }

// document.getElementById("search-friends-id").addEventListener("submit", function(event){
//   event.preventDefault();

//   const login = document.getElementById("search-item-login-id").textContent;
//   const nameUser = document.getElementById("search-item-name-id").textContent;
//   console.log(login, nameUser);
//   // container.innerHTML = ''; // Очищаем контейнер перед добавлением новых данных
//   // console.log(login);
//   // const xhr = new XMLHttpRequest();
//   // xhr.open("POST", "src/friends.php", true);
//   // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

//   // xhr.onload = function(){
//   //   if (xhr.status === 200) {
//   //     var response = xhr.response;
//   //     console.log(response);
//   //   }
//   //   else {
//   //     console.log('Ошибка при отправке данных');
//   //   };
//   // };
//   // const data = `login=${encodeURIComponent(login)}`;
//   // xhr.send(data);
//   });

// document.getElementById("search-friends-id").addEventListener("submit", function(event){
//   event.preventDefault();

//   const login = document.getElementsByClassName("search-item-login").value;
//   const nameUser = document.getElementsByClassName('search-item-name').value;
//   console.log(login, nameUser)
//   container.innerHTML = ''; // Очищаем контейнер перед добавлением новых данных
//   console.log(login);
  
//   // const xhr = new XMLHttpRequest();
//   // xhr.open("POST", "src/friends.php", true);
//   // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

//   // xhr.onload = function(){
//   //   if (xhr.status === 200) {
//   //     var response = xhr.response;
//   //     console.log(response);
//   //   }
//   //   else {
//   //     console.log('Ошибка при отправке данных');
//   //   };
//   // };
//   // const data = `login=${encodeURIComponent(login)}`;
//   // xhr.send(data);
//   });


