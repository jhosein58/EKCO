<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>Debugger</title>
    <base href="assets/">
    <link rel="stylesheet" href="highlight/styles/tokyo-night-dark.css">
    <script src="highlight/highlight.min.js"></script>
    <script src="highlight/highlight-line.js"></script>
    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: Arial,serif;
            direction: ltr;
        }
        html, body{
            width: 100%;
            height: 100%;
            background-color: black;
        }
        .all {
            width: 100%;
            height: 100%;
            background: linear-gradient(70deg, rgba(55, 16, 16, 0.8), #000000);
            position: relative;
        }
        .container {
            background-color: #232323;
            width: calc(100% - 64px);
            height: calc(100% - 64px);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            overflow-x: scroll;
            overflow-y: scroll;
            border-radius: 16px;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.5);

        }
        .col{
            /*background: linear-gradient(90deg, transparent, transparent, rgba(0, 0, 0, 0.5));*/
            background-color: rgba(0, 0, 0, 0.2);
            padding: 24px;
            border-radius: 8px;
            margin: 12px;
        }
        .title{
            padding: 24px;
            border-radius: 8px;
            margin: 12px;
            width: 80%;
        }
        h1{
            color: #efd632;
            text-shadow: 0 0 20px rgba(255, 232, 82, 0.2);
            font-size: 38px;
            font-weight: bold;
        }
        h2 {
            color: #ff3636;
            font-size: 24px;
            font-weight: bold;
        }
        h3{
            color: #ffffff;
            font-size: 24px;
            margin-bottom: 12px;
        }
        p{
            color: #e4e4e4;
            font-size: 18px;
        }
        .t1 {
            color: rgba(54, 255, 178, 0.57);
        }
        .language-php{
            margin: 12px;
            border-radius: 8px;
        }
        code{
            overflow-x: hidden !important;
            white-space: pre-wrap;
        }
        pre{
            white-space: pre-wrap;
            overflow-x: hidden !important;
        }

    </style>
</head>
<body>
<div class="all">
    <div class="container">
        <div class="title">
            <h1>
                Debugger
            </h1>
        </div>
        <div class="col">
            <h2>
                Error Message
            </h2>
            <br>
            <p>
                <?php echo $_SESSION['error_details']['title']; ?>
            </p>
            <p>
                <span class="t1"><?php echo $_SESSION['error_details']['debug'][0]['file']; ?></span> in Line <?php echo $_SESSION['error_details']['debug'][0]['line']; ?>
            </p>
        </div>
        <pre><code class="language-php"><?php echo htmlentities($_SESSION['error_details']['code']); ?></code></pre>
        <div class="col">
            <h3>
                Log File :
            </h3>
            <br>
            <pre style="color: white"><?php echo file_get_contents(path('engine/log.txt')); ?></pre>
        </div>
    </div>

</div>
</body>
<script>
    hljs.highlightAll();
    hljs.initHighlightLinesOnLoad([
        [{start: <?php  echo $_SESSION['error_details']['real_line'];  ?>, end: <?php  echo $_SESSION['error_details']['real_line'];  ?>, color: '#330000'},],
    ]);
</script>
</html>