<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Analog</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    
    <style>

   .btn-number {
    background-color: #f8f9fa; /* Light gray for numbers */
    color: #212529;
    }

   .btn-number:hover {
    background-color: #e9ecef;
    }

    .btn-operator {
    background-color: #ffc107;
    color: #212529;
    }

    .btn-operator:hover {
        background-color: #ffcd39;
    }

    .btn-clear, .btn-clear-history {
        background-color: #dc3545; 
        color: #fff;
        border: none;
        border-radius: 5px;
        height: 40px;
    }

    .btn-clear:hover, .btn-clear-history:hover {
        background-color: #c82333;
    }

    body.dark-mode .btn-operator {
        background-color: #ffc107;
        color: #212529;
    }
    body.dark-mode .btn-clear, body.dark-mode .btn-clear-history {
        background-color: #c82333;
    }
    </style>

</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['display'] ?? '';
    $button = $_POST['button'] ?? '';
    $history = $_POST['history'] ?? '';

    if (isset($_POST['clear_history'])) {
        $history = '';
    } elseif ($button === 'C') {
        $current = '';
    } elseif ($button === '=') {
        try {
            $result = eval("return $current;");
            $history .= $current . ' = ' . $result . PHP_EOL;
            $current = $result;
        } catch (Exception $e) {
            $current = 'Error';
        }
    } else {
        $current .= $button;
    }

    echo "<script>
    document.getElementById('display').value = '$current';
    document.getElementsByName('history')[0].value = `$history`;
    </script>";
    
}
?>
    <div class="container mt-5">     
        <div class="calculator bg-light">
            <div class="card">
                <div class="text-end mb-1">
                    <label class="form-check-label me-0 col-form-label-sm">Thema</label>
                    <div class="form-check form-switch d-inline-block">
                        <input class="form-check-input" type="checkbox" id="themeToggle">
                    </div>
                </div>
                <div class="card-header text-center bg-primary text-white">
                    <h4>Kalkulator Analog</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type="text" class="form-control mb-3 display" name="display" id="display" readonly
                               value="<?= htmlspecialchars($current ?? '') ?>">
                        <div class="row g-2 mb-3">
                            <?php
                            $buttons = [
                                ['7', '8', '9', '/'],
                                ['4', '5', '6', '*'],
                                ['1', '2', '3', '-'],
                                ['0', 'C', '=', '+']
                            ];
                            foreach ($buttons as $row) {
                                foreach ($row as $btn) {
                                    $class = is_numeric($btn) ? 'btn-number' : ($btn === 'C' || $btn === '=' ? 'btn-clear' : 'btn-operator');
                                    echo '<div class="col-3">';
                                    echo '<button type="submit" name="button" value="' . $btn . '" class="btn ' . $class . ' w-100">' . $btn . '</button>';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                        <textarea class="form-control mb-3" name="history" rows="5" readonly><?= htmlspecialchars($history ?? '') ?></textarea>
                        <button type="submit" name="clear_history" class="btn-clear-history w-100">Clear History</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <script src="htps://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>

