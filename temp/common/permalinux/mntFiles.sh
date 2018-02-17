[ -d /home/user/files ] && echo 'Directory found' || sudo mkdir -p /home/user/files

echo "Enter Windows password"
read -s pass

sudo mount -t cifs -o username=mlerman,password=$pass,uid=mlerman,gid=users //laptop-7kqrmtc0/files /home/user/files
read -p "Press [Enter] key to continue..."
