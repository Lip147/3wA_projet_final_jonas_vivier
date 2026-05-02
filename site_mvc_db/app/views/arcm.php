<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARCM</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Georgia, "Times New Roman", serif;
            background: #111;
        }

        .arcm-intro {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
            background-image: linear-gradient(rgba(0, 0, 0, 0.08), rgba(0, 0, 0, 0.08)), url("/site_mvc_db/public/images/arcm-bg.jpg");
            background-position: center;
            background-size: cover;
        }

        .arcm-title {
            margin: 0;
            color: #fff;
            font-size: clamp(4rem, 11vw, 12rem);
            font-weight: 400;
            line-height: 0.95;
            text-align: center;
            transform: translateY(-4rem);
        }

        .arcm-enter {
            position: absolute;
            top: 73%;
            left: 50%;
            transform: translate(-50%, -50%);
            min-width: 64px;
            padding: 12px 17px;
            border: 1px solid rgba(255, 255, 255, 0.7);
            color: #fff;
            text-align: center;
            text-decoration: none;
            font-size: 0.9rem;
            line-height: 1;
            background: rgba(0, 0, 0, 0.06);
            transition: border-color 0.2s ease, background 0.2s ease;
        }

        .arcm-enter:hover,
        .arcm-enter:focus {
            border-color: #fff;
            background: rgba(0, 0, 0, 0.22);
            outline: none;
        }

        @media (max-width: 700px) {
            .arcm-intro {
                background-position: center;
            }

            .arcm-enter {
                top: 70%;
            }

            .arcm-title {
                font-size: clamp(2.7rem, 15vw, 5rem);
                white-space: normal;
            }
        }
    </style>
</head>
<body>
    <main class="arcm-intro">
        <h1 class="arcm-title">Annie<br>Roger-Chamoulaud</h1>
        <a class="arcm-enter" href="/site_mvc_db/public/home">Entrer</a>
    </main>
</body>
</html>
