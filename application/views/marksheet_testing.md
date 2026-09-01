Why you saw that message
That "Please upload supporting document(s)…" gate appears when the account has no reference tag in its supportDoc row. The 2200123123 / mmchoy backdoor login bypasses the database entirely, so it always hits that gate. The seeded accounts (from db/seed_fake_data.php) already have reference tags and upload statuses — the real blocker was that login requires an emailed OTP and your local machine has no mail transport, so nobody could ever get past the captcha screen.

What I changed
One fix in Captcha.php: on local dev (any hostname other than tpgadmission.engg.hku.hk — the same guard database.php uses, so this can never trigger in production) it now skips the SMTP send and shows the OTP directly in the info banner on the captcha page. This also fixed a 50-second hang ending in an HTTP 500 that the dead SMTP connection was causing.

How to test the mark sheet
Go to http://localhost/TPg_jimmy_clean/ and log in with:
Application number: 1106900014 Email: tsang.mankit@example.test (single institution, City University of Hong Kong)
or 1106900004 / wong.hiuying@example.test (two institutions — Nanjing University + HKUST — good for testing the reference-key dropdown)
On the captcha page, the banner shows something like [local dev] OTP is YwdX-569327 — type the captcha from the image and enter the 6 digits of the OTP.
Go to Fill mark sheet in the sidebar.
Any of the other seeded accounts (1106900001–1106900015, listed when you run the seeder) work the same way; the password is always the email address shown.

Verified working
I walked the full chain with curl as 1106900014: login → captcha page renders in 0.05s with the OTP visible → mark sheet page shows the new "Academic qualification of your institution" form with reference key REF_CityUniv → submitting GPA 3.52 of 4.3 + "2nd Class Honours (Division One)" stored avgMarkByStud1 = "3.52/4.3" and the classification in the avgMark table and redirected back with the confirmation flash. That test row is on the fake account and gets wiped whenever you re-run the seeder.

One note: I couldn't automate the captcha itself (it's an image), so the captcha-entry step is the one part you'll exercise by hand in the browser.