<?php
/**
 * Local dev-only "department actions" for the journey test account
 * (1106900016 / journey.tester@example.test, seeded by seed_fake_data.php).
 *
 * The applicant can drive every stage of the flow themselves except the two
 * transitions that only the department makes. This script performs them:
 *
 *   php db/advance_fake_journey.php show      current state of the account
 *   php db/advance_fake_journey.php offer     issue an offer (reply slip stage)
 *   php db/advance_fake_journey.php payment   request payment proof (payment stage)
 *                                             - run AFTER accepting the offer
 *   php db/advance_fake_journey.php reset     wipe progress, restart the journey
 *
 * Touches only appNo 1106900016. Safe to re-run any action.
 *
 * For quick client demos there is an easier tool: sign in via
 * http://localhost/TPg_jimmy_clean/demo/login (account 1106900014, no
 * captcha/OTP) and use the floating DEMO bar to jump between stages
 * instantly. This CLI script is for walking the journey "for real" on the
 * fully fresh account 1106900016 instead.
 */

$APPNO = 1106900016;

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'mysql';
$dbName = 'tpgFront';

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
    fwrite(STDERR, "DB connection failed: " . $mysqli->connect_error . "\n");
    exit(1);
}
$mysqli->set_charset('utf8mb4');

function q($mysqli, $sql) {
    if (!$mysqli->query($sql)) {
        fwrite(STDERR, "Query failed: " . $mysqli->error . "\nSQL: $sql\n");
        exit(1);
    }
    return $mysqli;
}

$action = $argv[1] ?? 'show';
$now = date('Y-m-d H:i:s');

$app = $mysqli->query("SELECT appNo, status, appStatus, mediaSurvey, statusMsg FROM application WHERE appNo = $APPNO")->fetch_assoc();
if (!$app) {
    fwrite(STDERR, "Journey account $APPNO not found - run the seeder first:\n  php db/seed_fake_data.php\n");
    exit(1);
}

switch ($action) {

case 'show':
    $offer = $mysqli->query("SELECT replyStatus, recommendation, issueDate, deadline, replyDate, signature FROM offerReply WHERE appNo = $APPNO")->fetch_assoc();
    $doc = $mysqli->query("SELECT fileStatus FROM supportDoc WHERE appNo = $APPNO")->fetch_assoc();
    $uploaded = $doc ? substr_count($doc['fileStatus'], 'U') + substr_count($doc['fileStatus'], 'R') : 0;
    echo "Journey account $APPNO / journey.tester@example.test\n";
    echo "  account status : {$app['status']}   appStatus: {$app['appStatus']}\n";
    echo "  survey taken   : " . ($app['mediaSurvey'] === 'Y' ? 'yes' : 'no (first login pending)') . "\n";
    echo "  docs uploaded  : $uploaded item(s)\n";
    if ($offer) {
        $stageMap = ['X' => 'offer issued - waiting for reply (reply-slip page)',
                     'Y' => 'offer accepted - run `payment` to open the payment stage',
                     'P' => 'payment requested (payment page)',
                     'Q' => 'payment proof uploaded - journey complete',
                     'N' => 'offer declined - journey complete'];
        echo "  offer          : replyStatus {$offer['replyStatus']} - " . ($stageMap[$offer['replyStatus']] ?? '?') . "\n";
        echo "                   recommendation {$offer['recommendation']}, deadline {$offer['deadline']}, replied: " . ($offer['replyDate'] ?: '-') . "\n";
    } else {
        echo "  offer          : none - account is in the upload stage (run `offer` when ready)\n";
    }
    break;

case 'offer':
    q($mysqli, "DELETE FROM offerReply WHERE appNo = $APPNO");
    $issue = date('Y-m-d');
    $deadline = date('Y-m-d', strtotime('+14 days'));
    // recommendation 'C' (conditional): acceptance requires uploading the
    // payment slip inside the reply form - the fullest exercise of the page.
    q($mysqli, "INSERT INTO offerReply
        (appNo, replyStatus, currCode, appName, studyMode, acadPlanCode, issueDate, deadline, replyDate,
         provisional, recommendation, signature, admYear, isLocal)
        VALUES ($APPNO, 'X', 9001, 'JOURNEY Tester', 'F', '9T001M', '$issue', '$deadline', NULL,
                'N', 'C', NULL, 2026, 'N')");
    q($mysqli, "UPDATE application SET appStatus = 'O',
        statusMsg = 'Congratulations! An offer of admission has been issued.<br/><br/>As of $now,<br/>Please log in to review and reply to your offer before the deadline.<br/>'
        WHERE appNo = $APPNO");
    echo "Offer issued (conditional, deadline $deadline).\n";
    echo "Log in again as 1106900016 - you will be taken to the reply-slip page.\n";
    echo "Use db/fake_payment_slip.jpg for the payment-slip upload when accepting.\n";
    break;

case 'payment':
    $offer = $mysqli->query("SELECT replyStatus FROM offerReply WHERE appNo = $APPNO")->fetch_assoc();
    if (!$offer) {
        fwrite(STDERR, "No offer on the account yet - run `offer` first.\n");
        exit(1);
    }
    if ($offer['replyStatus'] === 'X') {
        echo "Note: the offer has not been accepted yet (replyStatus X).\n";
        echo "Setting it to P anyway - the payment page will open on next login.\n";
    }
    q($mysqli, "UPDATE offerReply SET replyStatus = 'P' WHERE appNo = $APPNO");
    q($mysqli, "UPDATE application SET appStatus = 'S',
        statusMsg = 'You have accepted your offer. Update is shown below:<br/><br/>As of $now,<br/>Please upload your payment slip to confirm your place.<br/>'
        WHERE appNo = $APPNO");
    echo "Payment proof requested (replyStatus P).\n";
    echo "Log in again as 1106900016 - you will be taken to the payment page.\n";
    echo "Use db/fake_payment_slip.jpg for the upload.\n";
    break;

case 'reset':
    q($mysqli, "DELETE FROM offerReply WHERE appNo = $APPNO");
    q($mysqli, "DELETE FROM rsUpload   WHERE appNo = $APPNO");
    q($mysqli, "DELETE FROM avgMark    WHERE appNo = $APPNO");
    q($mysqli, "DELETE FROM supportDocReview  WHERE appNo = $APPNO");
    q($mysqli, "DELETE FROM supportDocHistory WHERE appNo = $APPNO");
    q($mysqli, "UPDATE application SET appStatus = 'C', mediaSurvey = 'N', statusMsg = '' WHERE appNo = $APPNO");
    // fresh all-'N' fileStatus (nothing uploaded), same shape the seeder builds
    q($mysqli, "UPDATE supportDoc SET fileStatus = REPEAT('N', LENGTH(fileStatus)) WHERE appNo = $APPNO");
    $uploadDir = __DIR__ . '/../uploads/' . $APPNO;
    if (is_dir($uploadDir)) {
        foreach (glob($uploadDir . '/*') as $f) if (is_file($f)) unlink($f);
        rmdir($uploadDir);
        echo "Removed uploaded files in uploads/$APPNO.\n";
    }
    echo "Journey account reset - next login starts from the first-login flow again.\n";
    break;

default:
    fwrite(STDERR, "Unknown action '$action'. Use: show | offer | payment | reset\n");
    exit(1);
}

$mysqli->close();
