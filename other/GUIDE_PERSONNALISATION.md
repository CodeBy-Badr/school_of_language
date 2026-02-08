# 🎨 GUIDE DE PERSONNALISATION RAPIDE

Ce guide vous aidera à personnaliser rapidement le site de votre école de langue.

## 📝 Modifications Essentielles

### 1. Informations de l'École

**Fichier à modifier**: `index.html`

Cherchez et remplacez ces sections:

```html
<!-- DANS LA SECTION CONTACT (À ENVIRON LA LIGNE 350) -->
<div>
    <h4>Adresse</h4>
    <p>123 Rue de la Paix<br>75000 Paris, France</p>  <!-- MODIFIEZ ICI -->
</div>

<div>
    <h4>Téléphone</h4>
    <p>+33 (0)1 23 45 67 89</p>  <!-- MODIFIEZ ICI -->
</div>

<div>
    <h4>Email</h4>
    <p>contact@langues-pro.com</p>  <!-- MODIFIEZ ICI -->
</div>

<!-- FOOTER (VERS LA FIN) -->
<p>&copy; 2026 École des Langues. Tous droits réservés.</p>  <!-- MODIFIEZ LE NOM -->
```

### 2. Configuration des Emails

**Fichier à modifier**: `php/send-email.php`

Allez aux lignes 14-18 et remplacez:

```php
$ADMIN_EMAIL = 'contact@langues-pro.com';      // ← VOTRE EMAIL
$SCHOOL_NAME = 'École des Langues';             // ← NOM DE VOTRE ÉCOLE
$SCHOOL_PHONE = '+33 (0)1 23 45 67 89';        // ← VOTRE TÉLÉPHONE
$SCHOOL_ADDRESS = '123 Rue de la Paix, ...';   // ← VOTRE ADRESSE
```

### 3. Changer les Couleurs

**Fichier à modifier**: `css/style.css`

Allez aux lignes 1-10 et modifiez les variables CSS:

```css
:root {
    --primary-color: #2563eb;      /* ← Couleur principale (Bleu) */
    --secondary-color: #1e40af;    /* ← Couleur secondaire (Bleu foncé) */
    --accent-color: #f59e0b;       /* ← Couleur accent (Doré) */
}
```

**Palette de couleurs populaires:**
- Bleu professionnel: `#1e3a8a, #3b82f6, #0ea5e9`
- Vert confiance: `#10b981, #059669, #047857`
- Violet moderne: `#8b5cf6, #a78bfa, #7c3aed`
- Orange énergique: `#f97316, #fb923c, #fdba74`

### 4. Modifier les Statistiques

**Fichier**: `index.html` (Section HERO)

Cherchez et modifiez:

```html
<h3>5000+</h3>
<p>Étudiants Satisfaits</p>

<h3>15+</h3>
<p>Langues Enseignées</p>

<h3>98%</h3>
<p>Taux de Satisfaction</p>
```

### 5. Ajouter/Modifier les Services

**Fichier**: `index.html` (Section SERVICES)

Modèle à dupliquer:

```html
<div class="service-card">
    <div class="service-icon">
        <i class="fas fa-video"></i>  <!-- ICÔNE FONTAWESOME -->
    </div>
    <h3>Cours en Ligne</h3>  <!-- TITRE -->
    <p>Apprenez à votre rythme...</p>  <!-- DESCRIPTION -->
</div>
```

**Icônes FontAwesome disponibles:**
- `fa-video` - Vidéo
- `fa-users` - Groupe
- `fa-microphone` - Son
- `fa-certificate` - Certification
- `fa-book` - Livre
- `fa-headset` - Support
- `fa-globe` - Monde
- `fa-laptop` - Ordinateur
- Voir: https://fontawesome.com/icons

### 6. Modifier les Cours

**Fichier**: `index.html` (Section COURS)

Modèle à dupliquer:

```html
<div class="course-card featured">  <!-- featured = à la une -->
    <div class="course-level">Débutant</div>  <!-- NIVEAU -->
    <h3>Anglais Niveau 1</h3>  <!-- TITRE -->
    <p>Apprenez les fondations...</p>  <!-- DESCRIPTION -->
    <div class="course-info">
        <span><i class="fas fa-clock"></i> 8 semaines</span>  <!-- DURÉE -->
        <span><i class="fas fa-users"></i> 15+ étudiants</span>
    </div>
    <div class="course-price">
        <span class="price">49€</span>  <!-- PRIX -->
        <span class="duration">/mois</span>
    </div>
    <button class="btn btn-primary btn-small">S'inscrire</button>
</div>
```

### 7. Ajouter des Témoignages

**Fichier**: `index.html` (Section TEMOIGNAGES)

Modèle à dupliquer:

```html
<div class="testimonial-card">
    <div class="stars">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
    </div>
    <p class="testimonial-text">
        "J'ai fait d'énormes progrès en seulement 3 mois..."
    </p>
    <div class="testimonial-author">
        <div class="author-avatar">
            <i class="fas fa-user-circle"></i>
        </div>
        <div>
            <h4>Marie Dupont</h4>  <!-- NOM -->
            <p>Étudiante - Cours d'Anglais</p>  <!-- TITRE -->
        </div>
    </div>
</div>
```

### 8. Ajouter un Logo

1. Créez un dossier `images/`
2. Ajoutez votre logo: `images/logo.png`
3. Modifiez dans `index.html` (Navigation):

```html
<div class="logo">
    <img src="images/logo.png" alt="Logo" style="height: 40px;">
    <span>Votre École</span>
</div>
```

### 9. Ajouter des Images de Cours

1. Créez un dossier `images/courses/`
2. Ajoutez vos images
3. Modifiez chaque carte de cours:

```html
<div class="course-card">
    <img src="images/courses/anglais.jpg" alt="Cours d'Anglais" style="width: 100%; height: 200px; object-fit: cover;">
    <!-- Reste du contenu -->
</div>
```

## 🌐 Modifier les Liens Sociaux

**Fichier**: `index.html` (FOOTER)

```html
<a href="https://facebook.com/votre-page" class="social-link">
    <i class="fab fa-facebook"></i>
</a>
<a href="https://twitter.com/votre-compte" class="social-link">
    <i class="fab fa-twitter"></i>
</a>
<a href="https://instagram.com/votre-compte" class="social-link">
    <i class="fab fa-instagram"></i>
</a>
<a href="https://linkedin.com/company/votre-entreprise" class="social-link">
    <i class="fab fa-linkedin"></i>
</a>
```

## 📱 Ajouter un Numéro WhatsApp

Dans le formulaire ou en bas de page:

```html
<a href="https://wa.me/33612345678" class="btn btn-primary" target="_blank">
    <i class="fab fa-whatsapp"></i> Contacter sur WhatsApp
</a>
```

## 🎯 Personnalisation du Formulaire

**Ajouter/Modifier les Options de Sujet:**

Fichier: `index.html` (SESSION CONTACT)

```html
<select id="subject" required>
    <option value="">Sélectionnez un sujet</option>
    <option value="inscription">Inscription à un cours</option>
    <option value="information">Information générale</option>
    <option value="entreprise">Solutions entreprise</option>
    <option value="autre">Autre</option>
    <!-- AJOUTEZ D'AUTRES OPTIONS ICI -->
</select>
```

## 🎨 Palette de Couleurs Complète

Pour un changement de thème complet, utilisez l'une de ces palettes:

### Bleu Technologie
```css
--primary-color: #0066cc;
--secondary-color: #004399;
--accent-color: #ff9900;
```

### Vert Confiance
```css
--primary-color: #059669;
--secondary-color: #047857;
--accent-color: #fbbf24;
```

### Violet Moderne
```css
--primary-color: #7c3aed;
--secondary-color: #6d28d9;
--accent-color: #fbbf24;
```

### Orange Énergique
```css
--primary-color: #f97316;
--secondary-color: #ea580c;
--accent-color: #22c55e;
```

## 📋 Checklist de Personnalisation

- [ ] Email de contact changé dans `index.html` ET `php/send-email.php`
- [ ] Téléphone et adresse mises à jour
- [ ] Nom de l'école personnalisé partout
- [ ] Couleurs adaptées au branding de l'école
- [ ] Services modifiés selon votre offre
- [ ] Cours ajoutés avec tarifs corrects
- [ ] Témoignages remplacés
- [ ] Logo uploadé (optionnel)
- [ ] Liens sociaux configurés
- [ ] Formulaire testé (test d'envoi d'email)
- [ ] Site préviewé sur mobile

## 🔍 Endroits Clés à Modifier

1. **index.html** - Contenu principal
2. **php/send-email.php** - Configuration emails (lignes 14-18)
3. **css/style.css** - Couleurs et design (lignes 1-10)
4. **.htaccess** - Configuration serveur (Apache)

## ⚡ Conseils Rapides

- Utilisez un éditeur HTML comme VS Code
- Testez chaque modification dans le navigateur (F5 pour rafraîchir)
- Utilisez Ctrl+F pour chercher et remplacer du texte
- Sauvegardez régulièrement vos fichiers
- Faites une copie de sauvegarde avant de modifier

## 🚀 Prochaines Étapes

1. Installez le site sur votre serveur web
2. Testez le formulaire avec une vraie adresse email
3. Configurez un domaine personnalisé
4. Ajoutez un certificat SSL (HTTPS)
5. Optimisez les images de votre contenu
6. Activez Google Analytics
7. Soumettez le sitemap à Google Search Console

## 📖 Ressources Utiles

- **FontAwesome Icons**: https://fontawesome.com/icons
- **Color Picker**: https://colorpicker.com/
- **Image Optimizer**: https://tinypng.com/
- **HTML/CSS Reference**: https://developer.mozilla.org/

---

**Besoin d'aide?** Consultez votre développeur ou consultez la documentation jointe.
