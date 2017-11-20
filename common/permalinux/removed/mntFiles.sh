[ -d /home/user/files ] && echo 'Directory found' || sudo mkdir -p /home/user/files

#echo "Enter Windows password"
#read -s pass
#sudo mount -t cifs -o username=mlerman,password=$pass,uid=mlerman,gid=users //mlerman-lap/files /home/user/files
sudo mount -t cifs -o username=mlerman,password=past33Z.,uid=mlerman,gid=users //mlerman-lap/files /home/user/files
read -p "Press [Enter] key to continue..."
