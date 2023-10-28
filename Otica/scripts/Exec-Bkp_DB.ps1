$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
$backupName = "backup"

# Use o caminho correto para o mysqldump.exe
$mysqlDumpPath = "C:\wamp64\bin\mysql\mysql8.0.31\bin\mysqldump.exe"
$databaseName = "db_otica"
$outputPath = "C:\temp\$backupName_$timestamp.sql"

# Comando para executar o mysqldump
$command = "$mysqlDumpPath -u root -p --default-character-set=utf8mb4 $databaseName > $outputPath"
Invoke-Expression $command
