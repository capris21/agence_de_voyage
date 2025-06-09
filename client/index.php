<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit();
}
include("../connexion.php");
include("../include/header.php");
include("../include/sidebar.php");
?>

<?php
    // Récupérer les clients de la base de données
    $sql = "SELECT * FROM clients";
    $statement = $connect->prepare($sql);
    $statement->execute();
    $clients = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="mt-4 text-center text-primary fw-bold">GESTION DES CLIENTS</h2>
<div class="container my-5">
    <div class="card shadow-lg" style="max-width: 1000px; margin: 0 auto;">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Liste des clients</h4>
            <a href="create.php" class="btn btn-success btn-sm">
                <i class="bi bi-person-plus"></i> Ajouter
            </a>
        </div>
        <div class="card-body bg-light">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Téléphone</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($clients as $client): ?>
                    <tr class="text-center">
                        <th scope="row"><?= htmlspecialchars($client["id"]) ?></th>
                        <td><?= htmlspecialchars($client["nom"]) ?></td>
                        <td><?= htmlspecialchars($client["prenom"]) ?></td>
                        <td><?= htmlspecialchars($client["email"]) ?></td>
                        <td><?= htmlspecialchars($client["telephone"]) ?></td>
                        <td>
                            <a href="show.php?id=<?= htmlspecialchars($client["id"]) ?>" class="btn btn-outline-primary btn-sm" title="Détails">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="edit.php?id=<?= htmlspecialchars($client["id"]) ?>" class="btn btn-outline-info btn-sm" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="delete.php?id=<?= htmlspecialchars($client["id"]) ?>" class="btn btn-outline-danger btn-sm" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce client ?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (empty($clients)): ?>
                <div class="alert alert-warning text-center mt-3">Aucun client trouvé.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bootstrap Icons CDN (à placer dans le <head> de ton layout principal si pas déjà fait) -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->

<?php include('../include/footer.php'); ?>
