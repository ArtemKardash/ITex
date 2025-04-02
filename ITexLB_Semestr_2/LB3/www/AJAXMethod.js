let SelectClient = document.getElementById("ClientSeanseSelect");
let SelectButton = document.getElementById("buttonSelectClient");
let ResultOfSelect = document.getElementById("SeanseClientResult");

let ButtonTime = document.getElementById("buttonClientTime");
let TimeTwo = document.getElementById("ClientTime_One");
let TimeOne = document.getElementById("ClientTime_Two");
let ResultOfTime = document.getElementById("SeanseTimeResult");

let BalanceButton = document.getElementById("buttonBalance");
let ResultOfBalance = document.getElementById("SeanseClientBalance");

SelectButton.addEventListener("click", function() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", `SeanseClient.php?Client=${SelectClient.value}`, true);
    xhr.responseType = "text";
    xhr.send();
    xhr.onload = () => {
        ResultOfSelect.innerHTML = xhr.response;
    };
    xhr.onerror = () => {
      alert("Error in request 1");
    };
  });

  ButtonTime.addEventListener("click", function() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "SeanseTime.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    let data = `time=${TimeOne.value}&time2=${TimeTwo.value}`;
    xhr.onload = () => {
        let xmlDoc = xhr.responseXML;
        let clients = xmlDoc.getElementsByTagName('client');
        let resultHTML = "<h2>Список клієнтів, які працювали у заданому проміжку часу:</h2>";
        if (clients.length > 0) {
            for (let i = 0; i < clients.length; i++) {
                let client = clients[i];
                let clientID = client.getElementsByTagName('id')[0].textContent;
                let clientName = client.getElementsByTagName('name')[0].textContent;
                let clientStart = client.getElementsByTagName('start')[0].textContent;
                let clientStop = client.getElementsByTagName('stop')[0].textContent;
                resultHTML += `<p style='font-size: 20px'>Клієнт: ${clientName}, ID: ${clientID}, Час початку: ${clientStart}, Час виходу: ${clientStop}</p>`;
            }
        } else {
            resultHTML = "<p style='font-size: 20px'>Немає клієнтів у заданому проміжку часу.</p>";
        }
        ResultOfTime.innerHTML = resultHTML;
    };
    xhr.send(data);
    xhr.onerror = () => {
        alert("Error in request 2");
    };
});

BalanceButton.addEventListener("click", function() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "NegativeBalance.php", true);
    xhr.responseType = "json"; 
    xhr.send();
    xhr.onload = () => {  
        let balanceData = xhr.response;
        if (balanceData.length > 0) {
            let resultHTML = "<h2>Список клієнтів з від'ємним балансом:</h2>";    
            balanceData.forEach(function(client) {
                resultHTML += `<p style='font-size: 20px'>Клієнт: ${client.name}, Баланс: ${client.balance}</p>`;
            });
            ResultOfBalance.innerHTML = resultHTML;
        } else {
                ResultOfBalance.innerHTML = "<p style='font-size: 20px'>Немає клієнтів з від'ємним балансом!</p>";
        }
    };
    xhr.onerror = () => {
        alert("Error in request 3");
    };
});
