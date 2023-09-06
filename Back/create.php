<?php
/* Inclure le fichier config */
require_once "config.php";
 
/* Definir les variables */
$firstname = $lastname = $id = $email = $phonenumber = "";
$firstname_err = $lastname_err = $id_err = $email_err = $phonenumber_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    /* entrer le prenom */
    $input_firstname = trim($_POST["prenom"]);
    if(empty($input_name)){
        $firstname_err = "Veillez entrez un prenom.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $firstname_err = "Veillez entrez un prenom valide.";
    } else{
        $prenom = $input_firstname;
    }
     /* entrer le nom */
     $input_lastname = trim($_POST["nom"]);
     if(empty($input_lastname)){
         $firstname_err = "Veillez entrez un nom.";
     } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
         $firstname_err = "Veillez entrez un nom valide.";
     } else{
         $prenom = $input_lastname;
     }
     
    
    /* email */
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Veillez entrez un email.";     
    } else{
        $email = $input_email;
    }
    
    /* ID*/
    $input_id = trim($_POST["id"]);
    if(empty($input_id)){
        $id_err = "Veillez entrez l'ID.";     
    } elseif(!ctype_digit($input_id)){
        $id_err = "Veillez entrez une valeur positive.";
    } else{
        $id = $input_id;
    }
     
    /* phonenumber*/
    $input_phonenumber = trim($_POST["phonenumber"]);
    if(empty($input_phonenumber)){
        $Phonenumber_err = "Veillez entrez le numero de telephone.";     
    } elseif(!ctype_digit($input_id)){
        $phonenumber_err = "Veillez entrez un numéro valide.";
    } else{
        $phonumber = $input_phonenumber;
    }
    
    /* verifiez les erreurs avant enregistrement */
    if(empty($fistname_err) && empty($lastname_err) && empty($email_err) && empty($id_err)&& empty($phonenumber_err)){
        /* Prepare an insert statement */
        $sql = "INSERT INTO contact (firstname, lastname, email, id, phonenumber) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            /* Bind les variables à la requette preparée */
            mysqli_stmt_bind_param($stmt, "ssd", $param_lastname, $param_firstname, $param_email, $param_id, $param_phonenumber);
            
            /* Set parameters */
            $param_lastname = $nom;
            $param_firstname = $prenom;
            $param_email = $email;
            $param_id = $id;
            $param_phonenumber = $phonenumber;
            /* executer la requette */
            if(mysqli_stmt_execute($stmt)){
                /* opération effectuée, retour */
                header("location: index.php");
                exit();
            } else{
                echo "Oops! une erreur est survenue.";
            }
        }
         
        /* Close statement */
        mysqli_stmt_close($stmt);
    }
    
    /* Close connection */
    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .wrapper{
            width: 700px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Créer un enregistrement</h2>
                    <p>Créer un contact dans la base de données</p>


                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" lastname="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
                            <span class="invalid-feedback"><?php echo $lastname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Prenom</label>
                            <input type="text" firstname="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
                            <span class="invalid-feedback"><?php echo $firstname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>email</label>
                            <input type="text" email="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>id</label>
                            <input type="number" id="id" class="form-control <?php echo (!empty($id_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $id; ?>">
                            <span class="invalid-feedback"><?php echo $id_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Numéro de téléphone</label>
                            <input type="number"phonenumber="phonenumber" class="form-control <?php echo (!empty($phonenumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phonenumber; ?>">
                            <span class="invalid-feedback"><?php echo phonenumber_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enregistrer">
                        <a href="index.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>