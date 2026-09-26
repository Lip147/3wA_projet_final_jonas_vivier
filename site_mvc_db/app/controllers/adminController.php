<?php
require_once __DIR__ . '/../controllers/authController.php';
require_once __DIR__ . '/../models/peintureModel.php';
require_once __DIR__ . '/../models/coutureModel.php';
require_once __DIR__ . '/../models/evenementModel.php';

class ImageUploadException extends RuntimeException {}

function adminMaxImageBytes(): int {
    $configuredValue = (int)env_value('MAX_IMAGE_UPLOAD_BYTES', 8 * 1024 * 1024);

    return $configuredValue > 0 ? $configuredValue : 8 * 1024 * 1024;
}

function adminMaxImagePixels(): int {
    $configuredValue = (int)env_value('MAX_IMAGE_PIXELS', 40000000);

    return $configuredValue > 0 ? $configuredValue : 40000000;
}

function adminConsumeError(): string {
    $message = isset($_SESSION['admin_error']) && is_string($_SESSION['admin_error'])
        ? $_SESSION['admin_error']
        : '';
    unset($_SESSION['admin_error']);

    return $message;
}

function adminHandleImageUpload(array $data) {
    if (empty($_FILES['image_file'])) {
        return $data;
    }

    $file = $_FILES['image_file'];
    if (!isset($file['error']) || is_array($file['error'])) {
        throw new ImageUploadException('La requête d\'envoi de l\'image est invalide.');
    }

    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return $data;
    }

    if (in_array($file['error'], [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
        $maxMiB = round(adminMaxImageBytes() / 1024 / 1024, 1);
        throw new ImageUploadException("L'image dépasse la limite autorisée de {$maxMiB} Mio.");
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new ImageUploadException('L\'envoi de l\'image a échoué. Veuillez réessayer.');
    }

    $tmpPath = $file['tmp_name'] ?? '';
    if (!is_string($tmpPath) || !is_uploaded_file($tmpPath)) {
        throw new ImageUploadException('Le fichier reçu n\'est pas un upload valide.');
    }

    $actualSize = filesize($tmpPath);
    if ($actualSize === false || $actualSize <= 0) {
        throw new ImageUploadException('Le fichier image est vide ou illisible.');
    }

    if ($actualSize > adminMaxImageBytes()) {
        $maxMiB = round(adminMaxImageBytes() / 1024 / 1024, 1);
        throw new ImageUploadException("L'image dépasse la limite autorisée de {$maxMiB} Mio.");
    }

    $imageInfo = @getimagesize($tmpPath);
    if ($imageInfo === false) {
        throw new ImageUploadException('Le fichier envoyé n\'est pas une image valide.');
    }

    $allowedMimeTypes = [
        'image/jpeg' => ['extension' => 'jpg', 'image_type' => IMAGETYPE_JPEG],
        'image/png' => ['extension' => 'png', 'image_type' => IMAGETYPE_PNG],
        'image/gif' => ['extension' => 'gif', 'image_type' => IMAGETYPE_GIF],
        'image/webp' => ['extension' => 'webp', 'image_type' => IMAGETYPE_WEBP],
    ];

    $mimeType = (new finfo(FILEINFO_MIME_TYPE))->file($tmpPath);
    $imageType = $imageInfo[2] ?? null;
    if (
        !is_string($mimeType)
        || !isset($allowedMimeTypes[$mimeType])
        || $allowedMimeTypes[$mimeType]['image_type'] !== $imageType
    ) {
        throw new ImageUploadException('Seules les images JPEG, PNG, GIF et WebP sont autorisées.');
    }

    $width = (int)($imageInfo[0] ?? 0);
    $height = (int)($imageInfo[1] ?? 0);
    if ($width <= 0 || $height <= 0 || ($width * $height) > adminMaxImagePixels()) {
        throw new ImageUploadException('Les dimensions de l\'image sont trop importantes.');
    }

    $extension = $allowedMimeTypes[$mimeType]['extension'];

    $uploadDir = __DIR__ . '/../../storage/uploads';
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
        throw new ImageUploadException('Le dossier de destination ne peut pas être créé.');
    }

    if (!is_writable($uploadDir)) {
        throw new ImageUploadException('Le dossier de destination n\'est pas accessible en écriture.');
    }

    $filename = 'upload_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
    $destination = $uploadDir . '/' . $filename;

    if (!move_uploaded_file($tmpPath, $destination)) {
        throw new ImageUploadException('L\'image n\'a pas pu être enregistrée.');
    }

    $data['image'] = 'uploads/' . $filename;
    $data['media_original_name'] = $file['name'] ?? $filename;
    $data['media_extension'] = $extension;
    $data['media_mime_type'] = $mimeType;
    $data['media_size_bytes'] = $actualSize;
    $data['media_width'] = $width;
    $data['media_height'] = $height;

    return $data;
}

function adminHandleImageUploadOrRedirect(array $data, string $redirectPath): array {
    try {
        return adminHandleImageUpload($data);
    } catch (ImageUploadException $exception) {
        $_SESSION['admin_error'] = $exception->getMessage();
        redirect_to($redirectPath);
    }
}

function admin() {
    requireAdmin();
    $adminError = adminConsumeError();
    $category = trim($_GET['category'] ?? '');
    $categories = getAllCategories();
    $peintures = $category !== '' ? getPeinturesByCategory($category) : getPeintures();
    require __DIR__ . '/../views/admin.php';
}

function adminAddPeinture(array $data) {
    requireAdmin();
    $data = adminHandleImageUploadOrRedirect($data, 'admin');
    $data['author_id'] = currentAdminId();
    addPeinture($data);
    redirect_to('admin');
}

function adminDeletePeinture(int $id) {
    requireAdmin();
    deletePeinture($id);
    redirect_to('admin');
}

function adminUpdatePeinture(array $data) {
    requireAdmin();
    $id = (int)($data['id'] ?? 0);
    $data = adminHandleImageUploadOrRedirect($data, $id > 0 ? 'admin?edit=' . $id : 'admin');
    $data['author_id'] = currentAdminId();
    if ($id) {
        updatePeinture($id, $data);
    }
    redirect_to('admin');
}

function adminCoutures() {
    requireAdmin();
    $adminError = adminConsumeError();
    $category = trim($_GET['category'] ?? '');
    $categories = getAllCoutureCategories();
    $coutures = $category !== '' ? getCouturesByCategory($category) : getCoutures();
    require __DIR__ . '/../views/admin_coutures.php';
}

function adminAddCouture(array $data) {
    requireAdmin();
    $data = adminHandleImageUploadOrRedirect($data, 'admin/coutures');
    $data['author_id'] = currentAdminId();
    addCouture($data);
    redirect_to('admin/coutures');
}

function adminDeleteCouture(int $id) {
    requireAdmin();
    deleteCouture($id);
    redirect_to('admin/coutures');
}

function adminUpdateCouture(array $data) {
    requireAdmin();
    $id = (int)($data['id'] ?? 0);
    $data = adminHandleImageUploadOrRedirect($data, $id > 0 ? 'admin/coutures?edit=' . $id : 'admin/coutures');
    $data['author_id'] = currentAdminId();
    if ($id) {
        updateCouture($id, $data);
    }
    redirect_to('admin/coutures');
}

function adminEvenements() {
    requireAdmin();
    $adminError = adminConsumeError();
    $eventYears = getEvenementYears();
    $requestedYear = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
    $selectedYear = in_array($requestedYear, $eventYears, true) ? $requestedYear : null;
    $evenements = $selectedYear !== null ? getEvenementsByYear($selectedYear) : getEvenements();
    require __DIR__ . '/../views/admin_evenements.php';
}

function adminAddEvenement(array $data) {
    requireAdmin();
    $data = adminHandleImageUploadOrRedirect($data, 'admin/evenements');
    $data['author_id'] = currentAdminId();
    addEvenement($data);
    redirect_to('admin/evenements');
}

function adminDeleteEvenement(int $id) {
    requireAdmin();
    deleteEvenement($id);
    redirect_to('admin/evenements');
}

function adminUpdateEvenement(array $data) {
    requireAdmin();
    $id = (int)($data['id'] ?? 0);
    $data = adminHandleImageUploadOrRedirect($data, $id > 0 ? 'admin/evenements?edit=' . $id : 'admin/evenements');
    $data['author_id'] = currentAdminId();
    if ($id) {
        updateEvenement($id, $data);
    }
    redirect_to('admin/evenements');
}
