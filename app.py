#from flask import Flask, render_template, request, redirect, url_for, flash
import csv, os
from datetime import datetime

#app = Flask(__name__)
#app.secret_key = "super-secret-key"

@app.route("/", methods=["GET","POST"])
def payment():
    message = None
    if request.method == "POST":
        name = request.form.get("name","").strip()
        amount = request.form.get("amount","").strip()
        utr = request.form.get("utr","").strip()
        note = request.form.get("note","").strip()

        os.makedirs("data", exist_ok=True)
        path = os.path.join("data","payments.csv")
        new_file = not os.path.exists(path)
        with open(path, "a", newline="", encoding="utf-8") as f:
            writer = csv.writer(f)
            if new_file:
                writer.writerow(["timestamp","name","amount","utr","note"])
            writer.writerow([datetime.now().isoformat(), name, amount, utr, note])
        message = "✅ Payment details submitted. We'll verify soon."
    return render_template("payment.html", message=message)

if __name__ == "__main__":
    app.run(debug=True)
