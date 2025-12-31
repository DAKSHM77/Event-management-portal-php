<?php
require_once '../app/views/layouts/student_header.php';
require_once '../app/controllers/StudentController.php';

$student = new StudentController();
$regId = $_GET['id'] ?? 0;
$ticket = $student->getTicketDetails($regId);

if (!$ticket) {
    echo "<div class='alert alert-danger'>Ticket not found or access denied.</div>";
    require_once '../app/views/layouts/student_footer.php';
    exit;
}
?>

<style>
    .ticket-card {
        border: 2px solid #ddd;
        border-radius: 25px;
        /* Curved as requested globally */
        background: #fff;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .ticket-header {
        background: #333;
        padding: 20px;
        color: #fff;
        text-align: center;
        border-bottom: 1px solid #eee;
    }

    .ticket-body {
        padding: 40px;
        text-align: center;
    }

    .ticket-separator {
        margin: 20px 0;
        border-top: 2px dashed #eee;
        padding: 20px 0;
    }

    .ticket-qr {
        background: #f9f9f9;
        padding: 20px;
        display: inline-block;
        border-radius: 15px;
        border: 1px solid #eee;
    }

    .ticket-footer {
        background: #f4f4f4;
        padding: 15px;
        text-align: center;
        color: #888;
        font-size: 12px;
        border-top: 1px solid #eee;
    }

    /* DARK MODE - MONOCHROME GLASS */
    body.dark-aesthetic .ticket-card {
        background: rgba(255, 255, 255, 0.05);
        /* Glass */
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    }

    body.dark-aesthetic .ticket-header {
        background: rgba(255, 255, 255, 0.05);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    body.dark-aesthetic .ticket-body h2 {
        color: #fff !important;
    }

    body.dark-aesthetic .ticket-separator {
        border-top: 2px dashed rgba(255, 255, 255, 0.2);
    }

    body.dark-aesthetic strong {
        color: #fff !important;
    }

    body.dark-aesthetic small {
        color: #ccc !important;
    }

    body.dark-aesthetic .ticket-qr {
        background: #fff;
        /* QR needs white background to be scannable */
        border: 5px solid rgba(255, 255, 255, 0.1);
    }

    body.dark-aesthetic .ticket-qr p {
        color: #000 !important;
        /* Text below QR */
    }

    body.dark-aesthetic .ticket-footer {
        background: rgba(0, 0, 0, 0.2);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: #aaa;
    }

    /* Print Button */
    .btn-print {
        background: #333;
        color: #fff;
        border: none;
        padding: 15px 30px;
        border-radius: 50px;
        font-weight: 700;
        transition: all 0.3s;
    }

    body.dark-aesthetic .btn-print {
        background: #fff;
        color: #000;
    }

    body.dark-aesthetic .btn-print:hover {
        background: #ddd;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.4);
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="ticket-card">
                <div class="ticket-header">
                    <h3 style="margin:0; text-transform: uppercase; letter-spacing: 2px;">Event Ticket</h3>
                    <small>Registration ID: #<?php echo $ticket['registration_id']; ?></small>
                </div>

                <div class="ticket-body">
                    <h2 style="margin-top: 0;"><?php echo htmlspecialchars($ticket['title']); ?></h2>

                    <div class="ticket-separator">
                        <div class="row">
                            <div class="col-xs-6 text-left">
                                <p><small>ATTENDEE</small><br><strong><?php echo htmlspecialchars($ticket['user_name']); ?></strong>
                                </p>
                            </div>
                            <div class="col-xs-6 text-right">
                                <p><small>DATE</small><br><strong><?php echo date('M d, Y', strtotime($ticket['start_date'])); ?></strong>
                                </p>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-xs-6 text-left">
                                <p><small>VENUE</small><br><strong><?php echo htmlspecialchars($ticket['venue']); ?></strong>
                                </p>
                            </div>
                            <div class="col-xs-6 text-right">
                                <p><small>TIME</small><br><strong><?php echo date('h:i A', strtotime($ticket['start_time'])); ?></strong>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- QR Code -->
                    <div class="ticket-qr">
                        <?php
                        $qrData = "TICKET:" . $ticket['ticket_code'] . "|EVENT:" . $ticket['event_id'];
                        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($qrData);
                        ?>
                        <img src="<?php echo $qrUrl; ?>" alt="QR Code" width="150" height="150">
                        <p
                            style="margin-top: 10px; font-family: monospace; font-size: 16px; font-weight: bold; color: #555; margin-bottom: 0;">
                            <?php echo $ticket['ticket_code']; ?>
                        </p>
                    </div>
                </div>

                <div class="ticket-footer">
                    Please present this QR code at the entrance.<br>
                    &copy; <?php echo APP_NAME; ?>
                </div>
            </div>

            <br>
            <div class="text-center">
                <button onclick="window.print()" class="btn btn-print"><i class="fa fa-print"></i> Print
                    Ticket</button>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/layouts/student_footer.php'; ?>