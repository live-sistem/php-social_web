// Ну тип регистрация

document.getElementById("registration").addEventListener("submit", function(event) {
    event.preventDefault();
    const login = document.getElementById("exampleInputEmail").value;
    const password = document.getElementById("exampleInputPassword").value;
    const username = document.getElementById("exampleInputName").value;
    const surname = document.getElementById("exampleInputSurname").value;

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "src/registration.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    xhr.onload = function() {
     if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
            window.location.href = 'login.html'; 
        } else {
            console.log('Ошибка: ' + response.message);
      }
    } else {
        console.log('Ошибка при отправке данных');
    }
  };
    const data = `login=${encodeURIComponent(login)}&password=${encodeURIComponent(password)}&username=${encodeURIComponent(username)}&surname=${encodeURIComponent(surname)}`;
    xhr.send(data);
  });