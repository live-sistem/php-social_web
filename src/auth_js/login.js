// Ну тип авторизация

document.getElementById("login").addEventListener("submit", function(event) {
    event.preventDefault();
    const login = document.getElementById("exampleInputEmail").value;
    const password = document.getElementById("exampleInputPassword").value;

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "src/login.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
            console.log("it`s ok")
            window.location.href = 'profile.php'; 
        } else {
            console.log('Ошибка: ' + response.message);
        }
    } else {
        console.log('Ошибка при отправке данных');
    }
    };
    const data = `login=${encodeURIComponent(login)}&password=${encodeURIComponent(password)}`;
    xhr.send(data);
});