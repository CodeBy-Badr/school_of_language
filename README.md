# École des Langues - Site Web Professionnel

Un site web moderne et professionnel pour une école de langue, créé avec **HTML5**, **CSS3**, **JavaScript ES6** et **PHP**.

## 🌟 Caractéristiques

### Frontend
- ✅ Design responsive (mobile, tablette, desktop)
- ✅ Navigation fluide avec menu hamburger pour mobile
- ✅ Section Hero attractive avec statistiques animées
- ✅ 6 sections de services avec cartes interactives
- ✅ Présentation des cours avec tarification
- ✅ Section témoignages avec évaluations
- ✅ Formulaire de contact avec validation
- ✅ Footer complet avec informations et liens sociaux
- ✅ Animations d'entrée avec IntersectionObserver
- ✅ Couleurs professionnelles (bleu primary, accents dorés)

### Backend
- ✅ Système d'envoi d'email PHP
- ✅ Validation et sanitization complètes
- ✅ Protection contre le spam
- ✅ Rate limiting (5 requêtes par minute)
- ✅ Emails HTML formatés
- ✅ Confirmation à l'utilisateur
- ✅ Système de logging
- ✅ Gestion d'erreurs robuste

## 📁 Structure des Fichiers

```
ecoles des langues/
├── index.html                 # Page d'accueil principale
├── css/
│   └── style.css             # Styles CSS3 complets
├── js/
│   └── script.js             # JavaScript ES6
├── php/
│   ├── send-email.php        # Serveur d'envoi d'emails
│   └── logs.txt              # Fichier de logs (créé automatiquement)
└── README.md                  # Ce fichier
```

## 🚀 Installation & Déploiement

### Prérequis
- Serveur Web (Apache, Nginx, etc.)
- PHP 7.4+ avec fonction `mail()` activée
- Accès à la configuration du serveur

### Étapes d'Installation

1. **Télécharger les fichiers**
   - Téléchargez tous les fichiers du projet

2. **Uploader sur le serveur**
   - Via FTP/SFTP, téléchargez tous les fichiers vers votre serveur
   - Exemple: `/public_html/` ou `/var/www/html/`

3. **Configurer l'email dans PHP**
   - Ouvrez `php/send-email.php`
   - Modifiez les variables de configuration (lignes 14-18):
     ```php
     $ADMIN_EMAIL = 'votre-email@domaine.com';
     $SCHOOL_NAME = 'Nom de votre école';
     $SCHOOL_PHONE = '0x xx xx xx xx';
     $SCHOOL_ADDRESS = 'Votre adresse complète';
     ```

4. **Vérifier les permissions**
   - Assurez-vous que le dossier `php/` a les permissions d'écriture (755)
   - Le dossier `php/logs/` sera créé automatiquement

5. **Tester le site**
   - Accédez à votre site via le navigateur
   - Testez le formulaire de contact

## ⚙️ Configuration du Serveur Mail

### Avec Apache (Linux)
```bash
# Installer Postfix (si pas déjà installé)
sudo apt-get install postfix

# Redémarrer Apache
sudo systemctl restart apache2
```

### Avec Nginx (Linux)
```bash
# Installer Postfix
sudo apt-get install postfix

# Configurer Postfix comme serveur mail local
sudo postfix start
```

### Avec un Service d'Email Tiers (Recommandé)
Si votre serveur n'a pas de serveur mail configuré:

1. **Utiliser Gmail SMTP** (option gratuite)
   - Modifiez `send-email.php` pour utiliser PHPMailer
   - Voir section PHPMailer ci-dessous

2. **Utiliser Mailgun, SendGrid, Amazon SES**, etc.
   - Services payants mais très fiables

### Intégration PHPMailer (Optional - Recommandé)

Si vous voulez une meilleure fiabilité d'email, utilisez PHPMailer:

```php
<?php
// Installation: composer require phpmailer/phpmailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuration SMTP Gmail
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'votre-email@gmail.com';
    $mail->Password = 'votre-mot-de-passe-app';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    
    // Email
    $mail->setFrom('contact@votresite.com');
    $mail->addAddress($email);
    $mail->Subject = 'Confirmation de contact';
    $mail->isHTML(true);
    $mail->Body = $message;
    
    $mail->send();
} catch (Exception $e) {
    echo "Erreur: {$mail->ErrorInfo}";
}
?>
```

## 🎨 Personnalisation

### Modifier les Couleurs
Ouvrez `css/style.css` et modifiez les variables CSS (lignes 1-10):

```css
:root {
    --primary-color: #2563eb;      /* Bleu - couleur principale */
    --secondary-color: #1e40af;    /* Bleu foncé */
    --accent-color: #f59e0b;       /* Doré/Orange - accents */
    --light-bg: #f3f4f6;           /* Gris clair - arrière-plans */
    --dark-text: #1f2937;          /* Gris foncé - texte principal */
    --light-text: #6b7280;         /* Gris - texte secondaire */
}
```

### Modifier le Contenu
- **Textes**: Éditez directement dans `index.html`
- **Cours**: Modifiez la section `<!-- Courses Section -->`
- **Services**: Modifiez la section `<!-- Services Section -->`
- **Témoignages**: Ajoutez vos propres témoignages

### Ajouter des Images
1. Créez un dossier `images/`
2. Ajoutez vos images là-bas
3. Utilisez les chemins relatifs dans HTML:
```html
<img src="images/votre-image.jpg" alt="Description">
```

## 🔒 Sécurité

### Points de Sécurité Implémentés
✅ Validation des emails `filter_var()`
✅ Sanitization avec `htmlspecialchars()`
✅ Protection contre l'injection SQL (FormData)
✅ Protection contre le spam (mots-clés)
✅ Rate limiting (5 requêtes/minute)
✅ Logs de toutes les tentatives
✅ HTTPS recommandé

### Recommandations Supplémentaires
1. **Utilisez HTTPS**
   - Installez un certificat SSL/TLS
   - Forcez la redirection HTTP → HTTPS

2. **Validez côté serveur** (déjà fait)

3. **Protégez votre email**
   - Ne publiez pas votre email directement dans le HTML
   - Utilisez PHP pour l'afficher dynamiquement

4. **Mettez à jour PHP**
   - Assurez-vous d'avoir la dernière version

5. **Sauvegardez régulièrement**
   - Faites des sauvegardes automatiques

## 📱 Responsivité

Le site est entièrement responsive avec points de rupture:
- **Mobile**: < 480px
- **Tablette**: 480px - 768px
- **Desktop**: > 768px

## 🌐 Navigateurs Supportés

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

## 📊 Performance

### Optimisations Appliquées
- CSS minifiable pour production
- JavaScript modulaire et léger
- IntersectionObserver pour animations au scroll
- Images optimisées recommandées
- Lazy loading possible avec images

### Conseils d'Optimisation
1. Minifiez CSS/JS en production
2. Compressez les images (TinyPNG, ImageOptim)
3. Utilisez un CDN pour Font Awesome
4. Activez la compression GZIP sur le serveur
5. Mettez en cache les ressources statiques

## 📝 Fonctionnalités JavaScript

### Navigation Mobile
```javascript
// Menu hamburger automatique sur mobile
// Fermeture au clic sur un lien
```

### Formulaire de Contact
```javascript
// Validation complète côté client
// Messages d'erreur/succès
// Réinitialisation automatique après envoi
// Redirection au formulaire depuis les cartes de cours
```

### Animations
```javascript
// Compteurs de statistiques animées
// Apparition au scroll des cartes (IntersectionObserver)
// Smooth scrolling pour les liens d'ancre
```

## 🐛 Dépannage

### Le formulaire n'envoie pas d'emails
1. Vérifiez que `php/send-email.php` est accessible
2. Vérifiez la configuration du serveur mail
3. Vérifiez les logs dans `php/logs.txt`
4. Testez avec `mail()` directement

### Le site ne charge pas le CSS/JS
1. Vérifiez les chemins des fichiers
2. Vérifiez les permissions de lecture des fichiers
3. Vérifiez la console du navigateur (F12) pour les erreurs

### Erreurs de validation du formulaire
1. Les messages s'affichent sous le bouton "Envoyer"
2. Assurez-vous que les données respectent les critères
3. Vérifiez `send-email.php` pour les règles de validation

## 👨‍💼 Support Client

Pour un vrai client, fournissez:
1. **Documentation complète** (ce fichier)
2. **Identifiants FTP/SSH**
3. **Identifiants base de données** (si applicable)
4. **Contact technique** pour support
5. **Plan de maintenance** (mises à jour, sauvegardes)

## 📄 Fichiers de Configuration Recommandés

### .htaccess (pour Apache)
```apache
# Forcer HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Gzip compression
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>

# Cache static files
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/jpg "access plus 1 year"
  ExpiresByType image/gif "access plus 1 year"
  ExpiresByType image/png "access plus 1 year"
  ExpiresByType text/css "access plus 1 month"
  ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

### robots.txt
```
User-agent: *
Allow: /
Disallow: /php/logs.txt
```

## 📞 Contact & Support

**Pour les client:**
- Email: contact@langues-pro.com
- Téléphone: +33 (0)1 23 45 67 89
- Adresse: 123 Rue de la Paix, 75000 Paris, France

## 📜 Licence

Ce projet est créé sur mesure pour votre école de langue.

---

**Version**: 1.0  
**Dernière mise à jour**: Février 2026  
**Créé avec**: HTML5, CSS3, JavaScript ES6, PHP 7.4+
