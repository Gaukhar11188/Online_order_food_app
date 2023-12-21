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

function loginButtonClick(){
    if(ao.readyState == 4 || ao.readyState == 0){
        let login = document.getElementById("login").value;
        let password = document.getElementById("password").value;
        ao.open("POST", "php/login_user.php", true);
        ao.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ao.onreadystatechange = getData;
        ao.send("login=" + login + "&password=" + password);
    }
}


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