# 🔄 Guide de Migration - Ancien Design → Premium

## Migration Rapide en 5 Étapes

---

## 🎯 Étape 1 : Changer le Layout

### Avant (Ancien)
```php
@extends('layouts.admin')
```

### Après (Premium)
```php
@extends('layouts.premium')
```

---

## 🎯 Étape 2 : Adapter la Section Header

### Avant
```php
@section('content_header')
<h1>Gestion des Agents</h1>
@endsection
```

### Après
```php
@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Gestion des Agents</h1>
            <p class="text-sm text-gray-400 mt-1">{{ $agents->total() }} agents</p>
        </div>
        <a href="{{ route('agents.create') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
            <i class="ph-bold ph-plus-circle"></i>
            <span>Nouvel Agent</span>
        </a>
    </div>
@endsection
```

---

## 🎯 Étape 3 : Convertir les Cards Bootstrap → Premium

### Avant (Bootstrap)
```php
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste des Agents</h3>
    </div>
    <div class="card-body">
        <!-- Contenu -->
    </div>
</div>
```

### Après (Premium)
```php
<x-premium.card title="Liste des Agents" icon="ph-users-three">
    <!-- Contenu -->
</x-premium.card>
```

---

## 🎯 Étape 4 : Convertir les Tableaux

### Avant (Bootstrap)
```php
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($agents as $agent)
        <tr>
            <td>{{ $agent->nom }}</td>
            <td>{{ $agent->email }}</td>
            <td>
                <span class="badge bg-success">Actif</span>
            </td>
            <td>
                <a href="#" class="btn btn-sm btn-primary">Voir</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
```

### Après (Premium)
```php
<x-premium.table :headers="['Agent', 'Contact', 'Statut', 'Actions']">
    @foreach($agents as $agent)
        <tr class="hover:bg-navy-800/30 transition-colors duration-200">
            <!-- Agent Info -->
            <td class="px-6 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">
                            {{ strtoupper(substr($agent->prenom, 0, 1) . substr($agent->nom, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ $agent->prenom }} {{ $agent->nom }}</p>
                        <p class="text-xs text-gray-400">{{ $agent->matricule }}</p>
                    </div>
                </div>
            </td>

            <!-- Contact -->
            <td class="px-6 py-4">
                <p class="text-sm text-gray-300">{{ $agent->email }}</p>
                <p class="text-xs text-gray-400">{{ $agent->telephone }}</p>
            </td>

            <!-- Status Badge -->
            <td class="px-6 py-4">
                <x-premium.badge type="success" icon="ph-check-circle">
                    Actif
                </x-premium.badge>
            </td>

            <!-- Actions -->
            <td class="px-6 py-4">
                <div class="flex items-center justify-end space-x-2">
                    <a href="{{ route('agents.show', $agent) }}"
                       class="p-2 bg-primary-500/10 hover:bg-primary-500/20 border border-primary-500/20 text-primary-400 rounded-lg transition-colors duration-200">
                        <i class="ph ph-eye"></i>
                    </a>
                    <a href="{{ route('agents.edit', $agent) }}"
                       class="p-2 bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/20 text-amber-400 rounded-lg transition-colors duration-200">
                        <i class="ph ph-pencil-simple"></i>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
</x-premium.table>
```

---

## 🎯 Étape 5 : Convertir les Badges

### Avant (Bootstrap)
```php
<span class="badge bg-success">Actif</span>
<span class="badge bg-danger">Absent</span>
<span class="badge bg-warning">Repos</span>
```

### Après (Premium)
```php
<x-premium.badge type="success" icon="ph-check-circle">Actif</x-premium.badge>
<x-premium.badge type="danger" icon="ph-warning">Absent</x-premium.badge>
<x-premium.badge type="warning" icon="ph-moon">Repos</x-premium.badge>
```

---

## 📋 Tableau de Conversion Rapide

| Ancien (Bootstrap/AdminLTE) | Nouveau (Premium) |
|----------------------------|------------------|
| `.card` | `<x-premium.card>` |
| `.badge bg-success` | `<x-premium.badge type="success">` |
| `.btn btn-primary` | `<x-premium.button type="primary">` |
| `.table` | `<x-premium.table>` |
| `<input class="form-control">` | `<x-premium.input>` |
| `<select class="form-select">` | `<x-premium.select>` |

---

## 🎨 Conversion des Classes CSS

### Layout & Containers
| Ancien | Nouveau |
|--------|---------|
| `.container` | `max-w-7xl mx-auto` |
| `.row` | `grid grid-cols-12` |
| `.col-md-6` | `col-span-6` |
| `.d-flex` | `flex` |
| `.justify-content-between` | `justify-between` |
| `.align-items-center` | `items-center` |

### Spacing
| Ancien | Nouveau |
|--------|---------|
| `.mb-3` | `mb-4` ou `mb-6` |
| `.p-3` | `p-4` ou `p-6` |
| `.mt-5` | `mt-8` |

### Colors
| Ancien | Nouveau |
|--------|---------|
| `.text-primary` | `text-primary-500` |
| `.bg-success` | `bg-emerald-500` |
| `.bg-danger` | `bg-red-500` |
| `.text-white` | `text-white` ✅ |
| `.text-muted` | `text-gray-400` |

### Borders & Radius
| Ancien | Nouveau |
|--------|---------|
| `.rounded` | `rounded-xl` |
| `.border` | `border border-navy-700/50` |
| `.shadow` | `shadow-premium` |

---

## 🔄 Exemple Complet de Migration

### AVANT - Ancienne Page Agents
```php
@extends('layouts.admin')

@section('content_header')
    <h1>Gestion des Agents</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalAgents }}</h3>
                <p>Total Agents</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste</h3>
        <a href="{{ route('agents.create') }}" class="btn btn-primary btn-sm float-right">
            Ajouter
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($agents as $agent)
                <tr>
                    <td>{{ $agent->nom }}</td>
                    <td><span class="badge bg-success">Actif</span></td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary">Voir</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
```

### APRÈS - Nouvelle Page Premium
```php
@extends('layouts.premium')

@section('title', 'Gestion des Agents')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Gestion des Agents</h1>
            <p class="text-sm text-gray-400 mt-1">{{ $agents->total() }} agents au total</p>
        </div>
        <a href="{{ route('agents.create') }}"
           class="inline-flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
            <i class="ph-bold ph-plus-circle"></i>
            <span>Nouvel Agent</span>
        </a>
    </div>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="glass-effect rounded-2xl p-6 border border-navy-800/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $totalAgents }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-blue-600/20 rounded-xl flex items-center justify-center">
                    <i class="ph-bold ph-users-three text-blue-400 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <x-premium.table :headers="['Agent', 'Statut', 'Actions']">
        <x-slot name="title">
            <h3 class="text-lg font-bold text-white">Liste des Agents</h3>
        </x-slot>

        @foreach($agents as $agent)
            <tr class="hover:bg-navy-800/30 transition-colors duration-200">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">
                                {{ strtoupper(substr($agent->nom, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">{{ $agent->nom }}</p>
                            <p class="text-xs text-gray-400">{{ $agent->matricule }}</p>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4">
                    <x-premium.badge type="success" icon="ph-check-circle">
                        Actif
                    </x-premium.badge>
                </td>

                <td class="px-6 py-4">
                    <div class="flex items-center justify-end space-x-2">
                        <a href="{{ route('agents.show', $agent) }}"
                           class="p-2 bg-primary-500/10 hover:bg-primary-500/20 border border-primary-500/20 text-primary-400 rounded-lg transition-colors duration-200">
                            <i class="ph ph-eye"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-premium.table>
@endsection
```

---

## 📝 Checklist de Migration

Pour chaque page à migrer :

- [ ] Changer `@extends('layouts.admin')` → `@extends('layouts.premium')`
- [ ] Adapter la section `@section('header')`
- [ ] Remplacer les `.card` par `<x-premium.card>`
- [ ] Convertir les badges Bootstrap → `<x-premium.badge>`
- [ ] Remplacer les boutons → `<x-premium.button>`
- [ ] Moderniser les tableaux avec `<x-premium.table>`
- [ ] Mettre à jour les formulaires avec `<x-premium.input>` / `<x-premium.select>`
- [ ] Ajouter des stats cards en haut si pertinent
- [ ] Tester la page sur mobile
- [ ] Vérifier les toasts notifications

---

## 🎨 Tips & Best Practices

### 1. Utilisez les composants au maximum
```php
// ❌ Éviter
<div class="px-4 py-2 bg-blue-500 text-white rounded">Bouton</div>

// ✅ Préférer
<x-premium.button type="primary">Bouton</x-premium.button>
```

### 2. Profitez des classes utilitaires
```php
// Spacing harmonisé
mb-4, mb-6, mb-8 (4, 6, 8 = 16px, 24px, 32px)

// Rounded harmonisé
rounded-xl (cards), rounded-2xl (containers), rounded-full (avatars)

// Shadows
shadow-premium, shadow-glow
```

### 3. Empty States
```php
@forelse($agents as $agent)
    <!-- Contenu -->
@empty
    <x-premium.empty-state
        icon="ph-users"
        title="Aucun agent"
        description="Commencez par ajouter votre premier agent"
        :action="route('agents.create')"
        actionText="Ajouter un agent"
    />
@endforelse
```

### 4. Loading States
```php
@if($loading)
    <x-premium.loading-skeleton type="table" :count="5" />
@else
    <!-- Vos données -->
@endif
```

---

## 🚀 Migration Batch

Pour migrer toutes vos pages rapidement :

```bash
# 1. Dashboard
cp resources/views/dashboard.blade.php resources/views/dashboard.old.blade.php
cp resources/views/dashboard-premium.blade.php resources/views/dashboard.blade.php

# 2. Agents
cp resources/views/agents/index.blade.php resources/views/agents/index.old.blade.php
cp resources/views/agents/index-premium.blade.php resources/views/agents/index.blade.php

# 3. Créer les autres pages sur le même modèle
```

---

## 💡 Support

Si vous rencontrez des difficultés :

1. Consultez `PREMIUM_UI_GUIDE.md`
2. Regardez les exemples dans :
   - `dashboard-premium.blade.php`
   - `agents/index-premium.blade.php`
   - `agents/create-premium.blade.php`
3. Testez dans le navigateur avec l'inspecteur

---

**🎉 Bonne migration !**
