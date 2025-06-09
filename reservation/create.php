<?php

session_start();
include("../connexion.php");
include("../include/header.php");
include("../include/sidebar.php");

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Inclure PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
$agent = $_SESSION['user']['nom'];
// Fonction pour envoyer un email
function envoyerEmailConfirmation($destinataire, $destination, $dateDepart, $dateRetour, $prix, $agent) {
    $mail = new PHPMailer(true);

    try {
        // Paramètres du serveur
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'calinecapris@gmail.com'; // Remplacez par votre email Gmail
        $mail->Password = 'huhg zdbx zfrx lfit'; // Utilisez un mot de passe d'application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        // Expéditeur et destinataire
        $mail->setFrom('votre.email@gmail.com', 'Agence de Voyage');
        $mail->addAddress($destinataire);

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = 'Confirmation de votre réservation';
        
        $message = "
        <html>
        <head>
            <title>Confirmation de réservation</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #007bff; color: white; padding: 10px; text-align: center; }
                .content { padding: 20px; border: 1px solid #ddd; }
                .footer { margin-top: 20px; font-size: 0.8em; color: #777; text-align: center; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Confirmation de votre réservation</h2>
                </div>
                <div class='content'>
                    <p>Bonjour,</p>
                    <p>Nous vous confirmons votre réservation pour la destination suivante :</p>
                    <ul>
                        <li><strong>Destination :</strong> " . htmlspecialchars($destination) . "</li>
                        <li><strong>Date de départ :</strong> " . htmlspecialchars($dateDepart) . "</li>
                        <li><strong>Date de retour :</strong> " . htmlspecialchars($dateRetour) . "</li>
                        <li><strong>Prix :</strong> " . number_format($prix, 2, ',', ' ') . " €</li>
                        <li><strong>Votre conseiller :</strong> " . htmlspecialchars($agent) . "</li>
                    </ul>
                    <p>Merci d'avoir choisi notre agence de voyage.</p>
                </div>
                <div class='footer'>
                    <p>Ceci est un email automatique, merci de ne pas y répondre.</p>
                </div>
            </div>
        </body>
        </html>";

        $mail->Body = $message;
        $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n"], $message));

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Erreur d'envoi d'email: " . $mail->ErrorInfo);
        return false;
    }
}

// Récupérer les clients avec leurs emails
$sql = "SELECT * FROM clients";
$statementClient = $connect->prepare($sql);
$statementClient->execute();
$clients = $statementClient->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les destinations avec leurs prix et dates
$sql = "SELECT * FROM destinations";
$statementDestination = $connect->prepare($sql);
$statementDestination->execute();
$destinations = $statementDestination->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire
if (isset($_POST["dateReservation"], $_POST["client_id"], $_POST["destination_id"])) {
    $dateReservation = $_POST["dateReservation"];
    $client_id = $_POST["client_id"];
    $destination_id = $_POST["destination_id"];
    $utilisateur_id = $_SESSION['user']['id'];
    
    // Utiliser le nom de l'utilisateur depuis la session, avec une valeur par défaut si non défini
    $utilisateur_nom = isset($_SESSION['user']['prenom']) 
        ? $_SESSION['user']['prenom'] . ' ' . ($_SESSION['user']['nom'] ?? '') 
        : 'Un conseiller';

    // Récupérer les informations du client et de la destination
    $client = array_filter($clients, function($c) use ($client_id) {
        return $c['id'] == $client_id;
    });
    $client = reset($client);

    $destination = array_filter($destinations, function($d) use ($destination_id) {
        return $d['id'] == $destination_id;
    });
    $destination = reset($destination);

    // Démarrer une transaction
    $connect->beginTransaction();

    try {
        // Insertion réservation
        $sql = "INSERT INTO reservations(date_reservation, client_id, destination_id, utilisateur_id)
                VALUES (:dateReservation, :client_id, :destination_id, :utilisateur_id);";
        $statement = $connect->prepare($sql);
        $statement->bindValue(':dateReservation', $dateReservation, PDO::PARAM_STR);
        $statement->bindValue(':client_id', $client_id, PDO::PARAM_INT);
        $statement->bindValue(':destination_id', $destination_id, PDO::PARAM_INT);
        $statement->bindValue(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
        
        if ($statement->execute()) {
            // Envoyer l'email de confirmation
            $emailEnvoye = envoyerEmailConfirmation(
                $client['email'],
                $destination['ville'],
                $destination['date_depart'],
                $destination['date_retour'],
                $destination['prix'],
                $utilisateur_nom
            );
            
            if (!$emailEnvoye) {
                throw new Exception("L'email de confirmation n'a pas pu être envoyé. La réservation a été annulée.");
            }
            
            $connect->commit();
            $_SESSION['success_message'] = "Réservation enregistrée avec succès et email de confirmation envoyé.";
            header('Location: index.php');
            exit();
        } else {
            throw new Exception("Erreur lors de l'ajout de la réservation.");
        }
    } catch (Exception $e) {
        $connect->rollBack();
        $error_message = $e->getMessage();
    }
}
?>

<h2 class="mt-3 text-center">AJOUTER UNE RÉSERVATION</h2>   
<div class="container">
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>
    
    <div class="card mt-5" style="margin-left: 10%; margin-right: 15px;">
        <div class="card-header bg-primary">
            <h4 class="text-white">FORMULAIRE D'AJOUT</h4>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <table class="table table-striped">
                    <tr>
                        <td>
                            <label for="dateReservation">Date de Réservation</label>
                            <input class="form-control" name="dateReservation" type="date" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="client_id">Client</label>
                            <select class="form-control" name="client_id" required>
                                <option value="">Sélectionnez un client</option>
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?= htmlspecialchars($client['id']) ?>">
                                        <?= htmlspecialchars($client['nom'] . ' ' . ($client['prenom'] ?? '')) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="destination_id">Destination</label>
                            <select class="form-control" name="destination_id" required>
                                <option value="">Sélectionnez une destination</option>
                                <?php foreach ($destinations as $destination): ?>
                                    <option value="<?= htmlspecialchars($destination['id']) ?>">
                                        <?= htmlspecialchars($destination['ville'] . ' - ' . date('d/m/Y', strtotime($destination['date_depart'])) . ' au ' . date('d/m/Y', strtotime($destination['date_retour'])) . ' - ' . number_format($destination['prix'], 2, ',', ' ') . ' €') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <center class="mt-3">   
                    <button type="reset" class="btn btn-danger">Annuler</button>
                    <button type="submit" class="btn btn-secondary">Enregistrer</button>
                </center>
            </form>
        </div>     
    </div>
</div>

<?php include('../include/footer.php'); ?>