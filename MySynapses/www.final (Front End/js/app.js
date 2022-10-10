$(document).ready(function () {

    $(window).on('hashchange', route);

    function route() {
        var hash = window.location.hash;
        switch (hash) {
            default:
                $.get("template/index.tpl.html", function (template) {
                    $("#my-content").html(template);
                   


                }, "html");
                break;

            case "#login":
                $.get("template/login.tpl.html", function (template) {
                    $("#my-content").html(template);
                    $("#btn").click(function () {
                        oAuthConnect()
                            .done(function (data) {
                                if(data['access_token']!='undefined'){
                                    localStorage.setItem("token", data['access_token']);
                                    alert("on a gagné");
                                }
                            })
                            .fail(function (xhr, status, error) {
                               alert("perdu");
                                var err = eval("(" + xhr.responseText + ")");
                            });

                    })
                }, "html");
                break;


            case "#register":
                $.get("template/register.tpl.html", function (template) {
                    $("#my-content").html(template);
                    $("#btn").click(function () {
                        let VARuserid = $("#userid").val();
                        let VARmdp1 = $("#mdp1").val();
                        let VARmdp2 = $("#mdp2").val();
                        let VARnom=$("#nom").val();
                        let VARprenom=$("#prenom").val();
                        let VARemail=$("#email").val();
                        let VARbool = (VARuserid != "" && VARmdp1 != "" && VARmdp2 != "" && VARmdp1 == VARmdp2);
                        let VARmessage = "";

                        if (VARbool) {
                            $.post("http://fiat.polytechnique.fr:60471/register.php",
                                { mdp1: VARmdp1, mdp2: VARmdp2, userid: VARuserid, nom: VARnom, prenom : VARprenom, email : VARemail }, function (data) {
                                    VARmessage = data['error'];

                                    if (data['error'][0] != 'B') {
                                        $('#exampleModalLabel').html("Inscription échouée")
                                    }
                                    else {
                                        $('#exampleModalLabel').html("Inscription réussie");

                                    }
                                    $('#themessage').html(VARmessage);
                                    $('#exampleModal').modal('toggle');
                                });

                        }
                        else {
                            $('#exampleModalLabel').html("Inscription échouée")
                            if (VARmdp1 != VARmdp1) VARmessage = "Les Mots De Passe ne correspondent pas !!!";
                            if (VARmdp2 == "") VARmessage = "Veuillez confirmer le Mot De Passe !!!";
                            if (VARmdp1 == "") VARmessage = "Veuillez entrer un Mot De Passe !!!";
                            if (VARuserid == "") VARmessage = "Veuillez entrer un Identifiant !!";

                            $('#themessage').html(VARmessage);
                            $('#exampleModal').modal('toggle');
                        }


                    });


                }, "html");
                break;


            case "#cours":



                $.get("template/cours.tpl.html", function (template) {
                    $.getJSON("http://fiat.polytechnique.fr:60471/catalogue.php", function (data) {
                        let rendered_template = Mustache.render(template, data)
                        $("#my-content").html(rendered_template);
                    })



                }, "html");

                break;

            case "#edt":
                $.get("template/edt.tpl.html", function (template) {
                    $("#my-content").html(template);
                }, "html");
                break;

            case "#photo":
                $.get("template/photo.tpl.html", function (template) {
                    $("#my-content").html(template);
                    const carousel = new bootstrap.Carousel('#myCarousel')

                }, "html");

                break;

            case "#calc":
                $.get("template/calc.tpl.html", function (template) {
                    $("#my-content").html(template);



                    let typing = ""
                    let saved = ""
                    let opp = ""

                    let first_number = false;

                    function calcul() {

                        switch (opp) {
                            case ("+"):
                                typing = parseFloat(saved) + parseFloat(typing)
                                break;
                            case ("-"):
                                typing = saved - typing
                                break;
                            case ("÷"):
                                typing = saved / typing
                                break;
                            case ("×"):
                                typing = saved * typing
                                break;
                            default:
                                break;
                                $("#aahhaa").html(typing)

                                return;
                        }
                    }

                    $(".col").click(function () {

                        let b = $(this).html()[11]

                        switch (b) {

                            case ("+"):
                            case ("-"):
                            case ("÷"):
                            case ("×"):
                                first_number = true
                                if (opp != "") {
                                    calcul()
                                }

                                saved = typing;
                                opp = b
                                break;
                            case ("="):
                                calcul()
                                opp = "";

                                break;


                            default:
                                if (first_number == true) {
                                    typing = "";
                                    first_number = false;
                                }
                                typing = typing + b
                                break;
                        }
                        $("#aahhaa").html(typing)

                    })

                }, "html");
            case "#detailcours":
                $.get("template/cours2.tpl.html", function (template) {
                    var actualcode = sessionStorage.getItem('code');
                    $.get("http://fiat.polytechnique.fr:60471/cours.php?code=" + actualcode, function (data) {
                        let rendered_template = Mustache.render(template, data)
                        $("#my-content").html(rendered_template);
                        $("#sum").css({ 'color': 'black' })
                        $('.border').css({ 'padding': '5%' })
                        $('#prof').css({ "font-weight": "bold" })
                        document.getElementById("badgecode").innerHTML = actualcode.substring(0, 3);

                    })



                }, "html");

                break;


                break;
        }
    }

    route();
});