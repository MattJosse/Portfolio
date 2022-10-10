var url = "http:/fiat.polytechnique.fr:60471";
var client_id = "testclient";
var client_mdp = "testpass";

function oAuthConnect() {

    var username = $('#userid').val();
    var password = $('#mdp').val();

    return $.ajax({
        method: "post",
        url: url + "/token.php",
        dataType: "json",
        xhrFields: {
            withCredentials: true
        },
        beforeSend: function (xhr) {
            // login + mdp pour se connecter à l'API
            xhr.setRequestHeader('Authorization', 'Basic ' + btoa(client_id + ':' + client_mdp));
        },
        data: {
            grant_type: "password",
            // login + mdp LDAP / ENEX (pas besoin de les stocker)
            username: username,
            password: password
        }
    });
}