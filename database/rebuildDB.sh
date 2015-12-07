sudo rm noiseFactionDatabase.db
cat buildDatabase.sql | sudo sqlite3 noiseFactionDatabase.db
sudo chown apache noiseFactionDatabase.db
sudo chgrp apache noiseFactionDatabase.db
