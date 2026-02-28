# ⚡ Quick Reference - VIGILANCE-COS Premium

Référence rapide pour développer avec le nouveau design system.

---

## 🚀 Commandes

```bash
# Compiler les assets (production)
npm run build

# Mode développement avec watch
npm run dev

# Lancer le serveur Laravel
php artisan serve

# Migrations
php artisan migrate

# Nettoyer le cache
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

---

## 📐 Structure de Page

### Template de Base
```php
@extends('layouts.premium')

@section('title', 'Titre de la Page')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Titre Principal</h1>
            <p class="text-sm text-gray-400 mt-1">Description</p>
        </div>
        <a href="#" class="inline-flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-medium">
            <i class="ph-bold ph-plus-circle"></i>
            <span>Action</span>
        </a>
    </div>
@endsection

@section('content')
    <!-- Votre contenu -->
@endsection
```

---

## 🎨 Snippets de Composants

### Card Simple
```php
<x-premium.card title="Mon Titre" icon="ph-users">
    Contenu
</x-premium.card>
```

### Card avec Actions
```php
<x-premium.card title="Titre" icon="ph-users">
    <x-slot name="actions">
        <button class="text-sm text-primary-400">Voir tout</button>
    </x-slot>

    Contenu
</x-premium.card>
```

### Stat Card
```php
<div class="glass-effect rounded-2xl p-6 border border-navy-800/50">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase">Label</p>
            <h3 class="text-3xl font-bold text-white mt-2">150</h3>
        </div>
        <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-blue-600/20 rounded-xl flex items-center justify-center">
            <i class="ph-bold ph-users text-blue-400 text-2xl"></i>
        </div>
    </div>
</div>
```

### Badges
```php
<!-- Success -->
<x-premium.badge type="success" icon="ph-check-circle">Actif</x-premium.badge>

<!-- Danger -->
<x-premium.badge type="danger" icon="ph-warning">Urgent</x-premium.badge>

<!-- Warning -->
<x-premium.badge type="warning" icon="ph-clock">En attente</x-premium.badge>

<!-- Info -->
<x-premium.badge type="info" icon="ph-info">Info</x-premium.badge>

<!-- Primary -->
<x-premium.badge type="primary" icon="ph-star">Premium</x-premium.badge>

<!-- Inactive -->
<x-premium.badge type="inactive" icon="ph-x">Inactif</x-premium.badge>
```

### Buttons
```php
<!-- Primary Large -->
<x-premium.button type="primary" size="lg" icon="ph-plus-circle">
    Ajouter
</x-premium.button>

<!-- Danger Medium -->
<x-premium.button type="danger" size="md" icon="ph-trash">
    Supprimer
</x-premium.button>

<!-- Outline Small -->
<x-premium.button type="outline" size="sm">
    Annuler
</x-premium.button>

<!-- Ghost -->
<x-premium.button type="ghost" icon="ph-download" iconPosition="right">
    Télécharger
</x-premium.button>
```

### Inputs
```php
<!-- Input Texte -->
<x-premium.input
    label="Nom complet"
    name="nom"
    icon="ph-user"
    placeholder="Ex: Mohamed DIOP"
    required
    :error="$errors->first('nom')"
    :value="old('nom')"
/>

<!-- Input Email -->
<x-premium.input
    label="Email"
    name="email"
    type="email"
    icon="ph-envelope"
    placeholder="email@example.com"
    :error="$errors->first('email')"
/>

<!-- Input Numérique -->
<x-premium.input
    label="Salaire"
    name="salaire"
    type="number"
    icon="ph-currency-circle-dollar"
    placeholder="150000"
/>

<!-- Input Date -->
<x-premium.input
    label="Date"
    name="date"
    type="date"
    icon="ph-calendar"
/>
```

### Select
```php
<x-premium.select
    label="Statut"
    name="statut"
    icon="ph-check-circle"
    placeholder="Choisir un statut"
    required
    :error="$errors->first('statut')"
>
    <option value="actif">Actif</option>
    <option value="repos">Repos</option>
    <option value="absent">Absent</option>
</x-premium.select>
```

### Textarea
```php
<div>
    <label class="block text-sm font-medium text-gray-400 mb-2">
        Description
    </label>
    <textarea
        name="description"
        rows="4"
        class="w-full px-4 py-2.5 bg-navy-900/50 border border-navy-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all resize-none"
        placeholder="Votre description..."></textarea>
</div>
```

### Table Complète
```php
<x-premium.table :headers="['Agent', 'Contact', 'Statut', 'Actions']">
    <x-slot name="title">
        <h3 class="text-lg font-bold text-white">Liste des Agents</h3>
    </x-slot>

    @forelse($agents as $agent)
        <tr class="hover:bg-navy-800/30 transition-colors">
            <td class="px-6 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">MA</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ $agent->nom }}</p>
                        <p class="text-xs text-gray-400">{{ $agent->matricule }}</p>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4">
                <p class="text-sm text-gray-300">{{ $agent->email }}</p>
            </td>
            <td class="px-6 py-4">
                <x-premium.badge type="success">Actif</x-premium.badge>
            </td>
            <td class="px-6 py-4">
                <div class="flex space-x-2">
                    <a href="#" class="p-2 bg-primary-500/10 border border-primary-500/20 text-primary-400 rounded-lg hover:bg-primary-500/20 transition-colors">
                        <i class="ph ph-eye"></i>
                    </a>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="px-6 py-12">
                <x-premium.empty-state
                    icon="ph-users"
                    title="Aucun agent"
                    description="Commencez par ajouter un agent"
                />
            </td>
        </tr>
    @endforelse

    <x-slot name="footer">
        {{ $agents->links('vendor.pagination.premium') }}
    </x-slot>
</x-premium.table>
```

### Empty State
```php
<x-premium.empty-state
    icon="ph-folder-open"
    title="Aucune donnée disponible"
    description="Il n'y a rien à afficher pour le moment"
    :action="route('create')"
    actionText="Créer un élément"
/>
```

### Loading Skeleton
```php
<!-- Loading Cards -->
<x-premium.loading-skeleton type="card" :count="3" />

<!-- Loading Table -->
<x-premium.loading-skeleton type="table" :count="5" />

<!-- Loading Stats -->
<x-premium.loading-skeleton type="stat" :count="4" />
```

---

## 🎨 Classes CSS Utiles

### Layout
```html
<!-- Container -->
<div class="max-w-7xl mx-auto px-6">

<!-- Grid 2 colonnes -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<!-- Grid 3 colonnes -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

<!-- Grid 4 colonnes -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

<!-- Flex center -->
<div class="flex items-center justify-center">

<!-- Flex between -->
<div class="flex items-center justify-between">
```

### Spacing
```html
<!-- Margins -->
mb-4 mb-6 mb-8  (16px, 24px, 32px)
mt-4 mt-6 mt-8
mx-auto (center horizontal)

<!-- Padding -->
p-4 p-6 p-8
px-4 py-6
```

### Typography
```html
<!-- Titres -->
<h1 class="text-2xl font-bold text-white">
<h2 class="text-xl font-semibold text-white">
<h3 class="text-lg font-medium text-white">

<!-- Corps -->
<p class="text-sm text-gray-300">
<p class="text-xs text-gray-400">

<!-- Uppercase -->
<span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
```

### Colors
```html
<!-- Text -->
text-white text-gray-300 text-gray-400 text-gray-500
text-primary-400 text-primary-500
text-emerald-400 text-red-400 text-amber-400

<!-- Background -->
bg-navy-900 bg-navy-800 bg-navy-700
bg-primary-500 bg-emerald-500 bg-red-500

<!-- Gradients -->
bg-gradient-to-r from-primary-500 to-primary-600
bg-gradient-to-br from-blue-500/20 to-blue-600/20
```

### Borders & Radius
```html
<!-- Borders -->
border border-navy-700/50
border border-primary-500/20
border-b border-navy-800/50

<!-- Radius -->
rounded-lg rounded-xl rounded-2xl rounded-full
```

### Effects
```html
<!-- Glass -->
glass-effect
glass-strong

<!-- Hover -->
hover:bg-navy-800/30
hover:text-white
hover:scale-105
hover-lift
hover-glow

<!-- Transition -->
transition-all duration-200
transition-colors duration-200
transition-transform duration-200

<!-- Shadow -->
shadow-premium
shadow-premium-lg
shadow-glow
shadow-glow-sm
```

---

## 🎯 Patterns Courants

### Grid de Stats
```html
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Stat 1 -->
    <div class="glass-effect rounded-2xl p-6 border border-navy-800/50">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Total</p>
                <h3 class="text-3xl font-bold text-white mt-2">150</h3>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-blue-600/20 rounded-xl flex items-center justify-center">
                <i class="ph-bold ph-users text-blue-400 text-2xl"></i>
            </div>
        </div>
    </div>
    <!-- Répéter pour chaque stat -->
</div>
```

### Filtres de Recherche
```html
<div class="glass-effect rounded-2xl p-6 mb-6 border border-navy-800/50">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Search -->
        <div class="md:col-span-2">
            <x-premium.input
                name="search"
                icon="ph-magnifying-glass"
                placeholder="Rechercher..."
            />
        </div>

        <!-- Filter -->
        <x-premium.select name="status" icon="ph-funnel">
            <option value="">Tous</option>
            <option value="actif">Actif</option>
        </x-premium.select>

        <!-- Submit -->
        <x-premium.button type="primary">
            Filtrer
        </x-premium.button>
    </form>
</div>
```

### Action Buttons Group
```html
<div class="flex items-center space-x-4">
    <a href="#" class="inline-flex items-center space-x-2 px-6 py-3 bg-navy-800/50 border border-navy-700/50 text-gray-300 hover:text-white rounded-xl font-medium transition-all">
        <i class="ph ph-x"></i>
        <span>Annuler</span>
    </a>

    <button type="submit" class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-medium transition-all transform hover:scale-105 shadow-lg">
        <i class="ph-bold ph-check-circle"></i>
        <span>Enregistrer</span>
    </button>
</div>
```

### Avatar avec Initiales
```html
<div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center">
    <span class="text-white font-bold text-sm">MD</span>
</div>
```

---

## 🔔 Notifications

### Controller
```php
// Success
return redirect()->route('agents.index')
    ->with('success', 'Agent créé avec succès');

// Error
return back()->with('error', 'Une erreur est survenue');

// Warning
return back()->with('warning', 'Attention requise');

// Info
return back()->with('info', 'Information importante');
```

### JavaScript
```javascript
showToast('Message de succès', 'success');
showToast('Message d'erreur', 'error');
showToast('Message d'avertissement', 'warning');
showToast('Message d'information', 'info');
```

---

## 🎨 Icônes Phosphor

### Exemples courants
```html
<i class="ph-bold ph-users-three"></i>         <!-- Users -->
<i class="ph-bold ph-plus-circle"></i>         <!-- Add -->
<i class="ph-bold ph-check-circle"></i>        <!-- Success -->
<i class="ph-bold ph-warning"></i>             <!-- Warning -->
<i class="ph-bold ph-x-circle"></i>            <!-- Error -->
<i class="ph-bold ph-eye"></i>                 <!-- View -->
<i class="ph-bold ph-pencil-simple"></i>       <!-- Edit -->
<i class="ph-bold ph-trash"></i>               <!-- Delete -->
<i class="ph-bold ph-download"></i>            <!-- Download -->
<i class="ph-bold ph-upload"></i>              <!-- Upload -->
<i class="ph-bold ph-calendar"></i>            <!-- Calendar -->
<i class="ph-bold ph-clock"></i>               <!-- Time -->
<i class="ph-bold ph-map-pin"></i>             <!-- Location -->
<i class="ph-bold ph-phone"></i>               <!-- Phone -->
<i class="ph-bold ph-envelope"></i>            <!-- Email -->
<i class="ph-bold ph-buildings"></i>           <!-- Buildings -->
<i class="ph-bold ph-shield-check"></i>        <!-- Security -->
```

Toutes les icônes : https://phosphoricons.com/

---

## ⚡ Performance Tips

- Utilisez `defer` pour Alpine.js (déjà fait)
- Lazy load les images : `loading="lazy"`
- Utilisez les composants pour éviter la duplication
- Compilez en production : `npm run build`
- Activez le cache Laravel : `php artisan optimize`

---

## 🐛 Debugging

```bash
# Vider les caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Recompiler les assets
npm run build

# Voir les erreurs Tailwind
npm run dev  # et regardez la console
```

---

Consultez **[PREMIUM_UI_GUIDE.md](PREMIUM_UI_GUIDE.md)** pour la documentation complète.
