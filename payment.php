<?php
$file = __DIR__ . "/payments.csv";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name   = trim($_POST["name"] ?? "");
    $amount = trim($_POST["amount"] ?? "");
    $utr    = trim($_POST["utr"] ?? "");
    $note   = trim($_POST["note"] ?? "");
    $time   = date("Y-m-d H:i:s");

    $row = [$time, $name, $amount, $utr, $note];
    $fp = fopen($file, "a");
    if (filesize($file) === 0) {
        fputcsv($fp, ["timestamp", "name", "amount", "utr", "note"]);
    }
    fputcsv($fp, $row);
    fclose($fp);

    $message = "✅ Payment details submitted. We'll verify soon.";
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>UPI Payment — Ecommerit</title>
  <style>
    body{font-family:sans-serif;background:#f7f9fb;margin:0;padding:20px;}
    .card{background:#fff;border-radius:10px;padding:20px;max-width:500px;margin:0 auto;box-shadow:0 4px 12px rgba(0,0,0,.08);}
    input,button{width:100%;padding:10px;margin:6px 0;border-radius:6px;border:1px solid #ddd;}
    button{background:#16a34a;color:#fff;border:none;font-weight:bold;cursor:pointer;}
    .msg{padding:10px;background:#e7fbe7;color:#066d06;border-radius:6px;margin-bottom:12px;}
  </style>
</head>
<body>
  <div class="card">
    <h2>UPI Payment — Ecommerit</h2>
    <p>UPI ID: <strong>ecommerit@airtel</strong></p>
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=upi://pay?pa=ecommerit@airtel&pn=Ecommerit&cu=INR" alt="UPI QR">
    <?php if (!empty($message)) echo "<div class='msg'>$message</div>"; ?>
    <h3>Submit Payment Details</h3>
    <form method="post">
      <input type="text" name="name" placeholder="Your Name" required>
      <input type="number" name="amount" placeholder="Amount Paid (₹)" required>
      <input type="text" name="utr" placeholder="UTR / Transaction ID" required>
      <input type="text" name="note" placeholder="Note (Optional)">
      <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>
