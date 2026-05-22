<!doctype html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PILAR - Manager Teknisi Portal</title>
  
  <script src="/_sdk/element_sdk.js"></script>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Caveat:wght@500;600;700&display=swap" rel="stylesheet">
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            kf: {
              sky: '#A5D8FF', skyDeep: '#74C0FC', blush: '#FFD6D6', blushDeep: '#FFB3B3',
              cream: '#FFF8F0', mint: '#D3F9D8', mintDeep: '#8CE99A', lavender: '#E8D5F5',
              sand: '#FFF3E0', dark: '#2B3A4A', muted: '#6B7F94', light: '#F0F7FF',
            }
          },
          fontFamily: {
            sans: ['Poppins', 'sans-serif'], script: ['Caveat', 'cursive'],
          }
        }
      }
    }
  </script>
  
  <link rel="stylesheet" href="../../../assets/css/manager_teknisi/style.css">
</head>
<body class="h-full bg-kf-cream overflow-hidden">
  
  <?php 
  // Otomatis terpasang di semua halaman kerja manager
  include __DIR__ . '/mobile-header.php'; 
  ?>

  <div id="app" class="h-full w-full overflow-auto">