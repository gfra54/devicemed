echo 'Mot de passe : b4fEp6D6'
rsync --verbose --human-readable -a --include "*/" --include="*.jpg" --include="*.jpeg" --include="*.png" --include="*.gif" --exclude="*" devicemedr@ftp.cluster007.ovh.net:/homez.208/devicemedr/data/uploads/ /home/sopress/dev/devicemed/wp-content/uploads/ 
