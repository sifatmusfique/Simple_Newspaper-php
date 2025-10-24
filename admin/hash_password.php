<?php


$new_password = 'admin@1234';

$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

echo "Your new password hash is:<br><br>";

echo htmlspecialchars($hashed_password);
?>
```

# Instructions to Update Admin Password in Database
**Action:**
1.  Open your browser and navigate to the new file: `http:
2.  You will see a long string of text on the page. **Copy this entire string.** It is your new, secure password hash.
3.  Go back to phpMyAdmin (`http:
4.  Click on your `rajshahi_chronicle_db` database, and then click on the **"SQL"** tab.
5.  In the text box, paste the following SQL command, **replacing the placeholder text** with the new hash you just copied from your browser.

```sql
UPDATE `users` SET `password` = 'PASTE_THE_NEW_HASH_HERE' WHERE `username` = 'admin';

