# Configurações do banco de dados
$usuario = "root"
$senha = ""
$banco = "db_otica"

# Caminho para o mysqldump
$mysqldumpPath = "C:\wamp64\bin\mysql\mysql8.0.31\bin\mysqldump.exe"

# Diretório de destino do backup
$backupDirectory = "C:\temp"

# Nome do arquivo de backup
$backupFileName = "backup_$(Get-Date -f 'yyyy-MM-dd_HH-mm-ss').sql"

# Comando mysqldump
$command = "$mysqldumpPath -u=$usuario --password=$senha --databases $banco > $backupDirectory\$backupFileName"

# Execute o comando
try {
    Invoke-Expression -Command $command
    Write-Host "Backup do banco de dados $banco foi criado com sucesso em $backupDirectory\$backupFileName"
} catch {
    Write-Host "Erro ao criar o backup: $_"
}

# mysqldump -u seu_usuario -p nome_do_banco > caminho\para\backup.sql

