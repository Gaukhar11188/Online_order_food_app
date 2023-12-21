var ao = createAjaxObject();

function createAjaxObject() {
    var ao = null;
    try {
        ao = new XMLHttpRequest();
    } catch (e) {
        try {
            ao = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ao = new
                ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                alert("AJAX is not supported by your browser!")
                return false;
            }
        }
    }
    return ao;
}

function ButtonClick(){
    if(ao.readyState == 4 || ao.readyState == 0){
        let login = document.getElementById("login").value;
        let password = document.getElementById("password").value;
        let repeat_password = document.getElementById("repeat_password").value;
        ao.open("POST", "php/register_user.php", true);
        ao.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ao.onreadystatechange = getData;
        // Соблюдайте синтаксис отправки данных
        ao.send("login=" + login + "&password=" + password + "&repeat_password=" + repeat_password);
    }
}

// function checkSingIn(){
//     if(ao.readyState == 4 || ao.readyState == 0){
//         ao.open("GET", "handler.php", true);
//         ao.onreadystatechange = getData;                              // GET
//         ao.send(null);
//     }
// }

function getData() {
    if (ao.readyState == 4 && ao.status == 200) {
        resp = ao.responseText;
        if(resp == 1){
            window.location.href = "./index.html";
        }
        else{
            document.getElementById("result").innerHTML = resp;
        }
    }
}