<?php
session_start();

require_once __DIR__ . '/classes/actions.class.php';

$actionClass = new Actions();

/*
|--------------------------------------------------------------------------
| Page Handling (SECURE)
|--------------------------------------------------------------------------
| Only allow specific pages to be loaded.
| Add new page names to this array when you create them.
*/

$allowed_pages = [
    'home',
    'about',
    'contact',
    'dashboard'
];

$page = $_GET['page'] ?? 'home';

// Remove dangerous characters
$page = preg_replace('/[^a-z_]/', '', $page);

// Fallback if page not allowed or file doesn't exist
if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}

$page_file = __DIR__ . "/pages/{$page}.php";
$page_title = ucwords(str_replace("_", " ", $page));

if (!file_exists($page_file)) {
    $page_file = __DIR__ . "/pages/home.php";
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once __DIR__ . '/inc/header.php'; ?>
<body>

<?php include_once __DIR__ . '/inc/navigation.php'; ?>

<div class="container-md py-3">

    <?php if (isset($_SESSION['flashdata']) && !empty($_SESSION['flashdata'])): ?>
        <div class="flashdata flashdata-<?= htmlspecialchars($_SESSION['flashdata']['type'] ?? 'default') ?> mb-3">
            <div class="d-flex w-100 align-items-center flex-wrap">
                <div class="col-11">
                    <?= htmlspecialchars($_SESSION['flashdata']['msg'] ?? '') ?>
                </div>
                <div class="col-1 text-center">
                    <a href="javascript:void(0)" onclick="this.closest('.flashdata').remove()" class="flashdata-close">
                        <i class="far fa-times-circle"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['flashdata']); ?>
    <?php endif; ?>

    <div class="main-wrapper">
        <?php include $page_file; ?>
    </div>

</div>

<?php include_once __DIR__ . '/inc/footer.php'; ?>

</body>
</html>