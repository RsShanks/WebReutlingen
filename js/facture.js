$(document).ready(function () {
    $("#annuler").click(function (e) {
        e.preventDefault();

        window.location.href = 'panier.php';
    })
})
//permet de mettre la commande comme payer
$(document).ready(function () {
    $("#envoyer").click(function (e) {
        e.preventDefault();
<<<<<<< HEAD

=======
        window.location.href = 'thanks.php';
>>>>>>> mast
        $.ajax({
            type: "GET",
            url: "php/set_payer.php",
            dataType: "json",
            success: function (response) {
                if (response.statu == 'ok') {
                    //permet d'envoyer le mail
            
		
                    $.ajax({
                        type: "GET",
                        url: "php/envoyerMail.php",
                        dataType: "json",
<<<<<<< HEAD
                        success: function (response1) {
                         console.log("Réponse de envoyerMail.php :", response1);
                            if (response1.statu == 'ok') {
                                window.location.href = 'index.php';
                            }
                            else{
                                console.log(response1.statu);
                            }
                        }
=======
                        
>>>>>>> mast
                    });
                    //
                }
                else{
                    console.log(response.statu+"ici");
                }
            }
        });
    })
})
