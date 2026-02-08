# 📋 CHECKLIST DE DÉPLOIEMENT

Ce document liste toutes les étapes pour déployer le site sur votre serveur de production.

## ✅ PRE-DEPLOYMENT CHECKLIST

### 1. Vérification du Contenu
- [ ] Tous les textes sont en français correct et sans erreurs
- [ ] Les informations de contact sont à jour
- [ ] Les images ont été optimisées
- [ ] Les logos et images de marque sont en place
- [ ] Les liens de médias sociaux pointent vers les bonnes pages
- [ ] Les prix des cours sont corrects

### 2. Vérification Technique
- [ ] Tous les fichiers CSS/JS se chargent correctement en développement
- [ ] Le site s'affiche correctement sur mobile (testé sur différentes tailles)
- [ ] Le formulaire de contact valide les entrées correctement
- [ ] Les liens d'ancre (navigation) fonctionnent
- [ ] Les animations se comportent correctement
- [ ] Aucune erreur JavaScript dans la console (F12)

### 3. Vérification Sécurité
- [ ] Les adresses email n'incluent pas vos vrais contacts (à remplacer avant déploiement)
- [ ] Les fichiers sensibles (php/logs.txt, config.txt) ne sont pas accessibles au public
- [ ] Les chemins des fichiers n'exposent pas la structure du serveur
- [ ] Aucun commentaire avec informations sensibles dans le code

## 🚀 ÉTAPES DE DÉPLOIEMENT

### Étape 1: Préparation du Serveur

#### Si vous utilisez Apache:
```bash
# SSH dans votre serveur (ou via FTP)
ssh votre-utilisateur@votre-domaine.com

# Naviguer au répertoire public_html
cd ~/public_html

# Vérifier que PHP est installé
php -v

# Vérifier que la fonction mail() est activée
php -r "echo (bool)ini_get('SMTP') ? 'OK' : 'Mail not configured';"
```

#### Si vous utilisez Nginx:
```bash
# Vérifier nginx
nginx -t

# Redémarrer nginx
sudo systemctl restart nginx
```

### Étape 2: Upload des Fichiers

#### Via FTP/SFTP (FileZilla, Cyberduck):
1. Se connecter au serveur
2. Naviguer au répertoire `/public_html/` ou `/www/`
3. Uploader TOUS les fichiers:
   - index.html
   - css/ (dossier complet)
   - js/ (dossier complet)
   - php/ (dossier complet)
   - images/ (si applicable)
   - .htaccess
   - robots.txt
   - config.txt (optionnel, pour votre référence)

#### Via Git (Recommandé pour les mises à jour):
```bash
cd ~/public_html
git init
git add .
git commit -m "Initial commit - Language School Website"
git remote add origin https://votre-repo.git
git push -u origin main
```

#### Via SCP:
```bash
scp -r ./* utilisateur@serveur:/public_html/
```

### Étape 3: Configuration des Fichiers

#### A. Configuration du PHP
```bash
# Vérifier les permissions
chmod 755 ~/public_html
chmod 755 ~/public_html/php
chmod 755 ~/public_html/css
chmod 755 ~/public_html/js

# Créer le dossier de logs s'il n'existe pas
mkdir -p ~/public_html/php/logs
chmod 777 ~/public_html/php/logs
```

#### B. Configuration du .htaccess (Apache)
```bash
# Activer mod_rewrite si nécessaire
a2enmod rewrite
a2enmod deflate
a2enmod headers

# Redémarrer Apache
sudo systemctl restart apache2
```

#### C. Modifier les Configurations
Via FTP ou SSH:
1. Ouvrir `php/send-email.php`
2. Modifier les 4 variables de configuration (lignes 14-18):
   ```php
   $ADMIN_EMAIL = 'votre-email@domaine.com';
   $SCHOOL_NAME = 'Votre Nom d\'École';
   $SCHOOL_PHONE = '0x xx xx xx xx';
   $SCHOOL_ADDRESS = 'Votre adresse';
   ```

### Étape 4: Configuration SSL/HTTPS

#### Avec Let's Encrypt (Gratuit):
```bash
# Via cPanel (automatic)
ou

# Via command line
sudo apt-get install certbot python3-certbot-apache
sudo certbot certonly --apache -d votre-domaine.com -d www.votre-domaine.com
sudo systemctl restart apache2
```

#### Forcer HTTPS:
Le .htaccess inclut déjà la redirection HTTPS.

### Étape 5: Configuration de l'Envoi d'Emails

#### Option 1: Serveur Mail Local (Simple)
```bash
# Vérifier que Postfix est installé
sudo apt-get install postfix

# Le traitement du mail PHP devrait fonctionner
```

#### Option 2: SMTP via Gmail (Recommandé - Plus Fiable)

Modifier `php/send-email.php` pour utiliser PHPMailer:

```bash
# Installer via Composer
composer require phpmailer/phpmailer

# Puis utiliser la configuration SMTP dans le fichier
```

#### Option 3: Service d'Email Tiers (SendGrid, Mailgun)

Signer pour un service d'email professionnel et configurer l'API.

### Étape 6: Tests Post-Déploiement

#### A. Tester l'Accès au Site
```bash
# Vérifier que le site est accessible
curl https://votre-domaine.com/

# Vérifier le redirection HTTP → HTTPS
curl -I http://votre-domaine.com/
```

#### B. Tester le Formulaire de Contact
1. Ouvrir le site dans le navigateur
2. Aller à la section Contact
3. Remplir le formulaire avec des données de test
4. Cliquer sur "Envoyer le Message"
5. Vérifier que l'email est reçu

#### C. Vérifier la Console du Navigateur
1. Ouvrir le site
2. Appuyer sur F12 (ou Right-click > Inspect)
3. Aller à l'onglet "Console"
4. Vérifier qu'il n'y a pas d'erreurs rouges

#### D. Tester sur Mobile
1. Ouvrir le site sur un téléphone
2. Vérifier que le menu est responsive
3. Tester le formulaire sur mobile

#### E. Performance
```bash
# Tester la vitesse du site
curl -w "@curl-format.txt" -o /dev/null -s https://votre-domaine.com/

# Ou utiliser: https://pagespeed.web.dev/
```

### Étape 7: Sauvegardes

#### Sauvegarde Automatique Recommandée
```bash
# Créer un script de sauvegarde hebdomadaire
crontab -e

# Ajouter cette ligne pour une sauvegarde hebdomadaire
0 2 * * 0 /home/user/backup.sh
```

Créer `backup.sh`:
```bash
#!/bin/bash
BACKUP_DIR="/home/user/backups"
DATE=$(date +%Y%m%d_%H%M%S)
tar -czf $BACKUP_DIR/website_$DATE.tar.gz ~/public_html/
```

### Étape 8: Monitoring & Logs

#### Vérifier les Erreurs PHP
```bash
# Voir les dernières erreurs PHP
tail -f /var/log/apache2/error.log
tail -f /var/log/php-fpm/error.log (pour Nginx+PHP-FPM)
```

#### Voir les Tentatives d'Accès au Site
```bash
tail -f /var/log/apache2/access.log
```

#### Vérifier les Logs du Formulaire
```bash
# Voir les logs d'envoi de formulaire
tail -f ~/public_html/php/logs.txt
```

## 📊 POST-DEPLOYMENT SETUP

### 1. DNS Configuration
- [ ] Pointez votre domaine vers l'IP du serveur via votre registraire
- [ ] Attendez la propagation DNS (jusqu'à 48 heures)
- [ ] Vérifiez avec: `nslookup votre-domaine.com`

### 2. Email Configuration
- [ ] Configurez SPF record
- [ ] Configurez DKIM record
- [ ] Configurez DMARC record

Exemple SPF:
```
v=spf1 mx include:sendgrid.net ~all
```

### 3. Google Search Console
- [ ] Créer un compte
- [ ] Vérifier la propriété du domaine
- [ ] Soumettre le sitemap: `https://votre-domaine.com/sitemap.xml`
- [ ] Vérifier les erreurs d'indexation

### 4. Google Analytics
- [ ] Créer un compte Google Analytics
- [ ] Ajouter le code GA à `index.html`:
```html
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX');
</script>
```

### 5. Google My Business
- [ ] Créer/Mettre à jour profil Google
- [ ] Ajouter les informations de contact
- [ ] Ajouter des photos

## 🔧 TROUBLESHOOTING

### Le site ne charge pas
- [ ] Vérifier que les fichiers ont bien été uploadés
- [ ] Vérifier les permissions (755)
- [ ] Vérifier les logs Apache/Nginx

### Les emails ne s'envoient pas
```bash
# Vérifier la configuration du mail
php -r "echo ini_get('sendmail_path');"

# Tester l'envoi d'email directement
php -r "mail('test@test.com', 'Test', 'Test message');"

# Vérifier les logs
tail -f /var/log/mail.log
```

### CSS/JS ne se charge pas
- [ ] Vérifier les chemins (utiliser le développeur du navigateur)
- [ ] Vérifier les permissions de fichier
- [ ] Vider le cache du navigateur (Ctrl+Shift+Del)
- [ ] Vérifier le Content-Type dans les headers

### Le formulaire ne valide pas
- [ ] Vérifier la console JavaScript (F12)
- [ ] Vérifier que le fichier JavaScript est chargé
- [ ] Tester directement: `php php/send-email.php` (via terminal)

## 📈 MAINTENANCE CONTINUE

### Hebdomadaire
- [ ] Vérifier les logs de formulaire
- [ ] Vérifier les emails de contactant
- [ ] Vérifier que le site fonctionne

### Mensuelle
- [ ] Faire une sauvegarde complète
- [ ] Vérifier les mises à jour de sécurité
- [ ] Analyser le trafic avec Google Analytics

### Trimestrique
- [ ] Mettre à jour PHP si nécessaire
- [ ] Mettre à jour les bibliothèques JavaScript
- [ ] Vérifier la performance du site

## 🔐 SÉCURITÉ CONTINUE

- [ ] Gardez PHP à jour
- [ ] Gardez le serveur à jour
- [ ] Exécutez des scans de sécurité réguliers
- [ ] Sauvegardez régulièrement
- [ ] Surveillez les tentatives de connexion

## ✅ FINAL CHECKLIST

- [ ] Site accessible en HTTPS
- [ ] Formulaire envoie des emails
- [ ] Menu fonctionne sur mobile
- [ ] Pas d'erreurs JavaScript
- [ ] Certificat SSL valide
- [ ] Sauvegardes en place
- [ ] Analytics configuré
- [ ] Google Search Console configuré
- [ ] Plan de maintenance en place

---

**Vous avez besoin d'aide?** Contactez votre hébergeur ou, consultez la documentation jointe.
