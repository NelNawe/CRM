<?php
/* Inclure le fichier */
require_once "config.php";
 
/* Definir les variables */
$firstname = $lastname = $id = $email = $phonenumber = "";
$firstname_err = $lastname_err = $id_err = $email_err = $phonenumber_err = "";
 
/* verifier la valeur id dans le post pour la mise à jour */
if(isset($_POST["id"]) && !empty($_POST["id"])){
    /* recuperation du champ caché */
    $id = $_POST["id"];
    
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
     /* phonenumber*/
     $input_phonenumber = trim($_POST["phonenumber"]);
     if(empty($input_phonenumber)){
         $Phonenumber_err = "Veillez entrez le numero de telephone.";     
     } elseif(!ctype_digit($input_id)){
         $phonenumber_err = "Veillez entrez un numéro valide.";
     } else{
         $phonumber = $input_phonenumber;
     }
    
    /* verifier les erreurs avant modification */
    if(empty($fistname_err) && empty($lastname_err) && empty($email_err) && empty($id_err)&& empty($phonenumber_err)){
        
        $sql = "INSERT INTO contact (firstname, lastname, email, id, phonenumber) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "ssd", $param_lastname, $param_firstname, $param_email, $param_id, $param_phonenumber);
            
           
            /* Set parameters */
            $param_lastname = $nom;
            $param_firstname = $prenom;
            $param_email = $email;
            $param_id = $id;
            $param_phonenumber = $phonenumber;
            
            
            if(mysqli_stmt_execute($stmt)){
                /* enregistremnt modifié, retourne */
                header("location: index.php");
                exit();
            } else{
                echo "Oops! une erreur est survenue.";
            }
        }
         
        
        mysqli_stmt_close($stmt);
    }
    
    
    mysqli_close($link);
} else{
    /* si il existe un paramettre id */
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        
        $id =  trim($_GET["id"]);
        
       
        $sql = "SELECT * FROM contact WHERE id = ?";


        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            
            $param_id = $id;
            
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* recupere l'enregistremnt */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    /* recupere les champs */
                    $param_lastname = $row["nom"];
                    $param_firstname = $row["prenom"];
                    $param_email = $row ["email"];
                    $param_id = $row["id"];
                    $param_phonenumber = $row["phonenumber"];
                } else{
                    
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! une erreur est survenue.";
            }
        }
        
        /* Close statement */
        mysqli_stmt_close($stmt);
        
        /* Close connection */
        mysqli_close($link);
    }  else{
        /* pas de id parametter valid, retourne erreur */
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'enregistremnt</title>
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
                    <h2 class="mt-5">Mise à jour de l'enregistremnt</h2>
                    <p>Modifier les champs et enregistrer</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enregistrer">
                        <a href="index.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>