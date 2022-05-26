<?php
session_start();
if($_SESSION['id']){
    $id = $_SESSION['id'];
    
}
else{
    $_SESSION['id']='';
    $id='';
}
?>

<!DOCTYPE html>

<head>
    <title>Mon compte</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="front/CSS/addfile.css" />
    <link rel="stylesheet" href="front/CSS/compte.css" />
    <link rel="stylesheet" href="front/CSS/style.css" />
    <link rel="stylesheet" href="front/CSS/upload.css">
    <script src="https://unpkg.com/eva-icons"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="front/JS/upload.js" defer></script>
</head>

<body>
    <header>
        <a id="lienHome" href="index.php">Home</a>
        <a id="upload" class="pointerOnHover"> Upload un fichier</a>
        <img src="front/images/logoLONGUEURBlanc.png" />
        <?php
        if($id!=''){
        ?>
        <a id="lienCompte" href="compte.php">Mon compte</a>
        <?php
        }
        else{
            ?>
        <a id="lienCompte" href="login.php">Connexion</a>
        <?php
            }
        ?>

    </header>
    <div id="drop-area">
        <div class="drop">

            <div class="center">
                <div>
                    <span>Upload</span>
                    <div class="circle">
                        <svg viewBox="0 0 92 92" fill="currentColor">
                            <path d="M46,80 C55.3966448,80 63.9029705,76.1880913 70.0569683,70.0262831 C76.2007441,63.8747097 80,55.3810367 80,46 C80,36.6003571 76.1856584,28.0916013 70.0203842,21.9371418 C63.8692805,15.7968278 55.3780386, 12 46, 12 C36.596754, 12 28.0850784,15.8172663 21.9300655,21.9867066 C15.7939108,28.1372443 12,36.6255645 12,46 C12,55.4035343 15.8175004,63.9154436 21.9872741,70.0705007 C28.1377665,76.2063225 36.6258528,80 46,80 Z"></path>
                        </svg>
                    </div>
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M5.2319,10.6401 C5.5859,11.0641 6.2159,11.1221 6.6399,10.7681 L10.9999,7.1351 L10.9999,19.0001 C10.9999,19.5521 11.4479,20.0001 11.9999,20.0001 C12.5519,20.0001 12.9999,19.5521 12.9999,19.0001 L12.9999,7.1351 L17.3599,10.7681 C17.7849,11.1221 18.4149,11.0641 18.7679,10.6401 C19.1219,10.2161 19.0649,9.5851 18.6399,9.2321 L12.6399,4.2321 C12.5929,4.1921 12.5369,4.1731 12.4849,4.1431 C12.4439,4.1191 12.4079,4.0911 12.3629,4.0731 C12.2459,4.0271 12.1239,4.0001 11.9999,4.0001 C11.8759,4.0001 11.7539,4.0271 11.6369,4.0731 C11.5919,4.0911 11.5559,4.1191 11.5149,4.1431 C11.4629,4.1731 11.4069,4.1921 11.3599,4.2321 L5.3599,9.2321 C4.9359,9.5851 4.8779,10.2161 5.2319,10.6401"></path>
                    </svg>
                </div>
            </div>
            <ul class="list"></ul>
            <button id="uploadButton">Upload</button>
            <div class="intro">
                <h4>Déposez ici</h4>
                <p>Drag &amp; Drop pour téléverser vos fichiers</p>
            </div>
            <div class="hint">Drop your files to upload</div>
        </div>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path fill="currentColor" fill-rule="evenodd" d="M0.879787868,0.0248590022 C0.741480414,0.0254663774 0.601464378,0.058308026 0.470823634,0.126854664 L0.470823634,0.126854664 C0.0390783178,0.353275488 -0.12560262,0.883253796 0.102996777,1.31071584 L0.102996777,1.31071584 C1.55958412,4.03509761 2.28748351,7.0237744 2.2870016,10.0124078 L2.2870016,10.0124078 C2.28748351,13.0010412 1.55958412,15.9897614 0.102996777,18.7140564 L0.102996777,18.7140564 C-0.12560262,19.1415618 0.0390783178,19.6716269 0.470823634,19.8979176 L0.470823634,19.8979176 C0.601771047,19.9666377 0.742356609,19.9995228 0.880970732,20 L0.880970732,20 L0.886666003,20 C1.20275352,19.9990889 1.50802002,19.8298482 1.66630473,19.5337093 L1.66630473,19.5337093 C3.25861475,16.5555748 4.05507643,13.2887202 4.05608406,10.021692 L4.05608406,10.021692 L4.05621549,10.021692 C4.05621549,10.0185683 4.05617168,10.0154881 4.05617168,10.0124078 L4.05617168,10.0124078 C4.05617168,10.0093275 4.05621549,10.0062039 4.05621549,10.0031236 L4.05621549,10.0031236 L4.05608406,10.0031236 C4.05507643,6.73605206 3.25861475,3.4691974 1.66630473,0.491106291 L1.66630473,0.491106291 C1.50828288,0.195531453 1.20362971,0.0263774403 0.888111725,0.0248590022 L0.888111725,0.0248590022 L0.879787868,0.0248590022 Z M5.53448867,2.19370933 C5.08316038,2.37887202 4.86888678,2.89119306 5.05577927,3.33804772 L5.05577927,3.33804772 C5.94419767,5.46195228 6.39504405,7.70438178 6.39587643,10.0031236 L6.39587643,10.0031236 L6.39583262,10.0031236 C6.39583262,10.0062039 6.39587643,10.0093275 6.39592024,10.0124078 L6.39592024,10.0124078 C6.39587643,10.0154881 6.39583262,10.0185683 6.39583262,10.021692 L6.39583262,10.021692 L6.39587643,10.021692 C6.39504405,12.3204338 5.94419767,14.5629067 5.05577927,16.6867679 L5.05577927,16.6867679 C4.86888678,17.1336659 5.08316038,17.645987 5.53448867,17.8311497 L5.53448867,17.8311497 C5.98572933,18.0160087 6.50316657,17.8039913 6.69010287,17.3570933 L6.69010287,17.3570933 C7.66863797,15.0176573 8.16482746,12.5475488 8.16482746,10.0153145 L8.16482746,10.0153145 C8.16482746,10.0143167 8.16478365,10.0134056 8.16478365,10.0124078 L8.16478365,10.0124078 C8.16478365,10.0114534 8.16482746,10.0104555 8.16482746,10.0095445 L8.16482746,10.0095445 C8.16482746,7.4773102 7.66863797,5.00711497 6.69010287,2.66776573 L6.69010287,2.66776573 C6.5490354,2.33041215 6.2195859,2.12689805 5.87248107,2.12689805 L5.87248107,2.12689805 C5.75975852,2.12689805 5.64515216,2.1483731 5.53448867,2.19370933 L5.53448867,2.19370933 Z M10.513338,4.60355748 C10.0383086,4.7164859 9.74570313,5.18932755 9.85978378,5.65969631 L9.85978378,5.65969631 C10.2050048,7.08347072 10.3773086,8.54793926 10.3770896,10.0124078 L10.3770896,10.0124078 C10.3773086,11.4768764 10.2050048,12.9413449 9.85978378,14.3651627 L9.85978378,14.3651627 C9.74570313,14.8355315 10.0383086,15.3083731 10.513338,15.4212581 L10.513338,15.4212581 C10.9882797,15.5341866 11.4657186,15.2444252 11.5797555,14.7740564 L11.5797555,14.7740564 C11.9566948,13.2195662 12.1451644,11.6206074 12.1456901,10.021692 L12.1456901,10.021692 L12.1458216,10.021692 C12.1458216,10.0185683 12.1457778,10.0154881 12.1457778,10.0124078 L12.1457778,10.0124078 C12.1457778,10.0093275 12.1458216,10.0062039 12.1458216,10.0031236 L12.1458216,10.0031236 L12.1456901,10.0031236 C12.1451644,8.40416486 11.9566948,6.80529284 11.5797555,5.25075922 L11.5797555,5.25075922 C11.4824102,4.84915401 11.1200157,4.5791757 10.7205582,4.57913232 L10.7205582,4.57913232 C10.6521712,4.57913232 10.5827765,4.5870282 10.513338,4.60355748 L10.513338,4.60355748 Z M14.7287582,7.15986985 C14.2709899,7.24555315 13.9538947,7.71154013 14.0220189,8.16793926 L14.0220189,8.16793926 C14.1130118,8.77739696 14.1555073,9.3905423 14.1501187,10.0031236 L14.1501187,10.0031236 C14.1501187,10.0062039 14.1500749,10.0093275 14.1501187,10.0124078 L14.1501187,10.0124078 C14.1500749,10.0154881 14.1501187,10.0185683 14.1501187,10.021692 L14.1501187,10.021692 C14.1555073,10.6343601 14.1130118,11.247462 14.0220189,11.8568764 L14.0220189,11.8568764 C13.9522738,12.3243384 14.2598622,12.77718 14.7287582,12.8649458 L14.7287582,12.8649458 C15.2247286,12.9578308 15.6948513,12.623731 15.7688022,12.134013 L15.7688022,12.134013 C15.8746028,11.432538 15.9246336,10.7268547 15.9192888,10.021692 L15.9192888,10.021692 C15.9193326,10.0185683 15.919245,10.0154881 15.9192888,10.0124078 L15.9192888,10.0124078 C15.919245,10.0093275 15.9193326,10.0062039 15.9192888,10.0031236 L15.9192888,10.0031236 C15.9246336,9.29796095 15.8746028,8.59227766 15.7688022,7.89084599 L15.7688022,7.89084599 C15.703219,7.45631236 15.3257102,7.14438178 14.8950601,7.14433839 L14.8950601,7.14433839 C14.8402979,7.14433839 14.7847033,7.14941432 14.7287582,7.15986985 L14.7287582,7.15986985 Z M17.6553387,10.021692 C17.6553387,10.5727549 18.1064917,11.0195228 18.6629634,11.0195228 L18.6629634,11.0195228 C19.2194352,11.0195228 19.6705882,10.5727549 19.6705882,10.021692 L19.6705882,10.021692 C19.6705882,9.47058568 19.2194352,9.02386117 18.6629634,9.02386117 L18.6629634,9.02386117 C18.1064917,9.02386117 17.6553387,9.47058568 17.6553387,10.021692 L17.6553387,10.021692 Z"></path>
        </symbol>
    </svg>

    <p id="result"></p>


    <select id="width_tmp_select">
        <option id="width_tmp_option"></option>
    </select>

    <?php
    // Connect to the database with mysqli
    $mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

    // Check for errors
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
    }

    // Get all tags
    $sql = "SELECT IDTag, NomTag FROM `tag`";
    $result = $mysqli->query($sql);

    echo "<div style='display:none' id='phpresult'>";

    // For each tag
    while ($row = $result->fetch_assoc()) {
        // Get the tag name
        $tagName = $row['NomTag'];

        // Get the tag ID
        $tagID = $row['IDTag'];

        // Print the result hidden in the DOM
        echo "" . $tagID . ":" . $tagName . ",";
    }

    echo "</div>";


    ?>

</body>