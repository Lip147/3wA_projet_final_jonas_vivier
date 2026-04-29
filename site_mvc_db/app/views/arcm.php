<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARCM - Artiste</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body, html {
            height: 100%;
            width: 100%;
            overflow: hidden;
        }
        
        .intro-page {
            position: relative;
            width: 100vw;
            height: 100vh;
            background-image: url('/site_mvc_db/public/images/arcm-bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .intro-page::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
        }
        
        .content {
            position: relative;
            z-index: 1;
            text-align: center;
        }
        
        .title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 4rem;
            color: #fff;
            margin-bottom: 3rem;
            letter-spacing: 0.5rem;
            text-transform: uppercase;
        }
        
        .enter-btn {
            display: inline-block;
            padding: 1.2rem 4rem;
            border: 2px solid #fff;
            color: #fff;
            text-decoration: none;
            font-family: 'Lato', Arial, sans-serif;
            font-size: 1.2rem;
            letter-spacing: 0.3rem;
            text-transform: uppercase;
            transition: all 0.4s ease;
            background: transparent;
            cursor: pointer;
        }
        
        .enter-btn:hover {
            background: #fff;
            color: #1a1a1a;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400&display=swap" rel="stylesheet">
</head>
<body>
    <div class="intro-page">
        <div class="content">
            <h1 class="title">ARCM</h1>
            <a href="/site_mvc_db/public/home" class="enter-btn">Entrer</a>
        </div>
    </div>
</body>
</html>