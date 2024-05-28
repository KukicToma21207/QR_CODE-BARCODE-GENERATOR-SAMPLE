<?php

/**
 * QR Code generator is a simple app to generate QR Code image from a given string
 */

//Start session before doing anything else
session_start();

// Setup session security
if (empty($_SESSION['check'])) {
    $_SESSION['check'] = md5(rand(0, 1000) * time());
}

use App\Http\Controllers\barcode_generator;

require_once("barcode.php");

if (
    !empty($_GET['src']) && // If this is a call from the image then go in to this
    (!empty($_SESSION['check']) && !empty($_GET['check'] && $_SESSION['check'] == $_GET['check'])) //Also we need to check if session security is valid
) {

    //Create required barcode class and generate qrcode
    $qrGen = new barcode_generator();
    $qrGen->output_image($_GET['type'], $_GET['qr'], $_GET['src'], ["wq" => $_GET['border'], "sf" => $_GET['size']]);

    exit; //We do not need to go further because this is just call from the image
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <style>
        input, select, button {
            padding: 5px;
        }
        
        section.main {
            display: grid;
            justify-content: space-evenly;
            justify-items: center;
            width: 80%;
        }

        .wrapper {
            display: grid;
            margin-top: 20px;
        }

        .form_part {
            display: grid;
            grid-template-columns: 1fr 3fr;
            padding: 5px;
            gap: 30px;
        }

        .result_container {
            border: 2px solid black;
            width: fit-content;
            padding: 5px;
        }

        .result_label {
            padding: 10px 20px;
            font-weight: 700;
            font-size: 16px;
        }
    </style>

    <script>
        function generate() {
            let endUrl = "./index.php?";
            let value = document.getElementById("value").value;
            let size = document.getElementById("size").value;
            let type = document.getElementById("type").value;
            let qr = document.getElementById("qr").value;
            let border = document.getElementById("border").value;
            let check = "<?php echo $_SESSION['check']; ?>";

            if (value.trim() == "") {
                alert("You must enter valid value for QR code.");
                return;
            }

            endUrl += "src=" + value + "&size=" + size + "&type=" + type + "&check=" + check + "&qr=" + qr + "&border=" + border;
            document.getElementById("result_image").src = endUrl;
        }
    </script>

    <section class="main">
        <div class="wrapper">
            <h1 class="headline">Generate QR Code</h1>
        </div>

        <div class="wrapper">

            <div class="form_part">
                <label for="value">Enter QR code value*</label>
                <input type="text" name="" placeholder="Number, Text, URL, etc." id="value">
            </div>

            <div class="form_part">
                <label for="size">Select QR code type</label>
                <select name="" id="qr">
                    <option value='upca'>UPC a</option>
                    <option value='upce'>UPC e</option>
                    <option value='ean13nopad'>EAN 13 no pad</option>
                    <option value='ean13pad'>EAN 13 pad</option>
                    <option value='ean13'>EAN 13</option>
                    <option value='ean8'>EAN 8</option>
                    <option value='code39'>CODE 39</option>
                    <option value='code39ascii'>CODE 39 ASCII</option>
                    <option value='code93'>CODE 93</option>
                    <option value='code93ascii'>CODE 93 ASCII</option>
                    <option value='code128'>CODE 128</option>
                    <option value='code128a'>CODE 128 a</option>
                    <option value='code128b'>CODE 128 b</option>
                    <option value='code128c'>CODE 128 c</option>
                    <option value='code128ac'>CODE 128 ac</option>
                    <option value='code128bc'>CODE 128 bc</option>
                    <option value='ean128'>EAN 128</option>
                    <option value='ean128a'>EAN 128 a</option>
                    <option value='ean128b'>EAN 128 b</option>
                    <option value='ean128c'>EAN 128 c</option>
                    <option value='ean128ac'>EAN 128 ac</option>
                    <option value='ean128bc'>EAN 128 bc</option>
                    <option value='codabar'>COD a bar</option>
                    <option value='itf'>ITF</option>
                    <option value='itf14'>ITF 14</option>
                    <option value='qr' selected>QR (default)</option>
                    <option value='qrl'>QR l</option>
                    <option value='qrm'>QR m</option>
                    <option value='qrq'>QR q</option>
                    <option value='qrh'>QR h</option>
                    <option value='dmtx'>DMTX (Data matrix)</option>
                    <option value='dmtxs'>DMTX s</option>
                    <option value='dmtxr'>DMTX r</option>
                    <option value='gs1dmtx'>GS1 DMTX</option>
                    <option value='gs1dmtxs'>GS1 DMTX s</option>
                    <option value='gs1dmtxr'>GS1 DMTX r</option>
                </select>
            </div>

            <div class="form_part">
                <label for="size">Select QR code size</label>
                <select name="" id="size">
                    <option value="3">Small</option>
                    <option value="10" selected>Medium</option>
                    <option value="20">Large</option>
                </select>
            </div>

            <div class="form_part">
                <label for="size">Select border size</label>
                <select name="" id="border">
                    <option value="0">0</option>
                    <option value="1" selected>1 (default)</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div>

            <div class="form_part">
                <label for="type">Select image result type</label>
                <select name="" id="type">
                    <option value="svg" selected>SVG</option>
                    <option value="png">PNG</option>
                    <option value="jpg">JPG</option>
                </select>
            </div>

            <div class="form_part">
                <div>* Value is required</div>
                <button onclick="generate();">Generate</button>
            </div>

        </div>

        <div class="wrapper">
            <h2 class="result_label">Result:</h2>
            <div class="result_container">
                <img src="#" alt="Rendered Image" id="result_image">
            </div>
        </div>
    </section>
</body>

</html>