$mysqlDumpPath = "C:\wamp64\bin\mysql\mysql8.0.31\bin\mysqldump.exe"
$databaseName = "db_otica"
$outputPath = "C:\temp\$backupName_$timestamp.sql"

# Comando para executar o mysqldump com codificação UTF-8
$command = "$mysqlDumpPath -u root -p --default-character-set=utf8 $databaseName > $outputPath"
Invoke-Expression $command
