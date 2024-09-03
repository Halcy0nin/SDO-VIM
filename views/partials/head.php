<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory Management System | DEPED</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-icons.css" rel="stylesheet">
    <link href="/globals.css" rel="stylesheet" />
    <link href="/css/overrides.css" rel="stylesheet" />
    <?php if (isset($page_styles) && is_array($page_styles)): ?>
        <?php foreach ($page_styles as $page_style): ?>
            <link href="<?php echo htmlspecialchars($page_style); ?>" rel="stylesheet" />
        <?php endforeach; ?>
    <?php endif; ?>
    <link rel="icon" type="image/png" href="<?php echo '/favicon.png'; ?>">
    <link href="/css/tailwind.output.css" rel="stylesheet">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="/js/chart.umd.js"></script>
</head>

<body class="relative flex w-dvw bg-[#EFEFEF]">