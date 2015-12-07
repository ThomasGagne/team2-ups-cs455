sudo rm noiseFactionDatabase.db
cat buildDatabase.sql | sudo sqlite3 noiseFactionDatabase.db
